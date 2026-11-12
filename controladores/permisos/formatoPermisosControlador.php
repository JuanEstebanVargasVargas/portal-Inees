<?php
// controladores/permisos/formatoPermisosControlador.php
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
require_once __DIR__ . '/../../modelos/permisoModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$permisoModelo   = new PermisoModelo($conexion);

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

// El historial y la vista de formato físico oficial son exclusivos de Gestión Humana (y SuperUsuario)
$puedeVerHistorialYFormato = ($esSuperUsuario || $esGestionHumana);

$mensajeExito = '';
$mensajeError = '';

// 2. Procesamiento de peticiones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = trim($_POST['accion'] ?? '');

    // Acción: Radicar nueva solicitud de permiso
    if ($accion === 'crear_permiso') {
        $nombre_empleado   = trim($_POST['nombre_empleado'] ?? $perfil['nombre']);
        $cedula            = trim($_POST['cedula'] ?? $perfil['cedula']);
        $cargo             = trim($_POST['cargo'] ?? $perfil['cargo']);
        $departamento_area = trim($_POST['departamento_area'] ?? $perfil['area']);
        $detalle_permiso   = trim($_POST['detalle_permiso'] ?? '');
        $fecha_solicitud   = trim($_POST['fecha_solicitud'] ?? date('Y-m-d'));
        $motivo_permiso    = trim($_POST['motivo_permiso'] ?? '');
        $fecha_desde       = trim($_POST['fecha_desde'] ?? '');
        $fecha_hasta       = trim($_POST['fecha_hasta'] ?? '');
        $hora_desde        = trim($_POST['hora_desde'] ?? '');
        $hora_hasta        = trim($_POST['hora_hasta'] ?? '');
        $es_remunerado     = (isset($_POST['es_remunerado']) && $_POST['es_remunerado'] === 'si') ? 'si' : 'no';
        $firma_empleado    = trim($_POST['firma_empleado'] ?? $nombre_empleado);

        if (empty($nombre_empleado) || empty($cedula) || empty($detalle_permiso) || empty($motivo_permiso) || empty($fecha_desde) || empty($fecha_hasta)) {
            $mensajeError = 'Por favor complete todos los campos obligatorios del formulario.';
        } else {
            try {
                $nuevoId = $permisoModelo->crearPermiso([
                    'usuario_id'        => $usuario_id,
                    'codigo_formato'    => 'GTH-05-01',
                    'version_formato'   => '1',
                    'nombre_empleado'   => $nombre_empleado,
                    'cedula'            => $cedula,
                    'cargo'             => $cargo,
                    'departamento_area' => $departamento_area,
                    'detalle_permiso'   => $detalle_permiso,
                    'fecha_solicitud'   => $fecha_solicitud,
                    'motivo_permiso'    => $motivo_permiso,
                    'fecha_desde'       => $fecha_desde,
                    'fecha_hasta'       => $fecha_hasta,
                    'hora_desde'        => $hora_desde,
                    'hora_hasta'        => $hora_hasta,
                    'es_remunerado'     => $es_remunerado,
                    'firma_empleado'    => $firma_empleado
                ]);

                header("Location: formatoPermisosControlador.php?exito=1&id={$nuevoId}");
                exit;
            } catch (Exception $e) {
                $mensajeError = 'Error al registrar el permiso: ' . $e->getMessage();
            }
        }
    }

    // Acción: Aprobación Jefe Inmediato
    if ($accion === 'aprobar_jefe' && ($esSuperUsuario || $esGestionHumana)) {
        $permisoId          = (int)($_POST['permiso_id'] ?? 0);
        $estadoJefe         = trim($_POST['estado_jefe'] ?? 'pendiente');
        $nombreJefe         = trim($_POST['jefe_nombre'] ?? $perfil['nombre']);
        $observacionesJefe  = trim($_POST['observaciones_jefe'] ?? '');
        $fechaFirmaJefe     = trim($_POST['fecha_firma_jefe'] ?? date('Y-m-d'));

        if ($permisoId > 0 && in_array($estadoJefe, ['aprobado', 'no_aprueba', 'pendiente'])) {
            $permisoModelo->actualizarAprobacionJefe($permisoId, $estadoJefe, $nombreJefe, $observacionesJefe, $fechaFirmaJefe);
            header("Location: formatoPermisosControlador.php?actualizado=1&id={$permisoId}");
            exit;
        }
    }

    // Acción: Gestión Talento Humano / Recursos Humanos
    if ($accion === 'gestion_rh' && ($esSuperUsuario || $esGestionHumana)) {
        $permisoId        = (int)($_POST['permiso_id'] ?? 0);
        $estadoRH         = trim($_POST['estado_rh'] ?? 'recibido');
        $recibidoPorRH    = trim($_POST['recibido_por_rh'] ?? $perfil['nombre']);
        $fechaRegistroRH  = trim($_POST['fecha_registro_rh'] ?? date('Y-m-d'));
        $observacionesRH  = trim($_POST['observaciones_rh'] ?? '');

        if ($permisoId > 0) {
            $permisoModelo->actualizarGestionHumana($permisoId, $estadoRH, $recibidoPorRH, $fechaRegistroRH, $observacionesRH);
            header("Location: formatoPermisosControlador.php?actualizado=1&id={$permisoId}");
            exit;
        }
    }

    // Acción: Eliminar solicitud
    if ($accion === 'eliminar_permiso') {
        $permisoId = (int)($_POST['permiso_id'] ?? 0);
        if ($permisoId > 0) {
            $permisoModelo->eliminarPermiso($permisoId, $usuario_id, ($esSuperUsuario || $esGestionHumana));
            header("Location: formatoPermisosControlador.php?eliminado=1");
            exit;
        }
    }
}

// Mensajes flash
if (isset($_GET['exito'])) {
    $mensajeExito = "¡Solicitud de permiso radicada con éxito (ID: #" . htmlspecialchars($_GET['id'] ?? '') . ")!";
} elseif (isset($_GET['actualizado'])) {
    $mensajeExito = "¡Estado de la solicitud actualizado correctamente!";
} elseif (isset($_GET['eliminado'])) {
    $mensajeExito = "La solicitud fue eliminada correctamente.";
}

// Solicitud seleccionada y listado exclusivo para Gestión Humana (y SuperUsuario)
$permisoSeleccionado = null;
$listaPermisos       = [];

if ($puedeVerHistorialYFormato) {
    $verId = isset($_GET['ver_id']) ? (int)$_GET['ver_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
    if ($verId > 0) {
        $permisoSeleccionado = $permisoModelo->obtenerPermisoPorId($verId);
    }
    $listaPermisos = $permisoModelo->obtenerTodosLosPermisos();
}

// Cargar vista
require_once __DIR__ . '/../../vistas/permisos/formatoPermisosVista.php';
