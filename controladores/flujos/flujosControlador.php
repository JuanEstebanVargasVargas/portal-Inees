<?php
// controladores/flujos/flujosControlador.php
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
require_once __DIR__ . '/../../modelos/flujoModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$flujoModelo     = new FlujoModelo($conexion);

$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

// Roles del usuario
$rol_id            = (int)$perfil['nivel_acceso'];
$rol_nombre        = $perfil['rol_nombre'] ?? 'Usuario';
$cargo_usuario     = strtolower(trim($perfil['cargo'] ?? ''));
$area_usuario      = strtolower(trim($perfil['area'] ?? ''));

$esSuperUsuario    = ($rol_id === 1);
$esGestionHumana   = ($rol_id === 2 || strtolower(trim($rol_nombre)) === 'gestion humana' || $area_usuario === 'rrhh');
$esEmpleado        = ($rol_id === 3);
$esContabilidad    = ($rol_id === 4);
$esSistemaGestion  = ($rol_id === 5 || strtolower(trim($rol_nombre)) === 'sistema de gestion');

// Privilegio exclusivo: Solo Sistema de Gestión puede cargar o eliminar flujos
$puedeCargar = $esSistemaGestion;

// ── Determinación de Áreas Autorizadas según el Rol ──────────────────
// Regla: Cada rol SOLO puede ver los flujos de su propia área
$areasPermitidas = [];

if ($esSistemaGestion) {
    // Sistema de Gestión tiene acceso completo para administrar y cargar en todas las divisiones
    $areasPermitidas = ['RECURSOS HUMANOS', 'GERENCIA', 'TECNICOS', 'ADMINISTRATIVO', 'EMPLEADO'];
} elseif ($esSuperUsuario) {
    // Gerencia / SuperUsuario
    $areasPermitidas = ['GERENCIA'];
} elseif ($esGestionHumana) {
    // Recursos Humanos / Gestión Humana
    $areasPermitidas = ['RECURSOS HUMANOS'];
} elseif ($esContabilidad) {
    // Administrativo / Contabilidad
    $areasPermitidas = ['ADMINISTRATIVO'];
} elseif ($esEmpleado) {
    // Rol Empleado: Si es perfil técnico, ve Técnicos y Empleado; si no, Empleado
    $esTecnico = (strpos($cargo_usuario, 'tecnic') !== false || 
                  strpos($cargo_usuario, 'téc') !== false || 
                  $area_usuario === 'laboratorio' || 
                  $area_usuario === 'maquinas');

    $esAdministrativoEmp = (strpos($cargo_usuario, 'admin') !== false || 
                            strpos($cargo_usuario, 'asistent') !== false);

    if ($esTecnico) {
        $areasPermitidas = ['TECNICOS', 'EMPLEADO'];
    } elseif ($esAdministrativoEmp) {
        $areasPermitidas = ['ADMINISTRATIVO', 'EMPLEADO'];
    } else {
        $areasPermitidas = ['EMPLEADO'];
    }
} else {
    $areasPermitidas = ['EMPLEADO'];
}

$mensajeExito = '';
$mensajeError = '';

// 2. Procesar acción de descarga / visualización
if (isset($_GET['accion']) && $_GET['accion'] === 'descargar' && !empty($_GET['id'])) {
    $flujoId = (int)$_GET['id'];
    $flujo = $flujoModelo->obtenerFlujoPorId($flujoId);
    if ($flujo) {
        // Validación de permisos por división
        if (!in_array($flujo['area'], $areasPermitidas, true)) {
            $mensajeError = 'Acceso denegado: Tu perfil no tiene autorización para consultar flujos del área ' . htmlspecialchars($flujo['area']) . '.';
        } else {
            $rutaFisica = __DIR__ . '/../../' . ltrim($flujo['ruta_archivo'], '/\\');
            if (file_exists($rutaFisica)) {
                if (ob_get_level()) {
                    ob_end_clean();
                }
                $mimeType = mime_content_type($rutaFisica) ?: 'application/octet-stream';
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $mimeType);
                header('Content-Disposition: inline; filename="' . basename($flujo['nombre_original']) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($rutaFisica));
                readfile($rutaFisica);
                exit;
            } else {
                $mensajeError = 'El archivo físico del flujo no se encuentra en el servidor.';
            }
        }
    } else {
        $mensajeError = 'Flujo no encontrado.';
    }
}

// 3. Procesar eliminación de flujo (Solo Sistema de Gestión)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar_flujo') {
    if (!$puedeCargar) {
        $mensajeError = 'Acceso denegado: Solo el rol de Sistema de Gestión está autorizado para eliminar flujos.';
    } else {
        $flujoId = (int)($_POST['flujo_id'] ?? 0);
        $flujo = $flujoModelo->obtenerFlujoPorId($flujoId);
        if ($flujo) {
            $flujoModelo->eliminarFlujo($flujoId);
            $mensajeExito = 'El flujo "' . htmlspecialchars($flujo['titulo']) . '" ha sido eliminado exitosamente.';
        } else {
            $mensajeError = 'No se encontró el flujo que se intentó eliminar.';
        }
    }
}

// 4. Procesar carga de nuevo flujo (Solo Sistema de Gestión)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'cargar_flujo') {
    if (!$puedeCargar) {
        $mensajeError = 'Acceso denegado: Solo el rol de Sistema de Gestión tiene permisos para cargar flujos de procesos.';
    } else {
        $titulo      = trim($_POST['titulo'] ?? '');
        $area        = trim($_POST['area'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        // 5 divisiones válidas
        $areasValidas = ['RECURSOS HUMANOS', 'GERENCIA', 'TECNICOS', 'ADMINISTRATIVO', 'EMPLEADO'];

        if (empty($titulo)) {
            $mensajeError = 'Por favor ingresa un título para el flujo.';
        } elseif (!in_array($area, $areasValidas, true)) {
            $mensajeError = 'Debes seleccionar una división válida: Recursos Humanos, Gerencia, Técnicos, Administrativo o Empleado.';
        } elseif (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            $mensajeError = 'Por favor selecciona un archivo válido para cargar.';
        } else {
            $fileTmp   = $_FILES['archivo']['tmp_name'];
            $fileName  = $_FILES['archivo']['name'];
            $fileSize  = $_FILES['archivo']['size'];
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $permitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'svg', 'zip', 'rar'];
            $maxBytes   = 35 * 1024 * 1024; // 35 MB

            if (!in_array($extension, $permitidas, true)) {
                $mensajeError = 'Formato de archivo no admitido. Se permiten: ' . implode(', ', $permitidas);
            } elseif ($fileSize > $maxBytes) {
                $mensajeError = 'El archivo excede el tamaño máximo permitido de 35 MB.';
            } else {
                $uploadDir = __DIR__ . '/../../uploads/flujos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $nuevoNombre = 'flujo_' . strtolower(preg_replace('/[^a-z0-9]/', '', $area)) . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
                $destino = $uploadDir . $nuevoNombre;

                if (move_uploaded_file($fileTmp, $destino)) {
                    $rutaRelativa = 'uploads/flujos/' . $nuevoNombre;

                    $flujoModelo->guardarFlujo([
                        'titulo'          => $titulo,
                        'descripcion'     => $descripcion,
                        'area'            => $area,
                        'nombre_original' => $fileName,
                        'ruta_archivo'    => $rutaRelativa,
                        'tamano'          => $fileSize,
                        'tipo'            => $extension,
                        'usuario_id'      => $usuario_id,
                        'fecha_subida'    => date('Y-m-d H:i:s')
                    ]);

                    $mensajeExito = '¡Flujo cargado exitosamente en la división ' . htmlspecialchars($area) . '!';
                } else {
                    $mensajeError = 'Ocurrió un error al guardar el archivo en el servidor.';
                }
            }
        }
    }
}

// 5. Filtrado estricto según áreas permitidas
// NUNCA se permite acceder a un área fuera de $areasPermitidas
$solicitudArea = strtoupper(trim($_POST['area_filtro'] ?? ($_GET['area'] ?? '')));

if ($esSistemaGestion && $solicitudArea === 'TODOS') {
    // SG puede ver todas las divisiones sin filtro activo
    $areaFiltro = '';
} elseif (!empty($solicitudArea) && in_array($solicitudArea, $areasPermitidas, true)) {
    // El área solicitada está en la lista de permitidas → aplicar
    $areaFiltro = $solicitudArea;
} else {
    // Sin área solicitada, o área NO permitida → forzar la primera área autorizada
    $areaFiltro = $areasPermitidas[0] ?? 'EMPLEADO';
}

$busquedaFiltro = trim($_GET['q'] ?? '');

$flujos = $flujoModelo->obtenerFlujos($areaFiltro, $busquedaFiltro, $areasPermitidas);
$conteos = $flujoModelo->obtenerConteoPorArea();

require_once __DIR__ . '/../../vistas/flujos/flujosVista.php';
