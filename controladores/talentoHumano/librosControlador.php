<?php
// controladores/talentoHumano/librosControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

require_once __DIR__ . '/../../vistas/talentoHumano/librosVista.php';
