<?php
// controladores/talentoHumano/usuarioCRUDControlador.php
// CRUD de usuarios vía AJAX — solo SuperUsuario (rol 1)
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');

// Auth
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'msg' => 'Sin sesión.']);
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';
require_once __DIR__ . '/../../modelos/directorioModelo.php';

$dash    = new DashboardModelo($conexion);
$modelo  = new DirectorioModelo($conexion);
$me      = $dash->obtenerUsuarioPorId((int)$_SESSION['usuario_id']);

if (!$me || (int)$me['nivel_acceso'] !== 1) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'msg' => 'Solo SuperUsuario.']);
    exit;
}

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

// ── Helper para foto con optimización y recorte centrado 1:1 ────
function procesarFoto(array $file, int $userId, DirectorioModelo $modelo, ?string $fotoActual): string|false {
    $dir = __DIR__ . '/../../uploads/fotos_perfil/';
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if ($file['size'] > 3 * 1024 * 1024) return false;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, ['image/jpeg','image/png','image/webp'])) return false;
    $ext  = match($mime) { 'image/png' => 'png', 'image/webp' => 'webp', default => 'jpg' };
    $name = 'usuario_' . $userId . '_' . time() . '.' . $ext;
    $dest = $dir . $name;
    // Borrar foto anterior
    if ($fotoActual) {
        $old = $dir . basename($fotoActual);
        if (file_exists($old)) unlink($old);
    }

    $guardado = false;
    if (extension_loaded('gd')) {
        $imgOriginal = match($mime) {
            'image/jpeg' => @imagecreatefromjpeg($file['tmp_name']),
            'image/png'  => @imagecreatefrompng($file['tmp_name']),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file['tmp_name']) : null,
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

            if ($mime === 'image/png' || $mime === 'image/webp') {
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

            $guardado = match($mime) {
                'image/jpeg' => imagejpeg($targetImg, $dest, 92),
                'image/png'  => imagepng($targetImg, $dest, 6),
                'image/webp' => function_exists('imagewebp') ? imagewebp($targetImg, $dest, 92) : false,
                default      => false
            };

            imagedestroy($imgOriginal);
            imagedestroy($targetImg);
        }
    }

    if (!$guardado) {
        if (!move_uploaded_file($file['tmp_name'], $dest)) return false;
    }

    $rutaRelativa = 'uploads/fotos_perfil/' . $name;
    if ($userId === (int)($_SESSION['usuario_id'] ?? 0)) {
        $_SESSION['foto_perfil'] = $rutaRelativa;
    }

    return $rutaRelativa;
}

// ── Acciones ─────────────────────────────────────────────────────
switch ($accion) {

    // ── Obtener datos de un usuario (para modal edición) ──────────
    case 'obtener':
        $id  = (int)($_GET['id'] ?? 0);
        $usr = $modelo->obtenerUsuarioPorId($id);
        if (!$usr) { echo json_encode(['ok'=>false,'msg'=>'No encontrado.']); exit; }
        // No exponer password_hash
        unset($usr['password_hash']);
        $usr['foto_url'] = !empty($usr['foto_perfil'])
            ? '../../' . $usr['foto_perfil'] . '?v=' . time()
            : null;
        echo json_encode(['ok' => true, 'usuario' => $usr]);
        break;

    // ── Crear usuario ─────────────────────────────────────────────
    case 'crear':
        $nombre  = trim($_POST['nombre'] ?? '');
        $usuario = trim($_POST['usuario'] ?? '');
        $pwd     = trim($_POST['password'] ?? '');
        $nivel   = (int)($_POST['nivel_acceso'] ?? 3);
        $estado  = $_POST['estado'] ?? 'activo';

        if (empty($nombre) || empty($usuario) || empty($pwd)) {
            echo json_encode(['ok'=>false,'msg'=>'Nombre, usuario y contraseña son obligatorios.']);
            exit;
        }
        // Verificar duplicados (aún sin ID)
        $dup = $modelo->existeUsuario($usuario, trim($_POST['cedula'] ?? ''), 0);
        if ($dup['usuario']) { echo json_encode(['ok'=>false,'msg'=>'El nombre de usuario ya existe.']); exit; }
        if ($dup['cedula'])  { echo json_encode(['ok'=>false,'msg'=>'La cédula ya está registrada.']); exit; }

        $data = [
            'nombre'               => $nombre,
            'cedula'               => trim($_POST['cedula'] ?? '') ?: null,
            'cargo'                => trim($_POST['cargo'] ?? '') ?: null,
            'area'                 => trim($_POST['area'] ?? '') ?: null,
            'email'                => trim($_POST['email'] ?? '') ?: null,
            'celular'              => trim($_POST['celular'] ?? '') ?: null,
            'telefono_corporativo' => trim($_POST['telefono_corporativo'] ?? '') ?: null,
            'telefono_emergencia'  => trim($_POST['telefono_emergencia'] ?? '') ?: null,
            'usuario'              => $usuario,
            'password_hash'        => password_hash($pwd, PASSWORD_BCRYPT),
            'nivel_acceso'         => $nivel,
            'estado'               => in_array($estado, ['activo','inactivo']) ? $estado : 'activo',
            'foto_perfil'          => null,
        ];

        $newId = $modelo->crearUsuario($data);
        if (!$newId) { echo json_encode(['ok'=>false,'msg'=>'Error al crear el usuario en BD.']); exit; }

        // Foto (si se adjuntó)
        $fotoPath = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoPath = procesarFoto($_FILES['foto'], $newId, $modelo, null);
            if ($fotoPath) {
                $modelo->actualizarUsuario($newId, array_merge($data, [
                    'foto_perfil' => $fotoPath,
                    'nivel_acceso' => $nivel,
                    'estado' => $data['estado'],
                ]));
            }
        }

        echo json_encode([
            'ok'       => true,
            'msg'      => 'Usuario creado correctamente.',
            'id'       => $newId,
            'foto_url' => $fotoPath ? '../../' . $fotoPath : null,
        ]);
        break;

    // ── Editar usuario ────────────────────────────────────────────
    case 'editar':
        $id      = (int)($_POST['usuario_id'] ?? 0);
        $nombre  = trim($_POST['nombre'] ?? '');
        $usuario = trim($_POST['usuario'] ?? '');

        if ($id <= 0 || empty($nombre) || empty($usuario)) {
            echo json_encode(['ok'=>false,'msg'=>'Datos incompletos.']); exit;
        }

        $actual = $modelo->obtenerUsuarioPorId($id);
        if (!$actual) { echo json_encode(['ok'=>false,'msg'=>'Usuario no encontrado.']); exit; }

        $dup = $modelo->existeUsuario($usuario, trim($_POST['cedula'] ?? ''), $id);
        if ($dup['usuario']) { echo json_encode(['ok'=>false,'msg'=>'El nombre de usuario ya lo usa otra cuenta.']); exit; }
        if ($dup['cedula'])  { echo json_encode(['ok'=>false,'msg'=>'La cédula ya está registrada en otra cuenta.']); exit; }

        $data = [
            'nombre'               => $nombre,
            'cedula'               => trim($_POST['cedula'] ?? '') ?: null,
            'cargo'                => trim($_POST['cargo'] ?? '') ?: null,
            'area'                 => trim($_POST['area'] ?? '') ?: null,
            'email'                => trim($_POST['email'] ?? '') ?: null,
            'celular'              => trim($_POST['celular'] ?? '') ?: null,
            'telefono_corporativo' => trim($_POST['telefono_corporativo'] ?? '') ?: null,
            'telefono_emergencia'  => trim($_POST['telefono_emergencia'] ?? '') ?: null,
            'usuario'              => $usuario,
            'nivel_acceso'         => (int)($_POST['nivel_acceso'] ?? $actual['nivel_acceso']),
            'estado'               => in_array($_POST['estado'] ?? '', ['activo','inactivo'])
                                        ? $_POST['estado'] : $actual['estado'],
        ];

        $pwdNueva = trim($_POST['password'] ?? '');
        if (!empty($pwdNueva)) {
            $data['password_hash'] = password_hash($pwdNueva, PASSWORD_BCRYPT);
        }

        // Foto nueva
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoPath = procesarFoto($_FILES['foto'], $id, $modelo, $actual['foto_perfil'] ?? null);
            if ($fotoPath) $data['foto_perfil'] = $fotoPath;
        }

        $ok = $modelo->actualizarUsuario($id, $data);
        $fotoActualizada = $actual['foto_perfil'] ?? null;
        if (isset($data['foto_perfil'])) $fotoActualizada = $data['foto_perfil'];

        echo json_encode([
            'ok'       => $ok,
            'msg'      => $ok ? 'Usuario actualizado correctamente.' : 'Error al actualizar.',
            'foto_url' => $fotoActualizada ? '../../' . $fotoActualizada . '?v=' . time() : null,
        ]);
        break;

    // ── Cambiar estado (activar/desactivar) ───────────────────────
    case 'estado':
        $id     = (int)($_POST['usuario_id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        if ($id <= 0 || !in_array($estado, ['activo','inactivo'])) {
            echo json_encode(['ok'=>false,'msg'=>'Parámetros inválidos.']); exit;
        }
        // No permitir desactivar al propio superusuario logueado
        if ($id === (int)$_SESSION['usuario_id'] && $estado === 'inactivo') {
            echo json_encode(['ok'=>false,'msg'=>'No puedes desactivar tu propia cuenta.']); exit;
        }
        $ok = $modelo->cambiarEstado($id, $estado);
        echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Estado actualizado.' : 'Error al cambiar estado.']);
        break;

    // ── Quitar foto ───────────────────────────────────────────────
    case 'quitar_foto':
        $id  = (int)($_POST['usuario_id'] ?? 0);
        $usr = $modelo->obtenerUsuarioPorId($id);
        if (!$usr) { echo json_encode(['ok'=>false,'msg'=>'Usuario no encontrado.']); exit; }
        // Borrar archivo
        if (!empty($usr['foto_perfil'])) {
            $file = __DIR__ . '/../../' . $usr['foto_perfil'];
            if (file_exists($file)) unlink($file);
        }
        $ok = $modelo->quitarFoto($id);
        echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Foto eliminada.' : 'Error al eliminar.']);
        break;

    default:
        http_response_code(400);
        echo json_encode(['ok' => false, 'msg' => 'Acción no reconocida.']);
}
