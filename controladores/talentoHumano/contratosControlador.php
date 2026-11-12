<?php
// controladores/talentoHumano/contratosControlador.php
date_default_timezone_set('America/Bogota');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Control de acceso
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../modelos/dashboardModelo.php';
require_once __DIR__ . '/../../modelos/contratoModelo.php';

if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

$dashboardModelo = new DashboardModelo($conexion);
$contratoModelo  = new ContratoModelo($conexion);

$usuario_id = (int)$_SESSION['usuario_id'];
$perfil     = $dashboardModelo->obtenerUsuarioPorId($usuario_id);

if (!$perfil || $perfil['estado'] !== 'activo') {
    header('Location: ../../logout.php');
    exit;
}

$rol_id          = (int)$perfil['nivel_acceso'];
$rol_nombre      = $perfil['rol_nombre'] ?? 'Usuario';
$esSuperUsuario  = ($rol_id === 1);
$esGestionHumana = ($rol_id === 2);
$esEmpleado      = ($rol_id === 3);

// 2. Endpoint API JSON para auto-llenar datos de un usuario existente
if (isset($_GET['api']) && $_GET['api'] === 'usuario_data') {
    header('Content-Type: application/json; charset=utf-8');
    $uid = (int)($_GET['uid'] ?? 0);
    if ($uid > 0) {
        $userData = $contratoModelo->obtenerUsuarioParaAutoLlenado($uid);
        if ($userData) {
            echo json_encode(['success' => true, 'data' => $userData], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

// Empleados solo pueden ver su propia hoja de vida si existe
if ($esEmpleado && !isset($_GET['accion'])) {
    $propio = $contratoModelo->obtenerPorUsuarioId($usuario_id);
    if ($propio) {
        $_GET['accion'] = 'ver';
        $_GET['id'] = $propio['id'];
    }
}

$mensajeExito = '';
$mensajeError = '';

// Carpeta de subida de fotos
$uploadDir = __DIR__ . '/../../uploads/hojas_vida/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 3. Procesamiento de formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Solo SuperUsuario y Gestión Humana pueden crear/editar/eliminar
    if (!$esSuperUsuario && !$esGestionHumana) {
        die("Acceso denegado.");
    }

    $accionPost = trim($_POST['accion'] ?? '');

    // ── Eliminar Contrato ──
    if ($accionPost === 'eliminar') {
        $eliminarId = (int)($_POST['id'] ?? 0);
        if ($eliminarId > 0) {
            $reg = $contratoModelo->obtenerPorId($eliminarId);
            if ($reg) {
                if (!empty($reg['foto']) && file_exists(__DIR__ . '/../../' . $reg['foto']) && strpos($reg['foto'], 'default') === false) {
                    @unlink(__DIR__ . '/../../' . $reg['foto']);
                }
                $contratoModelo->eliminar($eliminarId);
                header("Location: contratosControlador.php?msg=eliminado");
                exit;
            }
        }
    }

    // ── Crear o Editar Contrato ──
    if ($accionPost === 'crear' || $accionPost === 'editar') {
        $idEditar = (int)($_POST['id'] ?? 0);

        // Procesar subida de foto
        $fotoRuta = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fileTmp  = $_FILES['foto']['tmp_name'];
            $fileName = $_FILES['foto']['name'];
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $permitidas, true)) {
                $nuevoNombre = 'hv_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $fileExt;
                $destino = $uploadDir . $nuevoNombre;
                if (move_uploaded_file($fileTmp, $destino)) {
                    $fotoRuta = 'uploads/hojas_vida/' . $nuevoNombre;
                }
            } else {
                $mensajeError = "Formato de imagen no permitido. Use JPG, PNG o WEBP.";
            }
        }

        // Procesar tabla dinámica de documentos de vencimiento
        $docsArray = [];
        $docNombres = $_POST['doc_nombre'] ?? [];
        $docFechas  = $_POST['doc_fecha'] ?? [];
        if (is_array($docNombres) && is_array($docFechas)) {
            for ($i = 0; $i < count($docNombres); $i++) {
                $dNom = trim($docNombres[$i] ?? '');
                $dFec = trim($docFechas[$i] ?? '');
                if ($dNom !== '') {
                    $docsArray[] = [
                        'dato'              => $dNom,
                        'fecha_vencimiento' => $dFec
                    ];
                }
            }
        }
        $docsJson = json_encode($docsArray, JSON_UNESCAPED_UNICODE);

        // Procesar tabla dinámica de dotación
        $dotArray = [];
        $dotRefs   = $_POST['dot_ref'] ?? [];
        $dotTallas = $_POST['dot_talla'] ?? [];
        $dotE1     = $_POST['dot_e1'] ?? [];
        $dotE2     = $_POST['dot_e2'] ?? [];
        $dotE3     = $_POST['dot_e3'] ?? [];

        if (is_array($dotRefs)) {
            for ($i = 0; $i < count($dotRefs); $i++) {
                $r = trim($dotRefs[$i] ?? '');
                if ($r !== '') {
                    $dotArray[] = [
                        'referencia' => $r,
                        'talla'      => trim($dotTallas[$i] ?? ''),
                        'entrega_1'  => trim($dotE1[$i] ?? ''),
                        'entrega_2'  => trim($dotE2[$i] ?? ''),
                        'entrega_3'  => trim($dotE3[$i] ?? '')
                    ];
                }
            }
        }
        $dotJson = json_encode($dotArray, JSON_UNESCAPED_UNICODE);

        // Armar arreglo de datos
        $datosContrato = [
            'usuario_id'                     => !empty($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : null,
            'nombre_completo'                => trim($_POST['nombre_completo'] ?? ''),
            'cargo'                          => trim($_POST['cargo'] ?? ''),
            'telefono'                       => trim($_POST['telefono'] ?? ''),
            'email'                          => trim($_POST['email'] ?? ''),
            'direccion'                      => trim($_POST['direccion'] ?? ''),
            'cedula'                         => trim($_POST['cedula'] ?? ''),
            'fecha_nacimiento'               => trim($_POST['fecha_nacimiento'] ?? ''),
            'rh'                             => trim($_POST['rh'] ?? ''),
            'contacto_emergencia_nombre'     => trim($_POST['contacto_emergencia_nombre'] ?? ''),
            'contacto_emergencia_cel'        => trim($_POST['contacto_emergencia_cel'] ?? ''),
            'contacto_emergencia_parentesco' => trim($_POST['contacto_emergencia_parentesco'] ?? ''),
            'estado_civil'                   => trim($_POST['estado_civil'] ?? 'Soltero'),
            'conyuge_nombre'                 => trim($_POST['conyuge_nombre'] ?? 'N/A'),
            'conyuge_cel'                    => trim($_POST['conyuge_cel'] ?? 'N/A'),
            'num_hijos'                      => trim($_POST['num_hijos'] ?? '0'),
            'eps'                            => trim($_POST['eps'] ?? ''),
            'arl'                            => trim($_POST['arl'] ?? ''),
            'caja_compensacion'              => trim($_POST['caja_compensacion'] ?? ''),
            'fondo_pensiones'                => trim($_POST['fondo_pensiones'] ?? ''),
            'formacion_academica'            => trim($_POST['formacion_academica'] ?? ''),
            'experiencia_empresa'            => trim($_POST['experiencia_empresa'] ?? ''),
            'experiencia_cargo'              => trim($_POST['experiencia_cargo'] ?? ''),
            'documentos_vencimientos'        => $docsJson,
            'tipo_contrato'                  => trim($_POST['tipo_contrato'] ?? 'Contrato a término indefinido'),
            'fecha_ingreso'                  => trim($_POST['fecha_ingreso'] ?? ''),
            'salario'                        => trim($_POST['salario'] ?? ''),
            'banco'                          => trim($_POST['banco'] ?? ''),
            'tipo_cuenta'                    => trim($_POST['tipo_cuenta'] ?? 'Ahorros'),
            'num_cuenta'                     => trim($_POST['num_cuenta'] ?? ''),
            'dotacion_datos'                 => $dotJson,
            'estado'                         => trim($_POST['estado'] ?? 'activo'),
            'creado_por'                     => $usuario_id
        ];

        if ($fotoRuta !== null) {
            $datosContrato['foto'] = $fotoRuta;
        }

        if (empty($datosContrato['nombre_completo']) || empty($datosContrato['cedula'])) {
            $mensajeError = "El nombre completo y la cédula de ciudadanía son obligatorios.";
        } else {
            if ($accionPost === 'crear') {
                $nuevoId = $contratoModelo->crear($datosContrato);
                if ($nuevoId > 0) {
                    header("Location: contratosControlador.php?accion=ver&id=" . $nuevoId . "&msg=creado");
                    exit;
                } else {
                    $mensajeError = "Ocurrió un error al guardar la hoja de vida.";
                }
            } elseif ($accionPost === 'editar' && $idEditar > 0) {
                $ok = $contratoModelo->actualizar($idEditar, $datosContrato);
                if ($ok) {
                    header("Location: contratosControlador.php?accion=ver&id=" . $idEditar . "&msg=actualizado");
                    exit;
                } else {
                    $mensajeError = "No se pudo actualizar el registro.";
                }
            }
        }
    }
}

// 4. Parámetros de vista GET
$accionGet = trim($_GET['accion'] ?? 'listar');
$idGet     = (int)($_GET['id'] ?? 0);
$busqueda  = trim($_GET['buscar'] ?? '');
$filtroEst = trim($_GET['filtro_estado'] ?? '');

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'creado') {
        $mensajeExito = "¡Hoja de vida y contrato creados exitosamente!";
    } elseif ($_GET['msg'] === 'actualizado') {
        $mensajeExito = "¡Información actualizada correctamente!";
    } elseif ($_GET['msg'] === 'eliminado') {
        $mensajeExito = "El contrato fue eliminado correctamente.";
    }
}

$registroActual = null;
if (($accionGet === 'ver' || $accionGet === 'editar' || $accionGet === 'imprimir') && $idGet > 0) {
    $registroActual = $contratoModelo->obtenerPorId($idGet);
    if (!$registroActual) {
        $mensajeError = "El contrato solicitado no fue encontrado.";
        $accionGet = 'listar';
    }
}

$contratos     = $contratoModelo->obtenerTodos($busqueda, $filtroEst);
$estadisticas  = $contratoModelo->obtenerEstadisticas();
$listaUsuarios = $contratoModelo->obtenerUsuariosParaSelect();

// Incluir la vista principal
require_once __DIR__ . '/../../vistas/talentoHumano/contratosVista.php';
