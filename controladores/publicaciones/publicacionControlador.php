<?php
/**
 * Controlador de Publicaciones
 * Maneja la creación de publicaciones vía POST con soporte de subida de imágenes y videos.
 * Solo permite publicar al rol 2 (Gestión Humana).
 */

// Sesión activa requerida
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar sesión válida
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['nivel_acceso'])) {
    header('Location: ../../login.php');
    exit;
}

// Solo Gestión Humana (nivel_acceso = 2) y Sistema de Gestión (nivel_acceso = 5) pueden publicar
$_nivelSesion = (int)$_SESSION['nivel_acceso'];
if ($_nivelSesion !== 2 && $_nivelSesion !== 5) {
    header('Location: ../../index.php?error=sin_permiso');
    exit;
}
unset($_nivelSesion);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit;
}

// ─── Validación de campos de texto ───────────────────────────────────────────
$titulo    = trim($_POST['titulo'] ?? '');
$contenido = trim($_POST['contenido'] ?? '');

if (empty($titulo) || empty($contenido)) {
    header('Location: ../../index.php?pub_error=campos_vacios');
    exit;
}

if (mb_strlen($titulo) > 255) {
    header('Location: ../../index.php?pub_error=titulo_largo');
    exit;
}

// ─── Procesamiento de archivo multimedia ──────────────────────────────────────
$mediaArchivo = null;
$mediaTipo    = 'ninguno';

// Tipos MIME permitidos
$tiposImagen = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$tiposVideo  = ['video/mp4', 'video/webm', 'video/quicktime', 'video/x-msvideo'];
$todosPermitidos = array_merge($tiposImagen, $tiposVideo);

// Límites de tamaño (en bytes)
$limiteImagen = 15 * 1024 * 1024;  // 15 MB
$limiteVideo  = 100 * 1024 * 1024; // 100 MB

// Carpeta de destino (relativa a la raíz del proyecto)
$dirUpload = __DIR__ . '/../../img/publicaciones/';

if (!empty($_FILES['media']['name']) && $_FILES['media']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['media'];

    // Verificar errores de subida
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errCodes = [
            UPLOAD_ERR_INI_SIZE   => 'archivo_grande',
            UPLOAD_ERR_FORM_SIZE  => 'archivo_grande',
            UPLOAD_ERR_PARTIAL    => 'subida_parcial',
            UPLOAD_ERR_NO_TMP_DIR => 'error_servidor',
            UPLOAD_ERR_CANT_WRITE => 'error_servidor',
            UPLOAD_ERR_EXTENSION  => 'tipo_no_permitido',
        ];
        $errKey = $errCodes[$file['error']] ?? 'upload_error';
        header("Location: ../../index.php?pub_error={$errKey}");
        exit;
    }

    // Detectar tipo MIME real (no confiar en el cliente)
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeReal = $finfo->file($file['tmp_name']);

    if (!in_array($mimeReal, $todosPermitidos, true)) {
        header('Location: ../../index.php?pub_error=tipo_no_permitido');
        exit;
    }

    // Verificar tamaño según tipo
    $esImagen = in_array($mimeReal, $tiposImagen, true);
    $limite   = $esImagen ? $limiteImagen : $limiteVideo;

    if ($file['size'] > $limite) {
        header('Location: ../../index.php?pub_error=archivo_grande');
        exit;
    }

    // Generar nombre único seguro
    $ext          = pathinfo($file['name'], PATHINFO_EXTENSION);
    $extLimpia    = preg_replace('/[^a-zA-Z0-9]/', '', $ext);
    $nombreArchivo = uniqid('pub_', true) . '.' . strtolower($extLimpia);
    $rutaDestino  = $dirUpload . $nombreArchivo;

    // Crear directorio si no existe
    if (!is_dir($dirUpload)) {
        mkdir($dirUpload, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $rutaDestino)) {
        header('Location: ../../index.php?pub_error=error_servidor');
        exit;
    }

    $mediaArchivo = $nombreArchivo;
    $mediaTipo    = $esImagen ? 'imagen' : 'video';
}

// ─── Guardar en base de datos ─────────────────────────────────────────────────
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/publicacionModelo.php';

$modelo = new PublicacionModelo($pdo);

$autorId     = (int)$_SESSION['usuario_id'];
$autorNombre = htmlspecialchars($_SESSION['nombre'] ?? 'Usuario');
$autorNivel  = (int)$_SESSION['nivel_acceso']; // 2=Gestión Humana, 5=Sistema de Gestión

$ok = $modelo->crearPublicacion($titulo, $contenido, $autorId, $autorNombre, $autorNivel, $mediaArchivo, $mediaTipo);

if ($ok) {
    header('Location: ../../index.php?pub_ok=1');
} else {
    // Si falló el DB pero ya subimos el archivo, lo eliminamos para no dejar huérfanos
    if ($mediaArchivo && file_exists($dirUpload . $mediaArchivo)) {
        unlink($dirUpload . $mediaArchivo);
    }
    header('Location: ../../index.php?pub_error=db_fail');
}
exit;
