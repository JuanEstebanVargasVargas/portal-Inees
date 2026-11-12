<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">`r`n    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title>Solicitud de Vacaciones — Portal INEES</title>
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
        main { max-width: 1200px; width: 100%; margin: 0 auto; padding: 32px 20px 60px; flex: 1; }

        /* ── Breadcrumb ── */
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }
        .breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb-sep { color: var(--border); }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #083344 100%);
            border-radius: var(--radius-lg);
            padding: 32px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-lg);
            flex-wrap: wrap;
        }
        .hero-left { display: flex; align-items: center; gap: 20px; }
        .hero-icon {
            width: 56px; height: 56px;
            background: rgba(13,148,136,.2);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(13,148,136,.35);
        }
        .hero-icon svg { width: 26px; height: 26px; stroke: #2dd4bf; }
        .hero-title { font-size: 22px; font-weight: 700; color: #fff; }
        .hero-sub { font-size: 13px; color: rgba(255,255,255,.65); margin-top: 4px; }
        .hero-badge {
            display: inline-block;
            margin-top: 8px;
            background: rgba(13,148,136,.25);
            color: #2dd4bf;
            border: 1px solid rgba(13,148,136,.4);
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .5px;
        }

        /* ── Tabs ── */
        .tabs-nav {
            display: flex;
            gap: 4px;
            border-bottom: 2px solid var(--border);
            margin-bottom: 28px;
            flex-wrap: wrap;
        }
        .tab-btn {
            padding: 10px 18px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: color .2s, border-color .2s;
        }
        .tab-btn:hover { color: var(--primary); }
        .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); font-weight: 600; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* ── Aviso Informativo del Proceso ── */
        .aviso-proceso-empleado {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-left: 4px solid var(--primary);
            border-radius: var(--radius-sm);
            padding: 16px 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .aviso-proceso-icon {
            color: var(--primary);
            flex-shrink: 0;
            margin-top: 2px;
        }
        .aviso-proceso-body {
            flex: 1;
        }
        .aviso-proceso-titulo {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }
        .aviso-proceso-texto {
            font-size: 13px;
            color: #334155;
            line-height: 1.5;
        }

        /* ── Card ── */
        .card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 28px 32px;
            margin-bottom: 24px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-title svg { stroke: var(--primary); flex-shrink: 0; }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin: 24px 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-light);
        }

        /* ── Form Grid ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.span-2 { grid-column: span 2; }
        .form-group.span-full { grid-column: 1 / -1; }
        label { font-size: 13px; font-weight: 600; color: var(--text-main); }
        label .req { color: #ef4444; margin-left: 2px; }
        input[type="text"], input[type="date"], input[type="number"], select, textarea {
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            color: var(--text-main);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,.12);
        }
        input[readonly] { background: #f8fafb; color: var(--text-muted); cursor: default; }
        textarea { min-height: 90px; resize: vertical; }
        .form-hint { font-size: 12px; color: var(--text-muted); }

        /* ── File Upload ── */
        .file-upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 32px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            position: relative;
        }
        .file-upload-area:hover, .file-upload-area.drag-over {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        .file-upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .file-upload-icon { margin-bottom: 10px; }
        .file-upload-icon svg { width: 36px; height: 36px; stroke: var(--primary); }
        .file-upload-text { font-size: 15px; font-weight: 600; color: var(--text-main); }
        .file-upload-sub { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
        .file-preview {
            display: flex; align-items: center; gap: 12px;
            background: var(--primary-light);
            border: 1px solid rgba(13,148,136,.25);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 500;
            color: var(--primary);
        }
        .file-preview svg { width: 18px; height: 18px; stroke: var(--primary); flex-shrink: 0; }

        /* ── Days Counter ── */
        .days-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            border: 1px solid rgba(13,148,136,.3);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all .2s;
            text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,.3); }
        .btn-outline { background: transparent; color: var(--text-main); border: 1.5px solid var(--border); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
        .btn-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .btn-danger:hover { background: #fecaca; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-approve { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .btn-approve:hover { background: #a7f3d0; }
        .btn-reject { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .btn-reject:hover { background: #fecaca; }

        /* ── Alert ── */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* ── Stats ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
        }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
        }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat-icon.pending { background: #fef3c7; }
        .stat-icon.pending svg { stroke: #d97706; }
        .stat-icon.approved { background: #d1fae5; }
        .stat-icon.approved svg { stroke: #059669; }
        .stat-icon.rejected { background: #fee2e2; }
        .stat-icon.rejected svg { stroke: #dc2626; }
        .stat-num { font-size: 26px; font-weight: 800; color: var(--text-main); line-height: 1; }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-top: 3px; }

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .filter-bar input, .filter-bar select {
            flex: 1;
            min-width: 160px;
            max-width: 260px;
        }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        thead th {
            background: #f1f5f9;
            padding: 11px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }
        tbody tr { border-bottom: 1px solid var(--border-light); transition: background .15s; }
        tbody tr:hover { background: #f8fafb; }
        tbody td { padding: 12px 14px; vertical-align: middle; color: var(--text-main); }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .4px;
        }
        .badge-pendiente  { background: #fef3c7; color: #92400e; }
        .badge-aprobada   { background: #d1fae5; color: #065f46; }
        .badge-rechazada  { background: #fee2e2; color: #991b1b; }

        /* ── Empty State ── */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
        .empty-state svg { width: 48px; height: 48px; stroke: var(--border); margin-bottom: 12px; }
        .empty-state h3 { font-size: 16px; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p { font-size: 13px; }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }
        .modal {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: 32px;
            width: 100%;
            max-width: 540px;
            transform: translateY(10px);
            transition: transform .2s;
        }
        .modal-overlay.open .modal { transform: translateY(0); }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .modal-title { font-size: 17px; font-weight: 700; color: var(--text-main); }
        .modal-close { background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; border-radius: 6px; transition: background .15s; }
        .modal-close:hover { background: var(--border-light); }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-grid.cols-3 { grid-template-columns: 1fr; }
            .form-group.span-2 { grid-column: span 1; }
            .hero { flex-direction: column; align-items: flex-start; gap: 16px; }
            .stats-row { grid-template-columns: 1fr; }
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
        <a href="<?= $urlBase ?>index.php">Inicio</a>
        <span class="breadcrumb-sep">›</span>
        <span>Talento Humano</span>
        <span class="breadcrumb-sep">›</span>
        <span>Solicitud de Vacaciones</span>
    </nav>

    <!-- Hero Banner -->
    <div class="hero">
        <div class="hero-left">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M21 15v4"/><path d="M19 17h4"/>
                </svg>
            </div>
            <div>
                <div class="hero-title">Solicitud de Vacaciones</div>
                <div class="hero-sub">Gestión de Talento Humano</div>
                <div class="hero-badge">GTH · Vacaciones</div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    <?php if (!empty($mensajeExito)): ?>
        <div class="alert alert-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <?= htmlspecialchars($mensajeExito) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($mensajeError)): ?>
        <div class="alert alert-error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            <?= htmlspecialchars($mensajeError) ?>
        </div>
    <?php endif; ?>

    <!-- Estadísticas (solo Gestión Humana / SuperUsuario) -->
    <?php if ($puedeGestionar && $estadisticas): ?>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon pending">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="stat-num"><?= $estadisticas['pendiente'] ?></div>
                <div class="stat-label">Pendientes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon approved">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="stat-num"><?= $estadisticas['aprobada'] ?></div>
                <div class="stat-label">Aprobadas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon rejected">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <div class="stat-num"><?= $estadisticas['rechazada'] ?></div>
                <div class="stat-label">Rechazadas</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="tabs-nav">
        <button class="tab-btn active" data-tab="solicitar" onclick="switchTab('solicitar',this)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            <?= $puedeGestionar ? 'Nueva Solicitud' : 'Solicitar Vacaciones' ?>
        </button>
        <button class="tab-btn" data-tab="historial" onclick="switchTab('historial',this)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <?= $puedeGestionar ? 'Gestionar Solicitudes' : 'Mis Solicitudes' ?>
            <?php if (!empty($solicitudes)): ?>
                <span style="background:var(--primary);color:#fff;border-radius:20px;padding:1px 7px;font-size:11px;">
                    <?= count($solicitudes) ?>
                </span>
            <?php endif; ?>
        </button>
    </div>

    <!-- ───────── TAB: SOLICITAR ───────── -->
    <div id="tab-solicitar" class="tab-pane active">
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
                <div class="aviso-proceso-titulo">Información sobre el trámite de solicitud de vacaciones</div>
                <div class="aviso-proceso-texto">
                    Diligencia las fechas de tu período vacacional. Tu solicitud será revisada y validada por la jefatura inmediata y el área de Gestión Humana. Se te notificará oportunamente a tu <strong>correo electrónico registrado</strong> y en la pestaña de <strong>"Mis Solicitudes"</strong> si tu período vacacional fue <strong>Aprobado</strong> o <strong>Denegado</strong>.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M21 15v4"/><path d="M19 17h4"/></svg>
                Información del Empleado y de la Solicitud
                <span style="margin-left:auto;background:#fef3c7;color:#92400e;border:1px solid #fde68a;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">GTH · Vacaciones</span>
            </div>

            <form method="POST" enctype="multipart/form-data" action="vacacionesControlador.php" id="formVacaciones">
                <input type="hidden" name="accion" value="solicitar_vacaciones">

                <!-- 1. Info Empleado -->
                <div class="section-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    1. Información del Empleado
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Documento de Identidad (Cédula)</label>
                        <input type="text" value="<?= htmlspecialchars($perfil['cedula'] ?? '') ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Cargo</label>
                        <input type="text" value="<?= htmlspecialchars($perfil['cargo'] ?? '') ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Departamento / Área</label>
                        <input type="text" value="<?= htmlspecialchars($perfil['area'] ?? '') ?>" readonly>
                    </div>
                </div>

                <!-- 2. Periodo de Vacaciones -->
                <div class="section-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    2. Período de Vacaciones
                </div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label>Fecha de Inicio <span class="req">*</span></label>
                        <input type="date" name="fecha_inicio" id="fechaInicio" required onchange="calcularDias()">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Fin <span class="req">*</span></label>
                        <input type="date" name="fecha_fin" id="fechaFin" required onchange="calcularDias()">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Reincorporación</label>
                        <input type="date" name="fecha_reincorporacion" id="fechaReincorp">
                    </div>
                </div>

                <!-- Contador de días -->
                <div style="margin: 10px 0 20px; display:flex; align-items:center; gap:12px;">
                    <div class="days-pill" id="diasPill">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span id="diasContador">— días solicitados</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Período Causado</label>
                        <input type="text" name="periodo_causado" placeholder="Ej: 2024-2025">
                        <span class="form-hint">Período de trabajo al que corresponden las vacaciones.</span>
                    </div>
                    <div class="form-group">
                        <label>Observaciones del Empleado</label>
                        <input type="text" name="observaciones" placeholder="Alguna aclaración opcional">
                    </div>
                </div>

                <!-- 3. Carta -->
                <div class="section-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    3. Carta de Solicitud de Vacaciones
                </div>
                <div class="form-group span-full">
                    <label>Adjuntar Carta <span class="req">*</span></label>
                    <div class="file-upload-area" id="uploadArea">
                        <input type="file" name="archivo_carta" id="archivoCarta" accept=".pdf,.jpg,.jpeg,.png" required onchange="previewFile(this)">
                        <div id="uploadContent">
                            <div class="file-upload-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div class="file-upload-text">Haz clic o arrastra la carta aquí</div>
                            <div class="file-upload-sub">PDF, JPG o PNG · Máximo 10 MB</div>
                        </div>
                    </div>
                    <div id="filePreview" style="display:none;margin-top:8px;"></div>
                    <span class="form-hint">Adjunta la carta de solicitud de vacaciones firmada.</span>
                </div>

                <!-- Acciones -->
                <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:28px; padding-top:20px; border-top:1px solid var(--border);">
                    <button type="reset" class="btn btn-outline" onclick="resetForm()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3"/></svg>
                        Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ───────── TAB: HISTORIAL ───────── -->
    <div id="tab-historial" class="tab-pane">
        <?php if ($puedeGestionar): ?>
        <!-- Filtros para Gestión Humana -->
        <form method="GET" action="vacacionesControlador.php" id="formFiltros">
            <input type="hidden" name="tab" value="historial">
            <div class="filter-bar">
                <input type="text" name="q" value="<?= htmlspecialchars($filtroBusqueda) ?>" placeholder="🔍 Buscar empleado, área, cédula…" oninput="this.form.submit()">
                <select name="estado" onchange="this.form.submit()">
                    <option value="todos" <?= $filtroEstado === 'todos' ? 'selected' : '' ?>>Todos los estados</option>
                    <option value="pendiente" <?= $filtroEstado === 'pendiente' ? 'selected' : '' ?>>⏳ Pendiente</option>
                    <option value="aprobada"  <?= $filtroEstado === 'aprobada'  ? 'selected' : '' ?>>✅ Aprobada</option>
                    <option value="rechazada" <?= $filtroEstado === 'rechazada' ? 'selected' : '' ?>>❌ Rechazada</option>
                </select>
            </div>
        </form>
        <?php endif; ?>

        <div class="card" style="padding: 0; overflow:hidden;">
            <?php if (empty($solicitudes)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <h3>No hay solicitudes registradas</h3>
                    <p>Aún no se han enviado solicitudes de vacaciones<?= $puedeGestionar ? ' con los filtros aplicados' : '' ?>.</p>
                </div>
            <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php if ($puedeGestionar): ?><th>Empleado</th><?php endif; ?>
                            <th>Período</th>
                            <th>Días</th>
                            <th>Estado</th>
                            <th>Carta</th>
                            <th>Enviada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($solicitudes as $s): ?>
                        <tr>
                            <td style="font-weight:600;color:var(--text-muted);">#<?= $s['id'] ?></td>
                            <?php if ($puedeGestionar): ?>
                            <td>
                                <div style="font-weight:600;"><?= htmlspecialchars($s['nombre_empleado']) ?></div>
                                <div style="font-size:11px;color:var(--text-muted);"><?= htmlspecialchars($s['cargo']) ?> · <?= htmlspecialchars($s['area']) ?></div>
                            </td>
                            <?php endif; ?>
                            <td>
                                <div style="font-weight:600;"><?= date('d/m/Y', strtotime($s['fecha_inicio'])) ?> → <?= date('d/m/Y', strtotime($s['fecha_fin'])) ?></div>
                                <?php if ($s['periodo_causado']): ?>
                                    <div style="font-size:11px;color:var(--text-muted);">Período: <?= htmlspecialchars($s['periodo_causado']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="font-weight:700;font-size:16px;color:var(--primary);"><?= $s['dias_solicitados'] ?></span>
                                <span style="font-size:11px;color:var(--text-muted);">días</span>
                            </td>
                            <td>
                                <span class="badge badge-<?= $s['estado'] ?>">
                                    <?= $s['estado'] === 'pendiente' ? '⏳ Pendiente' : ($s['estado'] === 'aprobada' ? '✅ Aprobada' : '❌ Rechazada') ?>
                                </span>
                                <?php if ($s['observaciones_rh']): ?>
                                    <div style="font-size:11px;color:var(--text-muted);margin-top:3px;" title="<?= htmlspecialchars($s['observaciones_rh']) ?>">
                                        💬 <?= htmlspecialchars(mb_strimwidth($s['observaciones_rh'], 0, 30, '…')) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($s['archivo_carta'])): ?>
                                    <a href="<?= $urlBase . htmlspecialchars($s['archivo_carta']) ?>" target="_blank" class="btn btn-outline btn-sm">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        Ver
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:12px;color:var(--text-muted);">
                                <?= date('d/m/Y', strtotime($s['creado_en'])) ?>
                            </td>
                            <td>
                                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                    <?php if ($puedeGestionar): ?>
                                        <button class="btn btn-approve btn-sm"
                                            onclick="abrirModalGestion(<?= $s['id'] ?>, '<?= htmlspecialchars(addslashes($s['nombre_empleado'])) ?>', '<?= $s['estado'] ?>')">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            Gestionar
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($s['estado'] === 'pendiente' || $puedeGestionar): ?>
                                        <form method="POST" style="margin:0;" onsubmit="return confirm('¿Eliminar esta solicitud?')">
                                            <input type="hidden" name="accion" value="eliminar_vacacion">
                                            <input type="hidden" name="solicitud_id" value="<?= $s['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
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
    </div><!-- /tab-historial -->
</main>

<!-- Modal de Gestión (Aprobar / Rechazar) -->
<div class="modal-overlay" id="modalGestion">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Gestionar Solicitud</div>
            <button class="modal-close" onclick="cerrarModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="vacacionesControlador.php">
            <input type="hidden" name="accion" value="gestionar_vacacion">
            <input type="hidden" name="solicitud_id" id="modalSolicitudId">
            <div class="form-group" style="margin-bottom:16px;">
                <label>Empleado</label>
                <input type="text" id="modalNombreEmpleado" readonly>
            </div>
            <div class="form-group" style="margin-bottom:16px;">
                <label>Decisión <span class="req">*</span></label>
                <select name="estado" id="modalEstado" required>
                    <option value="aprobada">✅ Aprobar Solicitud</option>
                    <option value="rechazada">❌ Rechazar Solicitud</option>
                    <option value="pendiente">⏳ Mantener Pendiente</option>
                </select>
            </div>
            <div class="form-group">
                <label>Observaciones de Talento Humano</label>
                <textarea name="observaciones_rh" placeholder="Comentarios, motivo de rechazo, instrucciones…" rows="3"></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Decisión</button>
            </div>
        </form>
    </div>
</div>

<script>
// ── Tabs ──────────────────────────────────────────────
function switchTab(name, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

// Auto-abrir historial si viene de redirect con tab=historial
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('tab') === 'historial' || urlParams.get('exito') || urlParams.get('actualizado') || urlParams.get('eliminado')) {
    const histBtn = document.querySelector('[data-tab="historial"]');
    if (histBtn) switchTab('historial', histBtn);
}

// ── Calculadora de días ───────────────────────────────
function calcularDias() {
    const ini = document.getElementById('fechaInicio').value;
    const fin  = document.getElementById('fechaFin').value;
    const pill = document.getElementById('diasContador');
    if (ini && fin) {
        const tIni = new Date(ini);
        const tFin = new Date(fin);
        if (tFin >= tIni) {
            const dias = Math.round((tFin - tIni) / 86400000) + 1;
            pill.textContent = dias + ' día' + (dias !== 1 ? 's' : '') + ' solicitado' + (dias !== 1 ? 's' : '');

            // Auto-calcular reincorporación (día siguiente al fin)
            const reincorp = new Date(tFin);
            reincorp.setDate(reincorp.getDate() + 1);
            document.getElementById('fechaReincorp').value = reincorp.toISOString().slice(0, 10);
        } else {
            pill.textContent = '⚠ Fechas inválidas';
        }
    } else {
        pill.textContent = '— días solicitados';
    }
}

// ── File Preview ──────────────────────────────────────
function previewFile(input) {
    const preview = document.getElementById('filePreview');
    const content = document.getElementById('uploadContent');
    if (input.files && input.files[0]) {
        const f = input.files[0];
        const icon = f.type === 'application/pdf'
            ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>'
            : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>';
        preview.innerHTML = '<div class="file-preview">' + icon + f.name + ' (' + (f.size / 1024).toFixed(1) + ' KB)</div>';
        preview.style.display = 'block';
        content.style.opacity = '.5';
    }
}

function resetForm() {
    document.getElementById('filePreview').style.display = 'none';
    document.getElementById('uploadContent').style.opacity = '1';
    document.getElementById('diasContador').textContent = '— días solicitados';
}

// Drag and drop visual
const area = document.getElementById('uploadArea');
if (area) {
    area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('drag-over'); });
    area.addEventListener('dragleave', () => area.classList.remove('drag-over'));
    area.addEventListener('drop', e => { e.preventDefault(); area.classList.remove('drag-over'); });
}

// ── Modal Gestión ─────────────────────────────────────
function abrirModalGestion(id, nombre, estadoActual) {
    document.getElementById('modalSolicitudId').value = id;
    document.getElementById('modalNombreEmpleado').value = nombre;
    const sel = document.getElementById('modalEstado');
    sel.value = estadoActual === 'pendiente' ? 'aprobada' : estadoActual;
    document.getElementById('modalGestion').classList.add('open');
}
function cerrarModal() {
    document.getElementById('modalGestion').classList.remove('open');
}
document.getElementById('modalGestion').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>
</body>
</html>
