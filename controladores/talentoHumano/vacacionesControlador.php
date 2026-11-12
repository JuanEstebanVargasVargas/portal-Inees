<?php
// controladores/talentoHumano/vacacionesControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Autenticación
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';
require_once __DIR__ . '/../../modelos/vacacionModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$vacacionModelo  = new VacacionModelo($conexion);

$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id          = (int)$perfil['nivel_acceso'];
$esSuperUsuario  = ($rol_id === 1);
$esGestionHumana = ($rol_id === 2);
$esEmpleado      = ($rol_id === 3);
$puedeGestionar  = ($esSuperUsuario || $esGestionHumana);

$mensajeExito = '';
$mensajeError = '';

// ─────────────────────────────────────────────
// 2. PROCESAMIENTO DE ACCIONES POST
// ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = trim($_POST['accion'] ?? '');

    // ── Solicitar Vacaciones ──────────────────
    if ($accion === 'solicitar_vacaciones') {
        $fecha_inicio          = trim($_POST['fecha_inicio'] ?? '');
        $fecha_fin             = trim($_POST['fecha_fin'] ?? '');
        $fecha_reincorporacion = trim($_POST['fecha_reincorporacion'] ?? '');
        $periodo_causado       = trim($_POST['periodo_causado'] ?? '');
        $observaciones         = trim($_POST['observaciones'] ?? '');

        if (empty($fecha_inicio) || empty($fecha_fin)) {
            $mensajeError = "Las fechas de inicio y fin son obligatorias.";
        } elseif ($fecha_fin < $fecha_inicio) {
            $mensajeError = "La fecha de fin no puede ser anterior a la de inicio.";
        } else {
            // Calcular días
            $tIni = strtotime($fecha_inicio);
            $tFin = strtotime($fecha_fin);
            $dias = max(1, (int)round(($tFin - $tIni) / 86400) + 1);

            // Procesar archivo carta
            if (!isset($_FILES['archivo_carta']) || $_FILES['archivo_carta']['error'] !== UPLOAD_ERR_OK) {
                $mensajeError = "Debes adjuntar la carta de solicitud de vacaciones.";
            } else {
                $fileTmp   = $_FILES['archivo_carta']['tmp_name'];
                $fileName  = $_FILES['archivo_carta']['name'];
                $fileSize  = $_FILES['archivo_carta']['size'];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $extensionesPermitidas = ['pdf', 'jpg', 'jpeg', 'png'];

                if (!in_array($extension, $extensionesPermitidas)) {
                    $mensajeError = "Solo se aceptan archivos PDF, JPG o PNG.";
                } elseif ($fileSize > (10 * 1024 * 1024)) {
                    $mensajeError = "El archivo supera el tamaño máximo de 10 MB.";
                } else {
                    $nombreNuevo    = 'vac_' . date('Ymd_His') . '_' . uniqid() . '.' . $extension;
                    $carpetaDestino = __DIR__ . '/../../uploads/vacaciones/';
                    if (!is_dir($carpetaDestino)) {
                        @mkdir($carpetaDestino, 0777, true);
                    }
                    $rutaFinal = $carpetaDestino . $nombreNuevo;

                    if (!move_uploaded_file($fileTmp, $rutaFinal)) {
                        $mensajeError = "No fue posible guardar el archivo en el servidor.";
                    } else {
                        $archivoRelativo = 'uploads/vacaciones/' . $nombreNuevo;

                        try {
                            $nuevoId = $vacacionModelo->crearSolicitud([
                                'usuario_id'              => $usuario_id,
                                'nombre_empleado'         => $perfil['nombre'],
                                'cedula'                  => $perfil['cedula'],
                                'cargo'                   => $perfil['cargo'],
                                'area'                    => $perfil['area'],
                                'fecha_inicio'            => $fecha_inicio,
                                'fecha_fin'               => $fecha_fin,
                                'fecha_reincorporacion'   => $fecha_reincorporacion,
                                'dias_solicitados'        => $dias,
                                'periodo_causado'         => $periodo_causado,
                                'archivo_carta'           => $archivoRelativo,
                                'nombre_archivo_original' => $fileName,
                                'observaciones'           => $observaciones,
                            ]);
                            header("Location: vacacionesControlador.php?exito=1&id={$nuevoId}");
                            exit;
                        } catch (Exception $e) {
                            $mensajeError = "Error al registrar la solicitud: " . $e->getMessage();
                        }
                    }
                }
            }
        }
    }

    // ── Gestionar (Aprobar / Rechazar) ────────
    if ($accion === 'gestionar_vacacion' && $puedeGestionar) {
        $solicitudId     = (int)($_POST['solicitud_id'] ?? 0);
        $nuevoEstado     = trim($_POST['estado'] ?? '');
        $observacionesRH = trim($_POST['observaciones_rh'] ?? '');

        if ($solicitudId > 0 && in_array($nuevoEstado, ['aprobada', 'rechazada', 'pendiente'])) {
            $vacacionModelo->gestionarSolicitud(
                $solicitudId,
                $nuevoEstado,
                $usuario_id,
                $perfil['nombre'],
                $observacionesRH
            );
            header("Location: vacacionesControlador.php?actualizado=1&id={$solicitudId}");
            exit;
        }
        $mensajeError = "Datos de gestión inválidos.";
    }

    // ── Eliminar ──────────────────────────────
    if ($accion === 'eliminar_vacacion') {
        $solicitudId = (int)($_POST['solicitud_id'] ?? 0);
        if ($solicitudId > 0) {
            $ok = $vacacionModelo->eliminarSolicitud($solicitudId, $usuario_id, $puedeGestionar);
            if ($ok) {
                header("Location: vacacionesControlador.php?eliminado=1");
                exit;
            } else {
                $mensajeError = "No se pudo eliminar la solicitud. Solo puedes eliminar solicitudes pendientes.";
            }
        }
    }
}

// ─────────────────────────────────────────────
// 3. CARGA DE DATOS PARA LA VISTA
// ─────────────────────────────────────────────
$filtroEstado  = trim($_GET['estado'] ?? 'todos');
$filtroBusqueda= trim($_GET['q'] ?? '');

if ($puedeGestionar) {
    $solicitudes = $vacacionModelo->obtenerTodasLasSolicitudes(
        $filtroEstado !== 'todos' ? $filtroEstado : null,
        $filtroBusqueda ?: null
    );
    $estadisticas = $vacacionModelo->contarPorEstado();
} else {
    $solicitudes  = $vacacionModelo->obtenerSolicitudesPorUsuario($usuario_id);
    $estadisticas = null;
}

// Mensajes de retorno GET
if (!empty($_GET['exito'])) {
    $mensajeExito = "✅ Solicitud de vacaciones registrada exitosamente.";
}
if (!empty($_GET['actualizado'])) {
    $mensajeExito = "✅ Solicitud actualizada correctamente.";
}
if (!empty($_GET['eliminado'])) {
    $mensajeExito = "✅ Solicitud eliminada.";
}

// ─────────────────────────────────────────────
// 4. RENDER VISTA
// ─────────────────────────────────────────────
require_once __DIR__ . '/../../vistas/talentoHumano/vacacionesVista.php';
