<?php
// controladores/perfil/subirFotoControlador.php
// Solo accesible para SuperUsuario (rol 1)
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

// ── Autenticación ──────────────────────────────────────────────
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'msg' => 'Sesión no iniciada.']);
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';

$modelo     = new DashboardModelo($conexion);
$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $modelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || (int)$perfil['nivel_acceso'] !== 1) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'msg' => 'Acceso denegado. Solo SuperUsuario puede subir fotos.']);
    exit;
}

// ── Validar método y parámetros ────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'msg' => 'Método no permitido.']);
    exit;
}

$targetUserId = isset($_POST['target_usuario_id']) ? (int)$_POST['target_usuario_id'] : 0;
if ($targetUserId <= 0) {
    echo json_encode(['ok' => false, 'msg' => 'ID de usuario no válido.']);
    exit;
}

// Verificar que el usuario destino existe
$usuarioDestino = $modelo->obtenerUsuarioPorId($targetUserId);
if (!$usuarioDestino) {
    echo json_encode(['ok' => false, 'msg' => 'Usuario destino no encontrado.']);
    exit;
}

// ── Validar archivo ────────────────────────────────────────────
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    $errores = [
        UPLOAD_ERR_INI_SIZE   => 'El archivo supera el límite del servidor.',
        UPLOAD_ERR_FORM_SIZE  => 'El archivo supera el límite del formulario.',
        UPLOAD_ERR_PARTIAL    => 'La subida fue interrumpida.',
        UPLOAD_ERR_NO_FILE    => 'No se seleccionó ningún archivo.',
        UPLOAD_ERR_NO_TMP_DIR => 'Sin directorio temporal.',
        UPLOAD_ERR_CANT_WRITE => 'Error al escribir en disco.',
        UPLOAD_ERR_EXTENSION  => 'Extensión de PHP bloqueó la subida.',
    ];
    $codigo = $_FILES['foto']['error'] ?? UPLOAD_ERR_NO_FILE;
    echo json_encode(['ok' => false, 'msg' => $errores[$codigo] ?? 'Error desconocido al subir.']);
    exit;
}

$file     = $_FILES['foto'];
$maxBytes = 3 * 1024 * 1024; // 3 MB

if ($file['size'] > $maxBytes) {
    echo json_encode(['ok' => false, 'msg' => 'El archivo pesa más de 3 MB.']);
    exit;
}

// Validar tipo MIME real
$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeReal = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
if (!in_array($mimeReal, $tiposPermitidos, true)) {
    echo json_encode(['ok' => false, 'msg' => 'Solo se permiten imágenes JPG, PNG o WEBP.']);
    exit;
}

$ext     = match($mimeReal) { 'image/png' => 'png', 'image/webp' => 'webp', default => 'jpg' };
$dirDest = __DIR__ . '/../../uploads/fotos_perfil/';
$nombre  = 'usuario_' . $targetUserId . '_' . time() . '.' . $ext;
$ruta    = $dirDest . $nombre;

// Eliminar foto anterior si existe
$fotoAnterior = $usuarioDestino['foto_perfil'] ?? null;
if ($fotoAnterior) {
    $rutaAnterior = $dirDest . basename($fotoAnterior);
    if (file_exists($rutaAnterior)) {
        unlink($rutaAnterior);
    }
}

/**
 * Procesa y optimiza la imagen para avatar con corte 1:1 centrado y alta resolución
 */
function procesarYOptimizarFoto(string $tmpPath, string $destPath, string $mimeReal): bool {
    if (extension_loaded('gd')) {
        $imgOriginal = match($mimeReal) {
            'image/jpeg' => @imagecreatefromjpeg($tmpPath),
            'image/png'  => @imagecreatefrompng($tmpPath),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmpPath) : null,
            default      => null
        };

        if ($imgOriginal) {
            $origW = imagesx($imgOriginal);
            $origH = imagesy($imgOriginal);

            $minDim = min($origW, $origH);
            $srcX   = (int)(($origW - $minDim) / 2);
            $srcY   = (int)(($origH - $minDim) / 2);

            $targetSize = min(600, max(200, $minDim));
            $targetImg  = imagecreatetruecolor($targetSize, $targetSize);

            if ($mimeReal === 'image/png' || $mimeReal === 'image/webp') {
                imagealphablending($targetImg, false);
                imagesavealpha($targetImg, true);
                $trans = imagecolorallocatealpha($targetImg, 255, 255, 255, 127);
                imagefilledrectangle($targetImg, 0, 0, $targetSize, $targetSize, $trans);
            } else {
                $bg = imagecolorallocate($targetImg, 255, 255, 255);
                imagefilledrectangle($targetImg, 0, 0, $targetSize, $targetSize, $bg);
            }

            imagecopyresampled(
                $targetImg, $imgOriginal,
                0, 0, $srcX, $srcY,
                $targetSize, $targetSize, $minDim, $minDim
            );

            $guardado = match($mimeReal) {
                'image/jpeg' => imagejpeg($targetImg, $destPath, 92),
                'image/png'  => imagepng($targetImg, $destPath, 6),
                'image/webp' => function_exists('imagewebp') ? imagewebp($targetImg, $destPath, 92) : false,
                default      => false
            };

            imagedestroy($imgOriginal);
            imagedestroy($targetImg);

            if ($guardado) return true;
        }
    }
    return move_uploaded_file($tmpPath, $destPath);
}

if (!procesarYOptimizarFoto($file['tmp_name'], $ruta, $mimeReal)) {
    echo json_encode(['ok' => false, 'msg' => 'No se pudo guardar la imagen en el servidor.']);
    exit;
}

// ── Guardar en BD ──────────────────────────────────────────────
$rutaRelativa = 'uploads/fotos_perfil/' . $nombre;

try {
    $stmt = $conexion->prepare(
        "UPDATE usuarios SET foto_perfil = :foto WHERE usuario_id = :id LIMIT 1"
    );
    $stmt->execute([':foto' => $rutaRelativa, ':id' => $targetUserId]);

    // Si la foto actualizada corresponde al usuario en sesión, actualizar sesión
    if ($targetUserId === (int)$_SESSION['usuario_id']) {
        $_SESSION['foto_perfil'] = $rutaRelativa;
    }

    echo json_encode([
        'ok'   => true,
        'msg'  => 'Foto actualizada correctamente.',
        'src'  => '../../' . $rutaRelativa . '?v=' . time(),
        'url'  => $rutaRelativa . '?v=' . time()
    ]);
} catch (PDOException $e) {
    // Revertir archivo subido
    if (file_exists($ruta)) unlink($ruta);
    echo json_encode(['ok' => false, 'msg' => 'Error al guardar en la base de datos.']);
}
