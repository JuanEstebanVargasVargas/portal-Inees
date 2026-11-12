<?php
// controladores/login/cambiarPasswordControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Control de acceso: Requiere sesión activa
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$usuario_id      = (int)$_SESSION['usuario_id'];
$perfil          = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id          = (int)$perfil['nivel_acceso'];
$esSuperUsuario  = ($rol_id === 1);
$esGestionHumana = ($rol_id === 2);
$esEmpleado      = ($rol_id === 3);

$mensajeExito = '';
$mensajeError = '';

// 2. Procesamiento de cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordActual    = trim($_POST['password_actual'] ?? '');
    $passwordNueva     = trim($_POST['password_nueva'] ?? '');
    $passwordConfirmar = trim($_POST['password_confirmar'] ?? '');

    if (empty($passwordActual) || empty($passwordNueva) || empty($passwordConfirmar)) {
        $mensajeError = "Por favor completa todos los campos del formulario.";
    } elseif (strlen($passwordNueva) < 6) {
        $mensajeError = "La nueva contraseña debe tener al menos 6 caracteres.";
    } elseif ($passwordNueva !== $passwordConfirmar) {
        $mensajeError = "La nueva contraseña y su confirmación no coinciden.";
    } else {
        // Consultar hash actual en la base de datos
        $stmt = $conexion->prepare("SELECT password_hash FROM usuarios WHERE usuario_id = :id LIMIT 1");
        $stmt->execute([':id' => $usuario_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || empty($row['password_hash']) || !password_verify($passwordActual, $row['password_hash'])) {
            $mensajeError = "La contraseña actual ingresada es incorrecta.";
        } else {
            // Generar nuevo hash seguro
            $nuevoHash = password_hash($passwordNueva, PASSWORD_DEFAULT);

            $update = $conexion->prepare("UPDATE usuarios 
                                          SET password_hash = :hash, 
                                              pwd_ultimo_cambio = NOW(), 
                                              forzar_cambio_pwd = 0 
                                          WHERE usuario_id = :id");
            $ok = $update->execute([
                ':hash' => $nuevoHash,
                ':id'   => $usuario_id
            ]);

            if ($ok) {
                $mensajeExito = "¡Tu contraseña ha sido actualizada exitosamente!";
            } else {
                $mensajeError = "Ocurrió un error al guardar la nueva contraseña. Por favor intenta de nuevo.";
            }
        }
    }
}

// 3. Cargar la vista
require_once __DIR__ . '/../../vistas/login/cambiarPasswordVista.php';
