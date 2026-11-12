<?php
// controladores/talentoHumano/incapacidadesControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Control de acceso
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';
require_once __DIR__ . '/../../modelos/incapacidadModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo   = new DashboardModelo($conexion);
$incapacidadModelo = new IncapacidadModelo($conexion);

$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id          = (int)$perfil['nivel_acceso'];
$rol_nombre      = $perfil['rol_nombre'] ?? 'Usuario';
$esSuperUsuario  = ($rol_id === 1);
$esGestionHumana = ($rol_id === 2); // Rol de Camila
$esEmpleado      = ($rol_id === 3);

$puedeGestionarIncapacidades = ($esSuperUsuario || $esGestionHumana);

$mensajeExito = '';
$mensajeError = '';

// 2. Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = trim($_POST['accion'] ?? '');

    // ── ACCIÓN: Cargar / Radicar nueva incapacidad ──
    if ($accion === 'cargar_incapacidad') {
        // Determinación del usuario al que pertenece la incapacidad
        $targetUsuarioId = $usuario_id;
        $targetNombre    = $perfil['nombre'];
        $targetCedula    = $perfil['cedula'];
        $targetCargo     = $perfil['cargo'];
        $targetArea      = $perfil['area'];

        // Si Camila o SuperUsuario registran a nombre de otro usuario
        if ($puedeGestionarIncapacidades && !empty($_POST['empleado_seleccionado_id'])) {
            $selId = (int)$_POST['empleado_seleccionado_id'];
            $empSel = $dashboardModelo->obtenerUsuarioPorId($selId);
            if ($empSel) {
                $targetUsuarioId = $selId;
                $targetNombre    = $empSel['nombre'];
                $targetCedula    = $empSel['cedula'];
                $targetCargo     = $empSel['cargo'];
                $targetArea      = $empSel['area'];
            }
        }

        $tipo_incapacidad       = trim($_POST['tipo_incapacidad'] ?? 'Enfermedad General');
        $eps                    = trim($_POST['eps'] ?? '');
        $codigo_cie10           = trim($_POST['codigo_cie10'] ?? '');
        $descripcion_diagnostico= trim($_POST['descripcion_diagnostico'] ?? '');
        $fecha_inicio           = trim($_POST['fecha_inicio'] ?? '');
        $fecha_fin              = trim($_POST['fecha_fin'] ?? '');
        $es_prorroga            = (isset($_POST['es_prorroga']) && $_POST['es_prorroga'] === 'si') ? 'si' : 'no';
        $observaciones_empleado = trim($_POST['observaciones_empleado'] ?? '');

        // Validación de fechas y cálculo de días
        if (empty($eps) || empty($fecha_inicio) || empty($fecha_fin)) {
            $mensajeError = "Por favor complete los campos obligatorios (EPS, Fecha Inicio y Fecha Fin).";
        } elseif ($fecha_fin < $fecha_inicio) {
            $mensajeError = "La fecha de fin no puede ser anterior a la fecha de inicio de la incapacidad.";
        } else {
            $tIni = strtotime($fecha_inicio);
            $tFin = strtotime($fecha_fin);
            $dias = max(1, (int)round(($tFin - $tIni) / 86400) + 1);

            // Procesamiento de archivo soporte médico adjunto
            $archivoRelativo = null;
            $nombreOriginal  = null;

            if (isset($_FILES['soporte_medico']) && $_FILES['soporte_medico']['error'] === UPLOAD_ERR_OK) {
                $fileTmp   = $_FILES['soporte_medico']['tmp_name'];
                $fileName  = $_FILES['soporte_medico']['name'];
                $fileSize  = $_FILES['soporte_medico']['size'];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $extensionesPermitidas = ['pdf', 'jpg', 'jpeg', 'png'];

                if (!in_array($extension, $extensionesPermitidas)) {
                    $mensajeError = "Formato de archivo no permitido. Solo se aceptan PDF, JPG o PNG.";
                } elseif ($fileSize > (10 * 1024 * 1024)) { // 10MB
                    $mensajeError = "El archivo adjunto supera el tamaño máximo permitido de 10 MB.";
                } else {
                    $nombreNuevo = 'incap_' . date('Ymd_His') . '_' . uniqid() . '.' . $extension;
                    $carpetaDestino = __DIR__ . '/../../uploads/incapacidades/';
                    if (!is_dir($carpetaDestino)) {
                        @mkdir($carpetaDestino, 0777, true);
                    }
                    $rutaFinal = $carpetaDestino . $nombreNuevo;

                    if (move_uploaded_file($fileTmp, $rutaFinal)) {
                        $archivoRelativo = 'uploads/incapacidades/' . $nombreNuevo;
                        $nombreOriginal  = $fileName;
                    } else {
                        $mensajeError = "No fue posible guardar el archivo adjunto en el servidor.";
                    }
                }
            }

            if (empty($mensajeError)) {
                try {
                    $nuevoId = $incapacidadModelo->crearIncapacidad([
                        'usuario_id'              => $targetUsuarioId,
                        'nombre_empleado'         => $targetNombre,
                        'cedula'                  => $targetCedula,
                        'cargo'                   => $targetCargo,
                        'area'                    => $targetArea,
                        'tipo_incapacidad'        => $tipo_incapacidad,
                        'eps'                     => $eps,
                        'codigo_cie10'            => $codigo_cie10,
                        'descripcion_diagnostico' => $descripcion_diagnostico,
                        'fecha_inicio'            => $fecha_inicio,
                        'fecha_fin'               => $fecha_fin,
                        'dias_incapacidad'        => $dias,
                        'es_prorroga'             => $es_prorroga,
                        'archivo_adjunto'         => $archivoRelativo,
                        'nombre_archivo_original' => $nombreOriginal,
                        'observaciones_empleado'  => $observaciones_empleado
                    ]);

                    header("Location: incapacidadesControlador.php?exito=1&id={$nuevoId}");
                    exit;
                } catch (Exception $e) {
                    $mensajeError = "Error al registrar la incapacidad: " . $e->getMessage();
                }
            }
        }
    }

    // ── ACCIÓN: Gestión / Evidenciación por Camila / Gestión Humana ──
    if ($accion === 'gestionar_incapacidad' && $puedeGestionarIncapacidades) {
        $incapacidadId    = (int)($_POST['incapacidad_id'] ?? 0);
        $nuevoEstado      = trim($_POST['estado'] ?? 'pendiente');
        $observacionesRH  = trim($_POST['observaciones_rh'] ?? '');

        if ($incapacidadId > 0 && in_array($nuevoEstado, ['pendiente', 'aprobada', 'rechazada', 'validada_eps'])) {
            $incapacidadModelo->actualizarGestionRH($incapacidadId, $nuevoEstado, $usuario_id, $perfil['nombre'], $observacionesRH);
            header("Location: incapacidadesControlador.php?actualizado=1&id={$incapacidadId}");
            exit;
        }
    }

    // ── ACCIÓN: Eliminar Incapacidad ──
    if ($accion === 'eliminar_incapacidad') {
        $incapacidadId = (int)($_POST['incapacidad_id'] ?? 0);
        if ($incapacidadId > 0) {
            $incapacidadModelo->eliminarIncapacidad($incapacidadId, $usuario_id, $puedeGestionarIncapacidades);
            header("Location: incapacidadesControlador.php?eliminado=1");
            exit;
        }
    }
}

// 3. Mensajes flash
if (isset($_GET['exito'])) {
    $mensajeExito = "¡Incapacidad cargada con éxito (Radicado #" . htmlspecialchars($_GET['id'] ?? '') . ")! Recursos Humanos revisará el soporte médico.";
} elseif (isset($_GET['actualizado'])) {
    $mensajeExito = "¡Estado de la incapacidad actualizado por Talento Humano correctamente!";
} elseif (isset($_GET['eliminado'])) {
    $mensajeExito = "La incapacidad fue eliminada correctamente.";
}

// 4. Parámetros de filtro
$filtroEstado = isset($_GET['estado']) ? trim($_GET['estado']) : 'todos';
$filtroEps    = isset($_GET['eps']) ? trim($_GET['eps']) : 'todas';
$filtroBusq   = isset($_GET['q']) ? trim($_GET['q']) : null;

// 5. Carga de datos según el rol
if ($puedeGestionarIncapacidades) {
    // Camila o SuperUsuario: Evidenciar todas las incapacidades de todos los usuarios
    $listaIncapacidades = $incapacidadModelo->obtenerTodasLasIncapacidades($filtroEstado, $filtroBusq, $filtroEps);
    $estadisticas       = $incapacidadModelo->obtenerEstadisticas();

    // Listado de colaboradores para selector de carga asistida
    $stmtUsers = $conexion->query("SELECT usuario_id, nombre, cedula, cargo, area FROM usuarios WHERE estado = 'activo' ORDER BY nombre ASC");
    $listaColaboradores = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Empleado: Solo evidencia y gestiona sus propias incapacidades
    $listaIncapacidades = $incapacidadModelo->obtenerIncapacidadesPorUsuario($usuario_id);
    $estadisticas       = $incapacidadModelo->obtenerEstadisticasEmpleado($usuario_id);
    $listaColaboradores = [];
}

// 6. Cargar la vista
require_once __DIR__ . '/../../vistas/talentoHumano/incapacidadesVista.php';
