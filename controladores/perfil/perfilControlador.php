<?php
// controladores/perfil/perfilControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Requiere sesión activa
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';

$dashboardModelo = new DashboardModelo($conexion);
$usuario_id      = (int)$_SESSION['usuario_id'];
$perfil          = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id     = (int)$perfil['nivel_acceso'];
$rol_nombre = $perfil['rol_nombre'] ?? 'Usuario';

$esSuperUsuario  = ($rol_id === 1);
$esGestionHumana = ($rol_id === 2);
$esEmpleado      = ($rol_id === 3);

// Historial de accesos (últimos 10)
$ultimosAccesos = $dashboardModelo->obtenerUltimosAccesos($usuario_id, 10);

// Cargar la vista de perfil
require_once __DIR__ . '/../../vistas/perfilVista.php';
