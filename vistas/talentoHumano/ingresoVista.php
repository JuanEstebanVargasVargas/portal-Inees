<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../img/logo.png">
    <title>Solicitud de Ingreso — Portal INEES</title>
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
        .ingreso-hero {
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

        .ingreso-hero::after {
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
            min-height: 70px;
        }

        .section-separator {
            grid-column: span 12;
            margin: 14px 0 6px;
            padding-bottom: 8px;
            border-bottom: 1.5px solid var(--border-light);
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Checklist Box ── */
        .checklist-grid {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            background: #f8fafc;
            padding: 18px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
        }
        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            color: var(--text-main);
            cursor: pointer;
        }
        .checklist-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            margin-top: 1px;
            cursor: pointer;
        }

        .notice-banner {
            grid-column: span 12;
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            font-size: 13.5px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
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
        }
        .badge-en_proceso {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .badge-contratado {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-pendiente {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-cancelado {
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

        /* ── Modal Detalle ── */
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
            max-width: 700px;
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
        <span>Solicitud de Ingreso</span>
    </nav>

    <!-- Hero Banner -->
    <div class="ingreso-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
            </div>
            <div class="hero-title">
                <h1>Solicitud de Ingreso de Personal</h1>
                <p>Vinculación de colaboradores, alistamiento de áreas y despacho automático del correo de bienvenida.</p>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Total: <strong><?= $estadisticas['total'] ?? 0 ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>En Proceso: <strong style="color:#60a5fa;"><?= $estadisticas['en_proceso'] ?? 0 ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>Contratados: <strong style="color:#4ade80;"><?= $estadisticas['contratados'] ?? 0 ?></strong></span>
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

    <?php if ($puedeGestionarIngresos): ?>
    <!-- Tabs Navigation (Solo visible para SuperUsuario y Gestión Humana) -->
    <div class="tabs-container">
        <button type="button" class="tab-btn <?= (!$solicitudDetalle) ? 'active' : '' ?>" id="tab-btn-formulario" onclick="cambiarTabIngreso('formulario')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Nueva Solicitud de Ingreso
        </button>
        <button type="button" class="tab-btn <?= ($solicitudDetalle) ? 'active' : '' ?>" id="tab-btn-historial" onclick="cambiarTabIngreso('historial')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Historial de Solicitudes (<?= count($listaSolicitudes) ?>)
        </button>
    </div>
    <?php endif; ?>

    <!-- ═════════════════════════════════════════════════════════════════
         TAB 1: FORMULARIO DE INGRESO
         ═════════════════════════════════════════════════════════════════ -->
    <div class="tab-pane active" id="pane-formulario">
        <?php if (!$puedeGestionarIngresos): ?>
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
                <div class="aviso-proceso-titulo">Información sobre el trámite de tu solicitud</div>
                <div class="aviso-proceso-texto">
                    Una vez diligenciado y enviado este formulario, la solicitud entrará en evaluación por el área de <strong>Gestión Humana</strong>. Te notificaremos a tu <strong>correo electrónico registrado</strong> y en el portal si la postulación fue <strong>Aprobada</strong> o <strong>Denegada</strong> para continuar con el proceso de contratación.
                </div>
            </div>
        </div>
        <?php endif; ?>

        <form method="POST" action="ingresoControlador.php" class="card" id="form-solicitud-ingreso">
            <input type="hidden" name="accion" value="crear_solicitud_ingreso">

            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Formulario de Ingreso y Notificación Automática</span>
                </div>
                <span class="badge-status badge-en_proceso">Gestión Humana &bull; INEES</span>
            </div>

            <div class="form-grid">

                <!-- 1. Datos Personales del Candidato -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    1. Datos Personales del Colaborador a Contratar
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Nombre Completo del Candidato <span class="req">*</span></label>
                    <input type="text" name="nombre_candidato" class="form-control" placeholder="Ej: CARLOS ANDRÉS PÉREZ GÓMEZ" required>
                </div>

                <div class="form-group col-3">
                    <label class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento" class="form-control">
                        <option value="C.C.">C.C. (Cédula de Ciudadanía)</option>
                        <option value="C.E.">C.E. (Cédula de Extranjería)</option>
                        <option value="P.E.P.">Permiso Especial / PPT</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>

                <div class="form-group col-3">
                    <label class="form-label">Número de Documento <span class="req">*</span></label>
                    <input type="text" name="cedula" class="form-control" placeholder="Ej: 1024567890" required>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control">
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Teléfono Móvil / Celular <span class="req">*</span></label>
                    <input type="text" name="celular" class="form-control" placeholder="Ej: 3101234567" required>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Correo Electrónico Personal <span class="req">*</span></label>
                    <input type="email" name="email_candidato" class="form-control" placeholder="candidato@gmail.com" required>
                    <span style="font-size:11px; color:#0f766e; font-weight:600;">✉️ A esta dirección se enviará el correo de bienvenida.</span>
                </div>

                <div class="form-group col-8">
                    <label class="form-label">Dirección de Residencia</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Ej: Calle 45 # 12-34 Apto 302">
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Ciudad de Residencia</label>
                    <input type="text" name="ciudad" class="form-control" value="Bogotá">
                </div>

                <!-- 2. Condiciones Laborales y del Cargo -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    2. Condiciones Laborales y del Cargo
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Cargo a Desempeñar <span class="req">*</span></label>
                    <input type="text" name="cargo" class="form-control" placeholder="Ej: Ingeniero de Soporte Técnico" required>
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Área / Departamento <span class="req">*</span></label>
                    <input type="text" name="area" class="form-control" list="areas-sugeridas" placeholder="Ej: Sistemas y TI, Operaciones, Laboratorio..." required>
                    <datalist id="areas-sugeridas">
                        <option value="Sistemas y TI">
                        <option value="Operaciones">
                        <option value="Laboratorio">
                        <option value="Gestión Humana">
                        <option value="Contabilidad y Finanzas">
                        <option value="Calidad">
                        <option value="Comercial">
                    </datalist>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Sede / Ubicación</label>
                    <select name="sede" class="form-control">
                        <option value="Sede Principal (Bogotá)">Sede Principal (Bogotá)</option>
                        <option value="Medellín">Medellín</option>
                        <option value="Trabajo Remoto">Trabajo Remoto</option>
                        <option value="En Sitio Cliente">En Sitio Cliente</option>
                    </select>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Tipo de Contrato <span class="req">*</span></label>
                    <select name="tipo_contrato" class="form-control">
                        <option value="Término Indefinido">Término Indefinido</option>
                        <option value="Término Fijo">Término Fijo</option>
                        <option value="Obra o Labor">Obra o Labor</option>
                        <option value="Aprendizaje SENA">Aprendizaje SENA</option>
                        <option value="Prestación de Servicios">Prestación de Servicios</option>
                    </select>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Salario / Asignación Mensual</label>
                    <input type="text" name="salario" class="form-control" placeholder="Ej: $ 2.500.000">
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Fecha de Ingreso Oficial <span class="req">*</span></label>
                    <input type="date" name="fecha_ingreso" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Horario Habitual de Trabajo</label>
                    <input type="text" name="horario_trabajo" class="form-control" value="Lunes a Viernes 7:30 am - 5:30 pm">
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Jefe Inmediato / Supervisor</label>
                    <input type="text" name="jefe_inmediato" class="form-control" placeholder="Ej: Coordinador de Área">
                </div>

                <!-- 3. Requerimientos de Alistamiento por Área -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    3. Alistamiento de Recursos y Herramientas por Área
                </div>

                <div class="checklist-grid">
                    <div>
                        <div style="font-weight:700; color:#0f766e; margin-bottom:8px; font-size:13px;">💻 Sistemas y Tecnología:</div>
                        <label class="checklist-item" style="margin-bottom:6px;">
                            <input type="checkbox" name="requiere_computador" value="si" checked onchange="document.getElementById('caja-tipo-pc').style.display = this.checked ? 'block' : 'none';">
                            <span>Requiere Computador de Trabajo</span>
                        </label>
                        <div id="caja-tipo-pc" style="margin-left:26px; margin-bottom:8px;">
                            <select name="tipo_computador" class="form-control" style="font-size:12.5px; padding:6px 10px;">
                                <option value="Portátil Corporativo">Portátil Corporativo</option>
                                <option value="Equipo de Escritorio">Equipo de Escritorio</option>
                            </select>
                        </div>
                        <label class="checklist-item" style="margin-bottom:6px;">
                            <input type="checkbox" name="requiere_correo" value="si" checked>
                            <span>Crear Correo Corporativo (@inees.co)</span>
                        </label>
                        <label class="checklist-item">
                            <input type="checkbox" name="requiere_celular_corp" value="si">
                            <span>Requiere Celular / Línea Corporativa</span>
                        </label>
                    </div>

                    <div>
                        <div style="font-weight:700; color:#0f766e; margin-bottom:8px; font-size:13px;">🦺 Operaciones &amp; Seguridad (SST):</div>
                        <label class="checklist-item" style="margin-bottom:6px;">
                            <input type="checkbox" name="requiere_dotacion" value="si" onchange="document.getElementById('caja-tallas-dot').style.display = this.checked ? 'block' : 'none';">
                            <span>Requiere Dotación / Uniforme y EPP</span>
                        </label>
                        <div id="caja-tallas-dot" style="margin-left:26px; display:none;">
                            <input type="text" name="tallas_dotacion" class="form-control" style="font-size:12.5px; padding:6px 10px;" placeholder="Tallas: Camisa M, Pantalón 32, Calzado 40">
                        </div>
                    </div>

                    <div>
                        <div style="font-weight:700; color:#0f766e; margin-bottom:8px; font-size:13px;">📝 Gestión Humana &amp; Nómina:</div>
                        <div style="font-size:12.5px; color:var(--text-muted); line-height:1.5;">
                            ✓ Afiliaciones obligatorias (ARL, EPS, Caja, Pensión).<br>
                            ✓ Elaboración de contrato y firma digital/física.<br>
                            ✓ Envío automático de correo de bienvenida.
                        </div>
                    </div>
                </div>

                <!-- 4. Notificaciones Automáticas -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    4. Áreas a Notificar Automáticamente
                </div>

                <div class="form-group col-12">
                    <div style="display:flex; gap:20px; flex-wrap:wrap; background:#f8fafc; padding:12px 18px; border-radius:var(--radius-sm); border:1px solid var(--border-light);">
                        <label class="checklist-item">
                            <input type="checkbox" name="areas_notificar[]" value="gestion_humana" checked>
                            <span>Gestión Humana (Camila / Talento Humano)</span>
                        </label>
                        <label class="checklist-item">
                            <input type="checkbox" name="areas_notificar[]" value="sistemas_ti" checked>
                            <span>Sistemas y TI (Equipos y Cuentas)</span>
                        </label>
                        <label class="checklist-item">
                            <input type="checkbox" name="areas_notificar[]" value="contabilidad" checked>
                            <span>Contabilidad y Nómina</span>
                        </label>
                        <label class="checklist-item">
                            <input type="checkbox" name="areas_notificar[]" value="operaciones" checked>
                            <span>Operaciones y Logística</span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="form-label">Correos Adicionales de Notificación (Opcional, separados por coma)</label>
                    <input type="text" name="correos_adicionales" class="form-control" placeholder="ejemplo1@inees.co, jefe.area@inees.co">
                </div>

                <!-- Notice Banner -->
                <div class="notice-banner">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <div>
                        <strong>Despacho Automático:</strong> Al enviar esta solicitud, el sistema enviará en tiempo real el <strong>correo de bienvenida personalizado</strong> al candidato y la <strong>notificación de alistamiento</strong> a los departamentos seleccionados.
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="form-label">Observaciones e Instrucciones Especiales</label>
                    <textarea name="observaciones" class="form-control" rows="2" placeholder="Notas sobre el proceso de inducción, acuerdos especiales, etc."></textarea>
                </div>

                <div class="form-group col-12" style="display:flex; justify-content:flex-end; gap:12px; margin-top:10px;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        Finalizar Solicitud y Enviar Correos
                    </button>
                </div>

            </div>
        </form>
    </div>

    <?php if ($puedeGestionarIngresos): ?>
    <!-- ═════════════════════════════════════════════════════════════════
         TAB 2: HISTORIAL DE SOLICITUDES DE INGRESO (Solo GH y Admin)
         ═════════════════════════════════════════════════════════════════ -->
    <div class="tab-pane <?= ($solicitudDetalle) ? 'active' : '' ?>" id="pane-historial">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    <span>Registro de Solicitudes de Ingreso</span>
                </div>
                <button type="button" class="btn btn-primary btn-sm" onclick="cambiarTabIngreso('formulario')">
                    + Nueva Solicitud
                </button>
            </div>

            <?php if (empty($listaSolicitudes)): ?>
                <div style="text-align:center; padding: 48px 20px; color: var(--text-muted);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px; color:#94a3b8;"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    <p style="font-size:16px; font-weight:700; color:var(--text-main);">No hay solicitudes de ingreso registradas</p>
                    <p style="font-size:13px; margin-top:4px;">Haz clic en "Nueva Solicitud de Ingreso" para vincular un colaborador.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th># ID</th>
                                <th>Candidato / Colaborador</th>
                                <th>Cargo</th>
                                <th>Área</th>
                                <th>Fecha de Ingreso</th>
                                <th>Tipo Contrato</th>
                                <th>Correo Bienvenida</th>
                                <th>Estado</th>
                                <th style="text-align:right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaSolicitudes as $sol): 
                                $badgeClass = match($sol['estado']) {
                                    'contratado' => 'badge-contratado',
                                    'en_proceso' => 'badge-en_proceso',
                                    'cancelado'  => 'badge-cancelado',
                                    default      => 'badge-pendiente'
                                };
                            ?>
                                <tr>
                                    <td><strong>#<?= $sol['id'] ?></strong></td>
                                    <td>
                                        <div style="font-weight:700; color:var(--text-main);"><?= htmlspecialchars($sol['nombre_candidato']) ?></div>
                                        <div style="font-size:11px; color:var(--text-muted);">
                                            <?= htmlspecialchars($sol['tipo_documento']) ?> <?= htmlspecialchars($sol['cedula']) ?> &bull; <?= htmlspecialchars($sol['email_candidato']) ?>
                                        </div>
                                    </td>
                                    <td><span style="font-weight:600;"><?= htmlspecialchars($sol['cargo']) ?></span></td>
                                    <td><span style="background:#f1f5f9; padding:2px 8px; border-radius:10px; font-size:11.5px;"><?= htmlspecialchars($sol['area']) ?></span></td>
                                    <td>
                                        <strong style="color:#0f766e;"><?= date('d/m/Y', strtotime($sol['fecha_ingreso'])) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($sol['tipo_contrato']) ?></td>
                                    <td>
                                        <span style="display:inline-flex; align-items:center; gap:4px; color:#16a34a; font-size:12px; font-weight:600;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Despachado
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $sol['estado'])) ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <button type="button" class="btn btn-secondary btn-sm" onclick='abrirModalFichaIngreso(<?= json_encode($sol) ?>)'>
                                            Ver Ficha
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</main>

<?php if ($puedeGestionarIngresos): ?>
<!-- ═════════════════════════════════════════════════════════════════
     MODAL DE FICHA DETALLADA DE LA SOLICITUD DE INGRESO
     ═════════════════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="modal-ficha-ingreso">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="modal-ficha-titulo">Ficha de Solicitud de Ingreso</div>
            <button type="button" class="modal-close" onclick="cerrarModalFichaIngreso()">&times;</button>
        </div>

        <div id="modal-ficha-contenido" style="font-size:13.5px; line-height:1.6;">
            <!-- Contenido inyectado dinámicamente -->
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:24px; padding-top:16px; border-top:1px solid var(--border-light);">
            <form method="POST" action="ingresoControlador.php" style="display:flex; align-items:center; gap:8px;">
                <input type="hidden" name="accion" value="actualizar_estado">
                <input type="hidden" name="solicitud_id" id="modal-ficha-sol-id" value="">
                <select name="nuevo_estado" class="form-control" style="font-size:12.5px; padding:6px 10px;" id="modal-ficha-estado-select">
                    <option value="en_proceso">En Proceso</option>
                    <option value="contratado">Contratado Oficialmente</option>
                    <option value="cancelado">Cancelado</option>
                </select>
                <button type="submit" class="btn btn-secondary btn-sm">Cambiar Estado</button>
            </form>

            <button type="button" class="btn btn-primary btn-sm" onclick="cerrarModalFichaIngreso()">Cerrar</button>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function cambiarTabIngreso(tab) {
    const tabs = ['formulario', 'historial'];
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

function abrirModalFichaIngreso(sol) {
    document.getElementById('modal-ficha-titulo').textContent = `Solicitud de Ingreso #${sol.id} - ${sol.nombre_candidato}`;
    document.getElementById('modal-ficha-sol-id').value = sol.id;
    document.getElementById('modal-ficha-estado-select').value = sol.estado || 'en_proceso';

    const c = document.getElementById('modal-ficha-contenido');
    c.innerHTML = `
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:16px;">
            <div style="font-weight:700; color:#0f223d; font-size:16px;">${sol.nombre_candidato}</div>
            <div style="color:#64748b; font-size:12.5px;">${sol.tipo_documento} ${sol.cedula} &bull; Tel: ${sol.celular} &bull; ${sol.email_candidato}</div>
        </div>

        <table style="width:100%; border-collapse:collapse; margin-bottom:16px;">
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600; width:40%;">Cargo:</td><td style="padding:6px; color:#0f766e; font-weight:700;">${sol.cargo}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Área / Departamento:</td><td style="padding:6px;">${sol.area}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Fecha de Ingreso:</td><td style="padding:6px; font-weight:700;">${sol.fecha_ingreso}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Tipo de Contrato:</td><td style="padding:6px;">${sol.tipo_contrato}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Salario:</td><td style="padding:6px;">${sol.salario || 'No especificado'}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Horario:</td><td style="padding:6px;">${sol.horario_trabajo}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Jefe Inmediato:</td><td style="padding:6px;">${sol.jefe_inmediato || 'No especificado'}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Requiere Computador:</td><td style="padding:6px;">${sol.requiere_computador === 'si' ? 'Sí (' + (sol.tipo_computador || 'Portátil') + ')' : 'No'}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Requiere Correo Corporativo:</td><td style="padding:6px;">${sol.requiere_correo === 'si' ? 'Sí (@inees.co)' : 'No'}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Dotación / EPP:</td><td style="padding:6px;">${sol.requiere_dotacion === 'si' ? 'Sí (' + (sol.tallas_dotacion || 'Tallas registradas') + ')' : 'No'}</td></tr>
            <tr style="border-bottom:1px solid #e2e8f0;"><td style="padding:6px; font-weight:600;">Áreas Notificadas:</td><td style="padding:6px; color:#0f766e;">${sol.areas_notificadas || 'Gestión Humana, TI, Contabilidad, Operaciones'}</td></tr>
            <tr><td style="padding:6px; font-weight:600;">Solicitado Por:</td><td style="padding:6px;">${sol.nombre_solicitante} (${sol.creado_en})</td></tr>
        </table>

        ${sol.observaciones ? `<div style="background:#f1f5f9; padding:10px 14px; border-radius:6px; font-size:12.5px;"><strong>Observaciones:</strong> ${sol.observaciones}</div>` : ''}
    `;

    document.getElementById('modal-ficha-ingreso').classList.add('active');
}

function cerrarModalFichaIngreso() {
    document.getElementById('modal-ficha-ingreso').classList.remove('active');
}
</script>

</body>
</html>
