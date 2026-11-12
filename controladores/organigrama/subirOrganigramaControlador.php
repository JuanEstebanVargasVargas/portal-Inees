<?php
// controladores/organigrama/subirOrganigramaControlador.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── 1. Autenticación ────────────────────────────────────────────────────────
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

// ── 2. Dependencias ─────────────────────────────────────────────────────────
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';
require_once __DIR__ . '/../../modelos/organigramaModelo.php';

$dashboardModelo = new DashboardModelo($conexion);
$usuario_id      = (int) $_SESSION['usuario_id'];
$perfil          = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id       = (int) $perfil['nivel_acceso'];
$puedeSubir   = in_array($rol_id, [1, 5], true);        // SuperUsuario o Sistema de Gestión
$puedeVer     = in_array($rol_id, [1, 2, 3, 5], true); // también Gestión Humana y Empleado

if (!$puedeVer) {
    http_response_code(403);
    exit('No tienes permiso para acceder a este módulo.');
}

$modelo  = new OrganigramaModelo($conexion);
$mensaje = '';
$error   = '';

// ── 3. Acción: eliminar (solo rol 1 y 5) ───────────────────────────────────
if ($puedeSubir && isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $idEliminar = (int) $_GET['id'];
    if ($idEliminar > 0) {
        $modelo->eliminar($idEliminar);
    }
    header('Location: subirOrganigramaControlador.php?ok=eliminado');
    exit;
}

if (isset($_GET['ok'])) {
    $mensaje = match ($_GET['ok']) {
        'subido'    => 'Organigrama actualizado correctamente.',
        'eliminado' => 'Registro eliminado del historial.',
        default     => ''
    };
}

// ── 4. Acción: subir archivo (POST) ─────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $puedeSubir) {

    $archivo = $_FILES['organigrama'] ?? null;

    if (!$archivo || $archivo['error'] !== UPLOAD_ERR_OK) {
        $error = 'No se pudo recibir el archivo. Verifica que no supere los 5 MB.';
    } else {
        $permitidos = [
            'application/pdf' => 'pdf',
            'image/png'       => 'png',
            'image/jpeg'      => 'jpg',
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($archivo['tmp_name']);

        if (!isset($permitidos[$mime])) {
            $error = 'Solo se permiten archivos PDF, PNG o JPG.';
        } elseif ($archivo['size'] > 5 * 1024 * 1024) {
            $error = 'El archivo no puede superar los 5 MB.';
        } else {
            $ext    = $permitidos[$mime];
            $dir    = __DIR__ . '/../../uploads/organigrama/';
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $nombre = 'organigrama_' . date('Ymd_His') . '.' . $ext;

            if (move_uploaded_file($archivo['tmp_name'], $dir . $nombre)) {
                $ok = $modelo->guardar([
                    'titulo'          => trim($_POST['titulo']       ?? 'Organigrama General Institucional') ?: 'Organigrama General Institucional',
                    'version'         => trim($_POST['version']      ?? 'v1.0') ?: 'v1.0',
                    'descripcion'     => trim($_POST['descripcion']  ?? '') ?: null,
                    'nombre_original' => $archivo['name'],
                    'ruta_archivo'    => $nombre,
                    'tipo_archivo'    => $ext,
                    'tamano'          => $archivo['size'],
                    'usuario_id'      => $usuario_id,
                ]);

                if ($ok) {
                    header('Location: subirOrganigramaControlador.php?ok=subido');
                    exit;
                } else {
                    $error = 'Error al registrar el organigrama en la base de datos.';
                }
            } else {
                $error = 'Error al guardar el archivo en el servidor.';
            }
        }
    }
}

// ── 5. Cargar datos para la vista ───────────────────────────────────────────
$organigrama = $modelo->obtenerActual();
$historial   = $modelo->obtenerHistorial(30);

require __DIR__ . '/../../vistas/organigrama/subirOrganigramaVista.php';
