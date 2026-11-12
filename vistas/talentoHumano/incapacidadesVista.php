<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">`r`n    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title>Incapacidades — Portal INEES</title>
    <style>
        :root {
            --primary:       #0d9488;
            --primary-dark:  #0f766e;
            --primary-light: #f0fdfa;
            --bg-page:       #edf2f7;
            --bg-card:       #ffffff;
            --text-main:     #0f223d;
            --text-muted:    #52637a;
            --border:        #dbe3eb;
            --border-light:  #e6edf4;
            --radius-sm:     8px;
            --radius-md:     12px;
            --radius-lg:     16px;
            --shadow-sm:     0 1px 3px rgba(15,34,61,.06);
            --shadow-md:     0 4px 14px rgba(15,34,61,.08);
            --shadow-lg:     0 12px 24px -4px rgba(15,34,61,.12);
        }

        * { box-sizing: border-box; margin: 0; padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        body { background: var(--bg-page); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; }

        main {
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 20px 60px;
            flex: 1;
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb-sep { color: var(--border); }

        /* ── Hero Banner ── */
        .incapacidades-hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #083344 100%);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 28px -5px rgba(11,23,40,.4);
            border: 1px solid rgba(13,148,136,.35);
        }

        .incapacidades-hero::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(13,148,136,.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-left {
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 1;
        }

        .hero-icon {
            width: 62px;
            height: 62px;
            border-radius: 14px;
            background: rgba(13,148,136,.15);
            border: 1.5px solid rgba(13,148,136,.4);
            color: #2dd4bf;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(13,148,136,.2);
        }

        .hero-title h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .hero-title p {
            color: #94a3b8;
            font-size: 14px;
        }

        .hero-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1;
            flex-wrap: wrap;
        }

        .hero-stat-pill {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .15);
            padding: 8px 16px;
            border-radius: 20px;
            color: #ffffff;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(4px);
        }
        .hero-stat-pill strong {
            color: #5eead4;
            font-size: 15px;
        }

        /* ── Alerts ── */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Tabs Navigation ── */
        .tabs-container {
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 2px solid var(--border-light);
            margin-bottom: 24px;
        }
        .tab-btn {
            background: transparent;
            border: none;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color .2s;
        }
        .tab-btn:hover {
            color: var(--primary);
        }
        .tab-btn.active {
            color: var(--primary);
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary);
            border-radius: 2px 2px 0 0;
        }

        /* ── Content Panes ── */
        .tab-pane {
            display: none;
        }
        .tab-pane.active {
            display: block;
        }

        /* ── Card Containers ── */
        .card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 28px;
            margin-bottom: 28px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-light);
        }
        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── Form Styles ── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
        }
        .col-12 { grid-column: span 12; }
        .col-6  { grid-column: span 6; }
        .col-4  { grid-column: span 4; }
        .col-3  { grid-column: span 3; }
        .col-8  { grid-column: span 8; }

        @media (max-width: 768px) {
            .col-6, .col-4, .col-3, .col-8 {
                grid-column: span 12;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }
        .form-label .req {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            color: var(--text-main);
            background: #ffffff;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,.15);
        }
        .form-control[readonly], .form-control:disabled {
            background: #f8fafc;
            color: #64748b;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 75px;
        }

        .section-separator {
            grid-column: span 12;
            margin: 12px 0 6px;
            padding-bottom: 8px;
            border-bottom: 1.5px solid var(--border-light);
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── File Upload Drop Area ── */
        .file-upload-box {
            border: 2px dashed #cbd5e1;
            border-radius: var(--radius-md);
            padding: 24px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all .2s;
            position: relative;
        }
        .file-upload-box:hover {
            border-color: var(--primary);
            background: #f0fdfa;
        }
        .file-upload-box input[type="file"] {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .file-upload-icon {
            color: var(--primary);
            margin-bottom: 8px;
        }
        .file-upload-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
        }
        .file-upload-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }
        .file-selected-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-top: 8px;
            display: none;
            word-break: break-all;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s ease;
            border: none;
        }
        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(13,148,136,.3);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }
        .btn-secondary:hover {
            background: #cbd5e1;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* ── Status Badges ── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge-pendiente {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-aprobada {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-validada_eps {
            background: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }
        .badge-rechazada {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Data Table ── */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }
        .data-table th {
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .data-table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }
        .data-table tr:hover td {
            background: #f8fafc;
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-box {
            background: #ffffff;
            border-radius: var(--radius-md);
            max-width: 600px;
            width: 100%;
            padding: 26px 30px;
            box-shadow: var(--shadow-lg);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }
        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
        }
        .modal-close {
            background: transparent;
            border: none;
            font-size: 24px;
            color: #94a3b8;
            cursor: pointer;
            line-height: 1;
        }

        .attachment-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdfa;
            color: var(--primary-dark);
            border: 1px solid #ccfbf1;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .attachment-link-btn:hover {
            background: var(--primary);
            color: #ffffff;
        }

        /* ── Aviso Informativo del Proceso ── */
        .aviso-proceso-empleado {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-left: 4px solid var(--primary);
            border-radius: var(--radius-sm);
            padding: 16px 18px;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            box-shadow: 0 1px 4px rgba(13,148,136,.06);
        }
        .aviso-proceso-icon {
            color: var(--primary);
            flex-shrink: 0;
            margin-top: 2px;
        }
        .aviso-proceso-titulo {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }
        .aviso-proceso-texto {
            font-size: 13px;
            line-height: 1.55;
            color: #134e4a;
        }
    </style>
</head>
<body>

<?php
// Inclusión modular de Navbar y Sidebar
require_once __DIR__ . '/../partials/navbar/navbar.php';
require_once __DIR__ . '/../partials/sidebar/sidebar.php';
?>

<main>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="../../index.php">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Inicio
        </a>
        <span class="breadcrumb-sep">›</span>
        <span>Talento Humano</span>
        <span class="breadcrumb-sep">›</span>
        <span>Incapacidades</span>
    </nav>

    <!-- Hero Banner -->
    <div class="incapacidades-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                </svg>
            </div>
            <div class="hero-title">
                <h1><?= $puedeGestionarIncapacidades ? 'Evidenciación y Gestión de Incapacidades' : 'Carga de Incapacidades Médicas' ?></h1>
                <p>
                    <?php if ($puedeGestionarIncapacidades): ?>
                        Gestión de Talento Humano · Evidencia, valida y tramita los soportes médicos de los colaboradores ante las EPS / ARL.
                    <?php else: ?>
                        Carga el soporte de tu incapacidad médica expedida por la EPS para registro y trámite por Talento Humano.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Total: <strong><?= $estadisticas['total'] ?? 0 ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Pendientes: <strong style="color:#fbbf24;"><?= $estadisticas['pendientes'] ?? 0 ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>Aprobadas/Validadas: <strong style="color:#4ade80;"><?= ($estadisticas['aprobadas'] ?? 0) + ($estadisticas['validadas_eps'] ?? 0) ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>Días Totales: <strong><?= $estadisticas['total_dias'] ?? 0 ?></strong></span>
            </div>
        </div>
    </div>

    <!-- Mensajes Flash -->
    <?php if (!empty($mensajeExito)): ?>
        <div class="alert alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div><?= htmlspecialchars($mensajeExito) ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensajeError)): ?>
        <div class="alert alert-danger">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div><?= htmlspecialchars($mensajeError) ?></div>
        </div>
    <?php endif; ?>

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <?php if ($puedeGestionarIncapacidades): ?>
            <!-- Camila / Gestión Humana: Evidenciación primero -->
            <button type="button" class="tab-btn active" id="tab-btn-evidenciar" onclick="cambiarTabIncap('evidenciar')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Evidenciación de Incapacidades (<?= count($listaIncapacidades) ?>)
            </button>
            <button type="button" class="tab-btn" id="tab-btn-cargar" onclick="cambiarTabIncap('cargar')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                + Cargar Nueva Incapacidad
            </button>
        <?php else: ?>
            <!-- Empleado: Cargar primero -->
            <button type="button" class="tab-btn active" id="tab-btn-cargar" onclick="cambiarTabIncap('cargar')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                Cargar Incapacidad Médica
            </button>
            <button type="button" class="tab-btn" id="tab-btn-mis-incapacidades" onclick="cambiarTabIncap('mis-incapacidades')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Mis Incapacidades (<?= count($listaIncapacidades) ?>)
            </button>
        <?php endif; ?>
    </div>

    <!-- ═════════════════════════════════════════════════════════════════
         SECCIÓN: FORMULARIO DE CARGA DE INCAPACIDAD
         ═════════════════════════════════════════════════════════════════ -->
    <div class="tab-pane <?= (!$puedeGestionarIncapacidades) ? 'active' : '' ?>" id="pane-cargar">
        <?php if (!$puedeGestionarIncapacidades): ?>
        <!-- Mensaje de Notificación de Proceso para Empleado -->
        <div class="aviso-proceso-empleado">
            <div class="aviso-proceso-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <div class="aviso-proceso-body">
                <div class="aviso-proceso-titulo">Información sobre el trámite de tu incapacidad</div>
                <div class="aviso-proceso-texto">
                    Una vez radicada tu incapacidad con el soporte médico correspondiente, el área de <strong>Gestión Humana</strong> validará el documento ante la EPS/ARL. Se te notificará el estado del trámite (<strong>Aprobado</strong> o <strong>Denegado</strong>) a través de tu <strong>correo electrónico registrado</strong> y en la pestaña de tus radicados.
                </div>
            </div>
        </div>
        <?php endif; ?>

        <form method="POST" action="incapacidadesControlador.php" enctype="multipart/form-data" class="card" id="form-incapacidad">
            <input type="hidden" name="accion" value="cargar_incapacidad">

            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    <span>Datos de la Incapacidad Médica y Soporte</span>
                </div>
                <span class="badge-status badge-pendiente">Radicación Digital</span>
            </div>

            <div class="form-grid">

                <!-- Si es Camila / SuperUsuario, puede registrar a nombre de cualquier usuario -->
                <?php if ($puedeGestionarIncapacidades): ?>
                    <div class="section-separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        1. Colaborador que presenta la incapacidad
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label">Seleccionar Colaborador <span class="req">*</span></label>
                        <select name="empleado_seleccionado_id" class="form-control" required onchange="actualizarDatosColaborador(this)">
                            <option value="">-- Seleccionar colaborador de la lista --</option>
                            <?php foreach ($listaColaboradores as $c): ?>
                                <option value="<?= $c['usuario_id'] ?>"
                                        data-nombre="<?= htmlspecialchars($c['nombre']) ?>"
                                        data-cedula="<?= htmlspecialchars($c['cedula']) ?>"
                                        data-cargo="<?= htmlspecialchars($c['cargo']) ?>"
                                        data-area="<?= htmlspecialchars($c['area']) ?>"
                                        <?= ($c['usuario_id'] === $usuario_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['nombre']) ?> (C.C. <?= htmlspecialchars($c['cedula']) ?>) - <?= htmlspecialchars($c['cargo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <div class="section-separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        1. Datos del Colaborador
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label">Nombre del Colaborador</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($perfil['nombre']) ?>" readonly>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label">Cédula de Ciudadanía</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($perfil['cedula']) ?>" readonly>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label">Cargo</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($perfil['cargo']) ?>" readonly>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label">Área / Departamento</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($perfil['area']) ?>" readonly>
                    </div>
                <?php endif; ?>

                <!-- Datos Médicos -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    2. Información Médica de la Incapacidad
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Tipo de Incapacidad <span class="req">*</span></label>
                    <select name="tipo_incapacidad" class="form-control" required>
                        <option value="Enfermedad General">Enfermedad General</option>
                        <option value="Accidente de Trabajo (ARL)">Accidente de Trabajo (ARL)</option>
                        <option value="Accidente de Tránsito / Común">Accidente de Tránsito / Común</option>
                        <option value="Licencia de Maternidad / Paternidad">Licencia de Maternidad / Paternidad</option>
                        <option value="Cirugía / Hospitalización">Cirugía / Hospitalización</option>
                        <option value="Prórroga">Prórroga de Incapacidad Previa</option>
                        <option value="Otro">Otro Tipo</option>
                    </select>
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Entidad de Salud (EPS / ARL) <span class="req">*</span></label>
                    <input type="text" name="eps" class="form-control" list="eps-comunes" placeholder="Ej: Sanitas, Sura, Nueva EPS, Compensar..." required>
                    <datalist id="eps-comunes">
                        <option value="Sanitas">
                        <option value="Sura">
                        <option value="Nueva EPS">
                        <option value="Compensar">
                        <option value="Famisanar">
                        <option value="Salud Total">
                        <option value="Savia Salud">
                        <option value="Coosalud">
                        <option value="Seguros Bolívar (ARL)">
                        <option value="Positiva (ARL)">
                    </datalist>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Código Diagnóstico CIE-10 (Opcional)</label>
                    <input type="text" name="codigo_cie10" class="form-control" placeholder="Ej: J06.9, M54.5, K29...">
                </div>

                <div class="form-group col-8">
                    <label class="form-label">Descripción del Diagnóstico Médico</label>
                    <input type="text" name="descripcion_diagnostico" class="form-control" placeholder="Ej: Infección respiratoria aguda, lumbago no especificado...">
                </div>

                <!-- Período de Incapacidad -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    3. Período y Días de Reposo
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Fecha de Inicio (Desde) <span class="req">*</span></label>
                    <input type="date" name="fecha_inicio" id="incap_fecha_inicio" class="form-control" value="<?= date('Y-m-d') ?>" required onchange="calcularDiasIncapacidad()">
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Fecha de Fin (Hasta) <span class="req">*</span></label>
                    <input type="date" name="fecha_fin" id="incap_fecha_fin" class="form-control" value="<?= date('Y-m-d') ?>" required onchange="calcularDiasIncapacidad()">
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Total Días de Incapacidad</label>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <input type="number" id="incap_dias_display" class="form-control" value="1" readonly style="font-weight:700; color:var(--primary-dark); font-size:16px;">
                        <span style="font-size:13px; color:var(--text-muted); white-space:nowrap;">días calendario</span>
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="form-label">¿Es prórroga de una incapacidad anterior?</label>
                    <div style="display:flex; gap:20px; align-items:center; padding:8px 14px; background:#f8fafc; border:1px solid var(--border-light); border-radius:var(--radius-sm);">
                        <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer;">
                            <input type="radio" name="es_prorroga" value="no" checked>
                            No (Incapacidad inicial)
                        </label>
                        <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer;">
                            <input type="radio" name="es_prorroga" value="si">
                            Sí (Es continuación / prórroga)
                        </label>
                    </div>
                </div>

                <!-- Carga de Archivo Soporte -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                    4. Adjuntar Certificado Médico / Soporte EPS
                </div>

                <div class="form-group col-12">
                    <div class="file-upload-box" id="drop-area">
                        <input type="file" name="soporte_medico" id="soporte_medico" accept=".pdf,image/png,image/jpeg,image/jpg" onchange="mostrarNombreArchivo(this)" required>
                        <div class="file-upload-icon">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <div class="file-upload-text">Haz clic aquí o arrastra tu archivo del certificado médico</div>
                        <div class="file-upload-hint">Formatos aceptados: PDF, JPG, PNG (Máximo 10 MB). Asegúrate de que la fecha y diagnóstico sean legibles.</div>
                        <div class="file-selected-name" id="file-name-preview"></div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="form-label">Observaciones Adicionales (Opcional)</label>
                    <textarea name="observaciones_empleado" class="form-control" rows="2" placeholder="Agrega cualquier comentario o aclaración sobre tu incapacidad..."></textarea>
                </div>

                <div class="form-group col-12" style="display:flex; justify-content:flex-end; gap:12px; margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Radicar y Cargar Incapacidad
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- ═════════════════════════════════════════════════════════════════
         SECCIÓN: EVIDENCIACIÓN DE INCAPACIDADES (PARA CAMILA / GESTIÓN HUMANA)
         O MIS INCAPACIDADES (PARA EMPLEADO)
         ═════════════════════════════════════════════════════════════════ -->
    <div class="tab-pane <?= ($puedeGestionarIncapacidades) ? 'active' : '' ?>" id="<?= ($puedeGestionarIncapacidades) ? 'pane-evidenciar' : 'pane-mis-incapacidades' ?>">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span><?= $puedeGestionarIncapacidades ? 'Panel de Evidenciación y Gestión de Incapacidades' : 'Historial de Mis Incapacidades' ?></span>
                </div>
                <button type="button" class="btn btn-primary btn-sm" onclick="cambiarTabIncap('cargar')">
                    + Cargar Incapacidad
                </button>
            </div>

            <!-- Filtros rápidos para Camila / SuperUsuario -->
            <?php if ($puedeGestionarIncapacidades): ?>
                <div style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap; align-items:center;">
                    <input type="text" id="filtro-texto-incap" class="form-control" style="max-width:280px;" placeholder="Buscar colaborador, cédula o EPS..." oninput="filtrarTablaIncapacidades()">
                    
                    <select id="filtro-estado-incap" class="form-control" style="max-width:200px;" onchange="filtrarTablaIncapacidades()">
                        <option value="todos">Todos los estados</option>
                        <option value="pendiente">Solo Pendientes</option>
                        <option value="aprobada">Aprobadas</option>
                        <option value="validada_eps">Validadas con EPS</option>
                        <option value="rechazada">Rechazadas</option>
                    </select>

                    <span style="font-size:12px; color:var(--text-muted); margin-left:auto;">
                        Mostrando <strong id="incap-conteo-visibles"><?= count($listaIncapacidades) ?></strong> registros
                    </span>
                </div>
            <?php endif; ?>

            <?php if (empty($listaIncapacidades)): ?>
                <div style="text-align:center; padding: 48px 20px; color: var(--text-muted);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px; color:#94a3b8;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    <p style="font-size:16px; font-weight:700; color:var(--text-main);">No hay incapacidades registradas</p>
                    <p style="font-size:13px; margin-top:4px;">Haz clic en "Cargar Incapacidad" para radicar el primer soporte médico.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="data-table" id="tabla-incapacidades">
                        <thead>
                            <tr>
                                <th># Radicado</th>
                                <?php if ($puedeGestionarIncapacidades): ?>
                                    <th>Colaborador</th>
                                <?php endif; ?>
                                <th>Tipo de Incapacidad</th>
                                <th>EPS / Entidad</th>
                                <th>Período</th>
                                <th>Días</th>
                                <th>Diagnóstico / CIE-10</th>
                                <th>Soporte Médico</th>
                                <th>Estado</th>
                                <th>Gestión RH</th>
                                <th style="text-align:right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaIncapacidades as $incap): 
                                $badgeClass = match($incap['estado']) {
                                    'aprobada'      => 'badge-aprobada',
                                    'validada_eps'  => 'badge-validada_eps',
                                    'rechazada'     => 'badge-rechazada',
                                    default         => 'badge-pendiente'
                                };
                                $estadoLabel = match($incap['estado']) {
                                    'aprobada'      => 'Aprobada',
                                    'validada_eps'  => 'Validada EPS',
                                    'rechazada'     => 'Rechazada',
                                    default         => 'Pendiente'
                                };
                            ?>
                                <tr class="incap-row-item"
                                    data-nombre="<?= htmlspecialchars(strtolower($incap['nombre_empleado'])) ?>"
                                    data-cedula="<?= htmlspecialchars(strtolower($incap['cedula'])) ?>"
                                    data-eps="<?= htmlspecialchars(strtolower($incap['eps'])) ?>"
                                    data-estado="<?= $incap['estado'] ?>">
                                    <td><strong>#<?= $incap['id'] ?></strong></td>

                                    <?php if ($puedeGestionarIncapacidades): ?>
                                        <td>
                                            <div style="font-weight:700; color:var(--text-main);"><?= htmlspecialchars($incap['nombre_empleado']) ?></div>
                                            <div style="font-size:11px; color:var(--text-muted);">
                                                C.C. <?= htmlspecialchars($incap['cedula']) ?> · <?= htmlspecialchars($incap['cargo']) ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>

                                    <td>
                                        <div style="font-weight:600;"><?= htmlspecialchars($incap['tipo_incapacidad']) ?></div>
                                        <?php if ($incap['es_prorroga'] === 'si'): ?>
                                            <span style="font-size:10px; background:#eff6ff; color:#2563eb; padding:1px 6px; border-radius:4px; font-weight:600;">Prórroga</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span style="font-weight:600; color:#0f766e;"><?= htmlspecialchars($incap['eps']) ?></span>
                                    </td>

                                    <td>
                                        <div style="font-weight:500;"><?= htmlspecialchars($incap['fecha_inicio']) ?></div>
                                        <div style="font-size:11px; color:var(--text-muted);">al <?= htmlspecialchars($incap['fecha_fin']) ?></div>
                                    </td>

                                    <td>
                                        <span style="font-weight:700; font-size:14px; color:var(--primary-dark);"><?= $incap['dias_incapacidad'] ?></span> días
                                    </td>

                                    <td>
                                        <?php if (!empty($incap['codigo_cie10'])): ?>
                                            <span style="font-family:monospace; font-weight:700; color:#334155;"><?= htmlspecialchars($incap['codigo_cie10']) ?></span>
                                        <?php endif; ?>
                                        <div style="font-size:11.5px; color:var(--text-muted); max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            <?= htmlspecialchars($incap['descripcion_diagnostico'] ?: 'Sin descripción') ?>
                                        </div>
                                    </td>

                                    <!-- Soporte Adjunto -->
                                    <td>
                                        <?php if (!empty($incap['archivo_adjunto'])): ?>
                                            <a href="../../<?= htmlspecialchars($incap['archivo_adjunto']) ?>" target="_blank" rel="noopener noreferrer" class="attachment-link-btn" title="Abrir soporte médico en nueva pestaña">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                Ver Soporte
                                            </a>
                                        <?php else: ?>
                                            <span style="color:#94a3b8; font-size:12px;">Sin archivo</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Estado -->
                                    <td>
                                        <span class="badge-status <?= $badgeClass ?>"><?= $estadoLabel ?></span>
                                    </td>

                                    <!-- Notas de Camila / RH -->
                                    <td>
                                        <?php if (!empty($incap['nombre_revisor'])): ?>
                                            <div style="font-size:11px; font-weight:600; color:#0f766e;"><?= htmlspecialchars($incap['nombre_revisor']) ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($incap['observaciones_rh'])): ?>
                                            <div style="font-size:11px; color:var(--text-muted); max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($incap['observaciones_rh']) ?>">
                                                <?= htmlspecialchars($incap['observaciones_rh']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span style="color:#94a3b8; font-size:11px;">--</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Acciones -->
                                    <td style="text-align:right;">
                                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                                            <?php if ($puedeGestionarIncapacidades): ?>
                                                <button type="button" class="btn btn-primary btn-sm" onclick='abrirModalGestionIncap(<?= json_encode($incap) ?>)' title="Revisar y gestionar">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                    Gestionar
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($puedeGestionarIncapacidades || $incap['estado'] === 'pendiente'): ?>
                                                <form method="POST" action="incapacidadesControlador.php" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar esta incapacidad?');">
                                                    <input type="hidden" name="accion" value="eliminar_incapacidad">
                                                    <input type="hidden" name="incapacidad_id" value="<?= $incap['id'] ?>">
                                                    <button type="submit" class="btn btn-secondary btn-sm" style="color:#ef4444;" title="Eliminar">
                                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<!-- ═════════════════════════════════════════════════════════════════
     MODAL DE GESTIÓN PARA CAMILA / GESTIÓN HUMANA
     ═════════════════════════════════════════════════════════════════ -->
<?php if ($puedeGestionarIncapacidades): ?>
<div class="modal-overlay" id="modal-gestion-incap">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="modal-incap-titulo">Gestionar Incapacidad Médica</div>
            <button type="button" class="modal-close" onclick="cerrarModalGestionIncap()">&times;</button>
        </div>

        <form method="POST" action="incapacidadesControlador.php">
            <input type="hidden" name="accion" value="gestionar_incapacidad">
            <input type="hidden" name="incapacidad_id" id="modal-incap-id" value="">

            <div style="background:#f8fafc; border:1px solid var(--border-light); border-radius:var(--radius-sm); padding:14px; margin-bottom:18px;">
                <div style="font-weight:700; color:var(--text-main); font-size:15px;" id="modal-incap-empleado">--</div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;" id="modal-incap-detalles">--</div>
                <div style="margin-top:8px;" id="modal-incap-soporte-link"></div>
            </div>

            <div class="form-group" style="margin-bottom:14px;">
                <label class="form-label">Estado de la Incapacidad <span class="req">*</span></label>
                <select name="estado" id="modal-incap-estado" class="form-control" required>
                    <option value="pendiente">Pendiente de revisión</option>
                    <option value="aprobada">Aprobada internamente (RH)</option>
                    <option value="validada_eps">Validada y radicada ante EPS / ARL</option>
                    <option value="rechazada">Rechazada (Soporte inválido / extemporáneo)</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom:18px;">
                <label class="form-label">Observaciones de Gestión Humana (Camila)</label>
                <textarea name="observaciones_rh" id="modal-incap-obs-rh" class="form-control" rows="3" placeholder="Ej: Radicado ante Sanitas #123456. Soporte completo y verificado..."></textarea>
                <span style="font-size:11px; color:var(--text-muted);">Estas observaciones quedan registradas con tu nombre y fecha actual.</span>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="cerrarModalGestionIncap()">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-sm">Guardar Gestión</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function cambiarTabIncap(tab) {
    const tabs = ['evidenciar', 'cargar', 'mis-incapacidades'];
    tabs.forEach(t => {
        const pane = document.getElementById('pane-' + t);
        const btn = document.getElementById('tab-btn-' + t);
        if (pane) pane.classList.remove('active');
        if (btn) btn.classList.remove('active');
    });

    const activePane = document.getElementById('pane-' + tab);
    const activeBtn = document.getElementById('tab-btn-' + tab);
    if (activePane) activePane.classList.add('active');
    if (activeBtn) activeBtn.classList.add('active');
}

function calcularDiasIncapacidad() {
    const fIniStr = document.getElementById('incap_fecha_inicio').value;
    const fFinStr = document.getElementById('incap_fecha_fin').value;
    const display = document.getElementById('incap_dias_display');

    if (!fIniStr || !fFinStr) return;

    const fIni = new Date(fIniStr + 'T00:00:00');
    const fFin = new Date(fFinStr + 'T00:00:00');

    if (fFin < fIni) {
        document.getElementById('incap_fecha_fin').value = fIniStr;
        display.value = 1;
        return;
    }

    const diffTime = Math.abs(fFin - fIni);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    display.value = diffDays;
}

function mostrarNombreArchivo(input) {
    const preview = document.getElementById('file-name-preview');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const tamMb = (file.size / (1024 * 1024)).toFixed(2);
        preview.textContent = `Archivo seleccionado: ${file.name} (${tamMb} MB)`;
        preview.style.display = 'block';
    } else {
        preview.textContent = '';
        preview.style.display = 'none';
    }
}

function filtrarTablaIncapacidades() {
    const busq = (document.getElementById('filtro-texto-incap')?.value || '').toLowerCase().trim();
    const estado = (document.getElementById('filtro-estado-incap')?.value || 'todos').toLowerCase();

    const rows = document.querySelectorAll('.incap-row-item');
    let visibles = 0;

    rows.forEach(row => {
        const rNombre = row.dataset.nombre || '';
        const rCedula = row.dataset.cedula || '';
        const rEps    = row.dataset.eps || '';
        const rEstado = row.dataset.estado || '';

        const coincideTexto = !busq || rNombre.includes(busq) || rCedula.includes(busq) || rEps.includes(busq);
        const coincideEstado = (estado === 'todos') || (rEstado === estado);

        if (coincideTexto && coincideEstado) {
            row.style.display = '';
            visibles++;
        } else {
            row.style.display = 'none';
        }
    });

    const contador = document.getElementById('incap-conteo-visibles');
    if (contador) contador.textContent = visibles;
}

function abrirModalGestionIncap(incap) {
    document.getElementById('modal-incap-id').value = incap.id;
    document.getElementById('modal-incap-empleado').textContent = `#${incap.id} - ${incap.nombre_empleado} (C.C. ${incap.cedula})`;
    document.getElementById('modal-incap-detalles').textContent = `${incap.tipo_incapacidad} | EPS: ${incap.eps} | Período: ${incap.fecha_inicio} al ${incap.fecha_fin} (${incap.dias_incapacidad} días)`;

    const soporteDiv = document.getElementById('modal-incap-soporte-link');
    if (incap.archivo_adjunto) {
        soporteDiv.innerHTML = `<a href="../../${incap.archivo_adjunto}" target="_blank" class="attachment-link-btn"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Abrir y revisar certificado médico adjunto</a>`;
    } else {
        soporteDiv.innerHTML = `<span style="color:#94a3b8; font-size:12px;">Sin archivo de soporte adjunto</span>`;
    }

    document.getElementById('modal-incap-estado').value = incap.estado || 'pendiente';
    document.getElementById('modal-incap-obs-rh').value = incap.observaciones_rh || '';

    document.getElementById('modal-gestion-incap').classList.add('active');
}

function cerrarModalGestionIncap() {
    document.getElementById('modal-gestion-incap').classList.remove('active');
}
</script>

</body>
</html>
