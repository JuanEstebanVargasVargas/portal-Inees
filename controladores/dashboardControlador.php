<?php
// controladores/dashboardControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Control de acceso: Redirigir al login si no hay sesión activa
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/dashboardModelo.php';
require_once __DIR__ . '/../modelos/publicacionModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo establecer conexión con la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);

// 2. Obtener datos actualizados del usuario desde la base de datos
$usuario_id = (int)$_SESSION['usuario_id'];
$perfil = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header("Location: logout.php");
    exit();
}

// Sincronizar variables de sesión con los datos actuales
$_SESSION['nombre']       = $perfil['nombre'];
$_SESSION['usuario']      = $perfil['usuario'];
$_SESSION['cargo']        = $perfil['cargo'];
$_SESSION['area']         = $perfil['area'];
$_SESSION['nivel_acceso'] = $perfil['nivel_acceso'];
$_SESSION['rol_nombre']   = $perfil['rol_nombre'] ?? 'Usuario';
$_SESSION['foto_perfil']  = $perfil['foto_perfil'] ?? null;

$rol_id     = (int)$perfil['nivel_acceso'];
$rol_nombre = $perfil['rol_nombre'] ?? 'Usuario';

// 3. Control de roles del sistema
$esSuperUsuario   = ($rol_id === 1);
$esGestionHumana  = ($rol_id === 2);
$esEmpleado       = ($rol_id === 3);
$esSistemaGestion = ($rol_id === 5);

// Capacidades por área de gestión
$puedeVerAdmin          = $esSuperUsuario;
$puedeVerGestionHumana  = ($esSuperUsuario || $esGestionHumana);
$puedeVerEmpleado       = true; // Todos los roles tienen acceso a su espacio de labores y perfil
$puedeVerSistemaGestion = ($esSuperUsuario || $esSistemaGestion);

// 4. Obtener módulos y permisos filtrados dinámicamente según el rol
$modulosPorCategoria = $dashboardModelo->obtenerModulosPorRol($rol_id);
$rutasPermitidas     = $dashboardModelo->obtenerListaRutasPermitidas($rol_id);

// Función auxiliar para comprobar permiso de una ruta específica
$tienePermiso = function($nombreRuta) use ($rutasPermitidas) {
    return in_array($nombreRuta, $rutasPermitidas, true);
};

// 5. Estadísticas y auditoría de accesos
$estadisticas   = $dashboardModelo->obtenerEstadisticas($rol_id, $usuario_id);
$ultimosAccesos = $dashboardModelo->obtenerUltimosAccesos($usuario_id, 5);

// 5b. Publicaciones institucionales (visibles para todos los roles)
$publicacionModelo = new PublicacionModelo($conexion);
$publicaciones     = $publicacionModelo->obtenerPublicaciones(20);
$nivelAcceso       = $rol_id; // alias para el partial

// 6. Cargar la vista principal del dashboard
require_once __DIR__ . '/../vistas/dashboardVista.php';
