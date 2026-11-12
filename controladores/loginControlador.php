<?php
// controladores/loginControlador.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/loginModelo.php';

// Si ya tiene una sesión iniciada, redirige al panel principal
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($usuario) || empty($password)) {
        $error = 'Por favor ingresa usuario y contraseña.';
    } else {
        $loginModelo = new LoginModelo($conexion);
        $usuarioDatos = $loginModelo->obtenerUsuario($usuario);

        // Validar contraseña con password_hash de la base de datos
        if ($usuarioDatos && !empty($usuarioDatos['password_hash']) && password_verify($password, $usuarioDatos['password_hash'])) {
            
            // Iniciar variables de sesión
            $_SESSION['usuario_id']   = $usuarioDatos['usuario_id'];
            $_SESSION['nombre']       = $usuarioDatos['nombre'];
            $_SESSION['usuario']      = $usuarioDatos['usuario'];
            $_SESSION['cargo']        = $usuarioDatos['cargo'];
            $_SESSION['area']         = $usuarioDatos['area'];
            $_SESSION['nivel_acceso'] = $usuarioDatos['nivel_acceso'];
            $_SESSION['rol_nombre']   = $usuarioDatos['rol_nombre'] ?? 'Usuario';
            $_SESSION['foto_perfil']  = $usuarioDatos['foto_perfil'] ?? null;

            // Obtener IP del cliente
            $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }

            // Registrar auditoría en tabla login y actualizar fecha
            $loginModelo->registrarAcceso($usuarioDatos['usuario_id'], $usuarioDatos['nombre'], $ip);

            // Redirigir al inicio del portal
            header("Location: index.php");
            exit();
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}

// Cargar la vista de login
require_once __DIR__ . '/../vistas/loginVista.php';
