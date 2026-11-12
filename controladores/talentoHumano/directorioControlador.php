<?php
// controladores/talentoHumano/directorioControlador.php
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
require_once __DIR__ . '/../../modelos/directorioModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo  = new DashboardModelo($conexion);
$directorioModelo = new DirectorioModelo($conexion);

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

// El Directorio de Empleados es exclusivo para SuperUsuario y Gestión Humana
if (!$esSuperUsuario && !$esGestionHumana) {
    header('Location: ../../index.php');
    exit;
}

// 2. Filtros de búsqueda
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : null;
$area     = isset($_GET['area']) ? trim($_GET['area']) : null;
$estado   = isset($_GET['estado']) ? trim($_GET['estado']) : 'todos';

// 3. Obtención de datos
$empleados = $directorioModelo->obtenerEmpleados($busqueda, $area, $estado);
$datosStats = $directorioModelo->obtenerEstadisticasYAreas();

// 4. Cargar vista
require_once __DIR__ . '/../../vistas/talentoHumano/directorioVista.php';
