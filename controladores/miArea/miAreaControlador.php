<?php
// controladores/miArea/miAreaControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Control de acceso: requiere sesión iniciada
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';
require_once __DIR__ . '/../../modelos/miAreaModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$miAreaModelo    = new MiAreaModelo($conexion);

$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

// Roles
$rol_id            = (int)$perfil['nivel_acceso'];
$rol_nombre        = $perfil['rol_nombre'] ?? 'Usuario';
$cargo_usuario     = strtolower(trim($perfil['cargo'] ?? ''));
$area_usuario      = strtolower(trim($perfil['area'] ?? ''));

$esSuperUsuario    = ($rol_id === 1);
$esGestionHumana   = ($rol_id === 2 || $area_usuario === 'rrhh');
$esEmpleado        = ($rol_id === 3);
$esContabilidad    = ($rol_id === 4);
$esSistemaGestion  = ($rol_id === 5 || strtolower(trim($rol_nombre)) === 'sistema de gestion');

// Privilegio exclusivo: Solo "Sistema de Gestión" puede publicar o eliminar archivos
$puedePublicar = $esSistemaGestion;

// ── Áreas permitidas según rol (misma lógica que Flujos) ──────────────────────
$areasPermitidas = [];

if ($esSistemaGestion) {
    $areasPermitidas = ['GENERAL', 'RECURSOS HUMANOS', 'GERENCIA', 'TECNICOS', 'ADMINISTRATIVO', 'EMPLEADO'];
} elseif ($esSuperUsuario) {
    $areasPermitidas = ['GENERAL', 'GERENCIA'];
} elseif ($esGestionHumana) {
    $areasPermitidas = ['GENERAL', 'RECURSOS HUMANOS'];
} elseif ($esContabilidad) {
    $areasPermitidas = ['GENERAL', 'ADMINISTRATIVO'];
} elseif ($esEmpleado) {
    $esTecnico = (strpos($cargo_usuario, 'tecnic') !== false ||
                  strpos($cargo_usuario, 'téc')   !== false ||
                  $area_usuario === 'laboratorio'  ||
                  $area_usuario === 'maquinas');
    $esAdminEmp = (strpos($cargo_usuario, 'admin') !== false ||
                   strpos($cargo_usuario, 'asistent') !== false);
    if ($esTecnico) {
        $areasPermitidas = ['GENERAL', 'TECNICOS', 'EMPLEADO'];
    } elseif ($esAdminEmp) {
        $areasPermitidas = ['GENERAL', 'ADMINISTRATIVO', 'EMPLEADO'];
    } else {
        $areasPermitidas = ['GENERAL', 'EMPLEADO'];
    }
} else {
    $areasPermitidas = ['GENERAL', 'EMPLEADO'];
}

$mensajeExito = '';
$mensajeError = '';

// 2. Procesar acción de descarga de archivo si se solicita
if (isset($_GET['accion']) && $_GET['accion'] === 'descargar' && !empty($_GET['id'])) {
    $archivoId = (int)$_GET['id'];
    $archivo = $miAreaModelo->obtenerArchivoPorId($archivoId);
    if ($archivo) {
        // Validación de permisos por división
        if (!empty($archivo['area']) && !in_array($archivo['area'], $areasPermitidas, true)) {
            $mensajeError = 'Acceso denegado: Tu perfil no tiene autorización para descargar documentos de la división ' . htmlspecialchars($archivo['area']) . '.';
        } else {
            $rutaFisica = __DIR__ . '/../../' . ltrim($archivo['ruta_archivo'], '/\\');
            if (file_exists($rutaFisica)) {
                // Limpiar buffers
                if (ob_get_level()) {
                    ob_end_clean();
                }
                $mimeType = mime_content_type($rutaFisica) ?: 'application/octet-stream';
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $mimeType);
                header('Content-Disposition: inline; filename="' . basename($archivo['nombre_original']) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($rutaFisica));
                readfile($rutaFisica);
                exit;
            } else {
                $mensajeError = 'El archivo físico solicitado no se encuentra en el servidor.';
            }
        }
    } else {
        $mensajeError = 'Archivo no encontrado.';
    }
}

// 3. Procesar eliminación de archivo (Solo Sistema de Gestión)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar_archivo') {
    if (!$puedePublicar) {
        $mensajeError = 'Acceso denegado: Solo el rol de Sistema de Gestión está autorizado para eliminar archivos.';
    } else {
        $archivoId = (int)($_POST['archivo_id'] ?? 0);
        $archivo = $miAreaModelo->obtenerArchivoPorId($archivoId);
        if ($archivo) {
            $miAreaModelo->eliminarArchivo($archivoId);
            $mensajeExito = 'El archivo "' . htmlspecialchars($archivo['titulo']) . '" ha sido eliminado exitosamente.';
        } else {
            $mensajeError = 'No se encontró el archivo que se intentó eliminar.';
        }
    }
}

// 4. Procesar publicación/subida de archivo (Solo Sistema de Gestión)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'publicar_archivo') {
    if (!$puedePublicar) {
        $mensajeError = 'Acceso denegado: Solo el rol de Sistema de Gestión tiene permisos para publicar archivos en Mi Área.';
    } else {
        $titulo      = trim($_POST['titulo'] ?? '');
        $categoria   = trim($_POST['categoria'] ?? 'General');
        $otraCat     = trim($_POST['otra_categoria'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $areaDestino = trim($_POST['area_destino'] ?? 'GENERAL');

        // Si seleccionó 'otra', tomar el campo de texto
        if ($categoria === '__otra__' && !empty($otraCat)) {
            $categoria = $otraCat;
        }

        // Validar que el área de destino sea válida
        $areasValidas = ['GENERAL', 'RECURSOS HUMANOS', 'GERENCIA', 'TECNICOS', 'ADMINISTRATIVO', 'EMPLEADO'];
        if (!in_array($areaDestino, $areasValidas, true)) {
            $areaDestino = 'GENERAL';
        }

        if (empty($titulo)) {
            $mensajeError = 'Por favor ingresa un título para el archivo.';
        } elseif (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            $mensajeError = 'Por favor selecciona un archivo válido para subir.';
        } else {
            $fileTmp   = $_FILES['archivo']['tmp_name'];
            $fileName  = $_FILES['archivo']['name'];
            $fileSize  = $_FILES['archivo']['size'];
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $permitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'csv', 'txt', 'jpg', 'jpeg', 'png', 'zip', 'rar'];
            $maxBytes = 35 * 1024 * 1024;

            if (!in_array($extension, $permitidas, true)) {
                $mensajeError = 'Tipo de archivo no permitido. Extensiones admitidas: ' . implode(', ', $permitidas);
            } elseif ($fileSize > $maxBytes) {
                $mensajeError = 'El archivo excede el tamaño máximo permitido de 35 MB.';
            } else {
                $uploadDir = __DIR__ . '/../../uploads/mi_area/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $nuevoNombre = 'doc_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
                $destino = $uploadDir . $nuevoNombre;

                if (move_uploaded_file($fileTmp, $destino)) {
                    $rutaRelativa = 'uploads/mi_area/' . $nuevoNombre;

                    $miAreaModelo->guardarArchivo([
                        'titulo'          => $titulo,
                        'descripcion'     => $descripcion,
                        'categoria'       => $categoria ?: 'General',
                        'area'            => $areaDestino,
                        'nombre_original' => $fileName,
                        'ruta_archivo'    => $rutaRelativa,
                        'tamano'          => $fileSize,
                        'tipo'            => $extension,
                        'usuario_id'      => $usuario_id,
                        'fecha_subida'    => date('Y-m-d H:i:s')
                    ]);

                    $mensajeExito = '¡Archivo publicado con éxito en la división ' . htmlspecialchars($areaDestino) . '!';
                } else {
                    $mensajeError = 'Ocurrió un error al guardar el archivo en el servidor.';
                }
            }
        }
    }
}

// 5. Cargar datos para la vista
$categoriaFiltro = trim($_GET['cat'] ?? '');
$busquedaFiltro  = trim($_GET['q'] ?? '');
$areaFiltro      = strtoupper(trim($_GET['area'] ?? ''));

// Validar que el área filtro esté dentro de las permitidas
if (!empty($areaFiltro) && !in_array($areaFiltro, $areasPermitidas, true)) {
    $areaFiltro = '';
}

// Si no se especificó área, usar areasPermitidas completo (mostrará todo lo autorizado)
$areasParaFiltrar = !empty($areaFiltro) ? [$areaFiltro] : $areasPermitidas;

$archivos   = $miAreaModelo->obtenerArchivos($categoriaFiltro, $busquedaFiltro, $areasParaFiltrar);
$categorias = $miAreaModelo->obtenerCategoriasConConteo($areasPermitidas);
$conteos    = $miAreaModelo->obtenerConteoPorArea();
$metricas   = $miAreaModelo->obtenerMetricas();

// Incluir la vista
require_once __DIR__ . '/../../vistas/miArea/miAreaVista.php';
