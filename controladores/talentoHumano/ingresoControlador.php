<?php
// controladores/talentoHumano/ingresoControlador.php
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
require_once __DIR__ . '/../../modelos/ingresoModelo.php';
require_once __DIR__ . '/../../servicios/correoServicio.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$ingresoModelo   = new IngresoModelo($conexion);

$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id          = (int)$perfil['nivel_acceso'];
$rol_nombre      = $perfil['rol_nombre'] ?? 'Usuario';
$esSuperUsuario  = ($rol_id === 1);
$esGestionHumana = ($rol_id === 2);
$esEmpleado      = ($rol_id === 3);

// Roles que pueden gestionar y auditar solicitudes de todos los aspirantes
$puedeGestionarIngresos = ($esSuperUsuario || $esGestionHumana);

$mensajeExito = '';
$mensajeError = '';

// 2. Procesamiento de formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = trim($_POST['accion'] ?? '');

    if ($accion === 'crear_solicitud_ingreso') {
        $nombre_candidato = trim($_POST['nombre_candidato'] ?? '');
        $tipo_documento   = trim($_POST['tipo_documento'] ?? 'C.C.');
        $cedula           = trim($_POST['cedula'] ?? '');
        $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
        $direccion        = trim($_POST['direccion'] ?? '');
        $ciudad           = trim($_POST['ciudad'] ?? 'Bogotá');
        $celular          = trim($_POST['celular'] ?? '');
        $email_candidato  = trim($_POST['email_candidato'] ?? '');
        $cargo            = trim($_POST['cargo'] ?? '');
        $area             = trim($_POST['area'] ?? '');
        $sede             = trim($_POST['sede'] ?? 'Sede Principal');
        $tipo_contrato    = trim($_POST['tipo_contrato'] ?? 'Término Indefinido');
        $salario          = trim($_POST['salario'] ?? '');
        $fecha_ingreso    = trim($_POST['fecha_ingreso'] ?? '');
        $horario_trabajo  = trim($_POST['horario_trabajo'] ?? 'Lunes a Viernes 7:30 am - 5:30 pm');
        $jefe_inmediato   = trim($_POST['jefe_inmediato'] ?? '');

        // Requerimientos técnicos y dotación
        $requiere_computador   = (isset($_POST['requiere_computador']) && $_POST['requiere_computador'] === 'si') ? 'si' : 'no';
        $tipo_computador       = trim($_POST['tipo_computador'] ?? 'Portátil');
        $requiere_correo       = (isset($_POST['requiere_correo']) && $_POST['requiere_correo'] === 'si') ? 'si' : 'no';
        $requiere_celular_corp = (isset($_POST['requiere_celular_corp']) && $_POST['requiere_celular_corp'] === 'si') ? 'si' : 'no';
        $requiere_dotacion     = (isset($_POST['requiere_dotacion']) && $_POST['requiere_dotacion'] === 'si') ? 'si' : 'no';
        $tallas_dotacion       = trim($_POST['tallas_dotacion'] ?? '');
        $observaciones         = trim($_POST['observaciones'] ?? '');

        // Áreas a notificar
        $areasSeleccionadas = $_POST['areas_notificar'] ?? [];
        $correosExtra       = trim($_POST['correos_adicionales'] ?? '');

        // Validación de campos mandatorios
        if (empty($nombre_candidato) || empty($cedula) || empty($email_candidato) || empty($cargo) || empty($area) || empty($fecha_ingreso)) {
            $mensajeError = "Por favor complete todos los campos obligatorios marcados con asterisco (*).";
        } elseif (!filter_var($email_candidato, FILTER_VALIDATE_EMAIL)) {
            $mensajeError = "El correo electrónico del candidato no es válido.";
        } else {
            // Mapeo de correos electrónicos de áreas corporativas INEES
            $mapaCorreosAreas = [
                'gestion_humana' => ['talento@inees.co'],
                'sistemas_ti'    => ['Desarrollo2@inees.co', 'desarrollo1@inees.co'],
                'contabilidad'   => ['contador@inees.co'],
                'operaciones'    => ['operaciones@inees.co', 'auxadministrativo@inees.co'],
                'calidad'        => ['calidad@inees.co']
            ];

            $destinatariosAreas = [];
            foreach ($areasSeleccionadas as $k) {
                if (isset($mapaCorreosAreas[$k])) {
                    foreach ($mapaCorreosAreas[$k] as $emailArea) {
                        if (!in_array($emailArea, $destinatariosAreas)) {
                            $destinatariosAreas[] = $emailArea;
                        }
                    }
                }
            }

            // Agregar correo del usuario en sesión (Camila o Admin) si tiene email
            if (!empty($perfil['email']) && !in_array($perfil['email'], $destinatariosAreas)) {
                $destinatariosAreas[] = $perfil['email'];
            }

            // Agregar correos adicionales manuales
            if (!empty($correosExtra)) {
                $extras = explode(',', $correosExtra);
                foreach ($extras as $ex) {
                    $exClean = trim($ex);
                    if (filter_var($exClean, FILTER_VALIDATE_EMAIL) && !in_array($exClean, $destinatariosAreas)) {
                        $destinatariosAreas[] = $exClean;
                    }
                }
            }

            $datosParaInsertar = [
                'solicitante_id'          => $usuario_id,
                'nombre_solicitante'       => $perfil['nombre'],
                'nombre_candidato'         => $nombre_candidato,
                'tipo_documento'           => $tipo_documento,
                'cedula'                   => $cedula,
                'fecha_nacimiento'         => $fecha_nacimiento,
                'direccion'                => $direccion,
                'ciudad'                   => $ciudad,
                'celular'                  => $celular,
                'email_candidato'          => $email_candidato,
                'cargo'                    => $cargo,
                'area'                     => $area,
                'sede'                     => $sede,
                'tipo_contrato'            => $tipo_contrato,
                'salario'                  => $salario,
                'fecha_ingreso'            => $fecha_ingreso,
                'horario_trabajo'          => $horario_trabajo,
                'jefe_inmediato'           => $jefe_inmediato,
                'requiere_computador'      => $requiere_computador,
                'tipo_computador'          => $tipo_computador,
                'requiere_correo'          => $requiere_correo,
                'requiere_celular_corp'    => $requiere_celular_corp,
                'requiere_dotacion'        => $requiere_dotacion,
                'tallas_dotacion'          => $tallas_dotacion,
                'areas_notificadas'        => implode(', ', $areasSeleccionadas),
                'correos_notificados'      => implode(', ', $destinatariosAreas),
                'observaciones'            => $observaciones
            ];

            try {
                $nuevoId = $ingresoModelo->crearSolicitud($datosParaInsertar);

                // 1. Envío de Correo de Bienvenida al nuevo colaborador
                CorreoServicio::enviarCorreoBienvenida($datosParaInsertar);

                // 2. Envío de Notificación de Alistamiento a las Áreas requeridas
                if (!empty($destinatariosAreas)) {
                    CorreoServicio::enviarNotificacionAreas($datosParaInsertar, $destinatariosAreas);
                }

                header("Location: ingresoControlador.php?exito=1&id={$nuevoId}");
                exit;
            } catch (Exception $e) {
                $mensajeError = "Error al radicar la solicitud de ingreso: " . $e->getMessage();
            }
        }
    }

    if ($accion === 'actualizar_estado' && $puedeGestionarIngresos) {
        $solId = (int)($_POST['solicitud_id'] ?? 0);
        $nuevoEstado = trim($_POST['nuevo_estado'] ?? 'en_proceso');
        if ($solId > 0 && in_array($nuevoEstado, ['pendiente', 'en_proceso', 'contratado', 'cancelado'])) {
            $ingresoModelo->actualizarEstado($solId, $nuevoEstado);
            header("Location: ingresoControlador.php?actualizado=1&id={$solId}");
            exit;
        }
    }
}

// 3. Mensajes flash
if (isset($_GET['exito'])) {
    $mensajeExito = "¡Solicitud de Ingreso #" . htmlspecialchars($_GET['id'] ?? '') . " radicada con éxito! El proceso entrará en revisión por Gestión Humana.";
} elseif (isset($_GET['actualizado'])) {
    $mensajeExito = "El estado de la solicitud de ingreso fue actualizado correctamente.";
}

// 4. Datos para la vista
$listaSolicitudes = $puedeGestionarIngresos ? $ingresoModelo->obtenerSolicitudes() : [];
$estadisticas     = $puedeGestionarIngresos ? $ingresoModelo->obtenerEstadisticas() : null;

// Solicitud seleccionada para ver detalles
$solicitudDetalle = null;
if ($puedeGestionarIngresos) {
    $verId = isset($_GET['ver_id']) ? (int)$_GET['ver_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
    if ($verId > 0) {
        $solicitudDetalle = $ingresoModelo->obtenerSolicitudPorId($verId);
    }
}

// 5. Cargar vista
require_once __DIR__ . '/../../vistas/talentoHumano/ingresoVista.php';
