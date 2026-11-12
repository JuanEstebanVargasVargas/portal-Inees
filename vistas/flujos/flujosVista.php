<?php
// vistas/flujos/flujosVista.php
// Flujos de Procesos - Clasificación por divisiones:
// RECURSOS HUMANOS, GERENCIA, TECNICOS, ADMINISTRATIVO, EMPLEADO

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(/[^/]+)#', $scriptName, $matches) && strpos($matches[1], '.php') === false) {
    $urlBase = rtrim($matches[1], '/') . '/';
} else {
    $urlBase = '/';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">`r`n    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">img/logo.png">
    <title>Flujos de Procesos — Portal INEES</title>
    <style>
        :root {
            --primary:       #0d9488;
            --primary-dark:  #0f766e;
            --primary-light: #f0fdfa;
            --primary-glow:  rgba(13, 148, 136, 0.2);
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
            --shadow-lg:     0 12px 28px -4px rgba(15,34,61,.13);

            /* Colores específicos por división */
            --rh-color:      #059669;
            --rh-bg:         #ecfdf5;
            --rh-border:     #a7f3d0;

            --ger-color:     #7c3aed;
            --ger-bg:        #f5f3ff;
            --ger-border:    #ddd6fe;

            --tec-color:     #0284c7;
            --tec-bg:        #f0f9ff;
            --tec-border:    #bae6fd;

            --adm-color:     #d97706;
            --adm-bg:        #fffbeb;
            --adm-border:    #fde68a;

            --emp-color:     #2563eb;
            --emp-bg:        #eff6ff;
            --emp-border:    #bfdbfe;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 20px 60px;
            flex: 1;
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb-sep {
            color: #94a3b8;
        }

        /* ── Hero Banner ── */
        .hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 55%, #1e1b4b 100%);
            border-radius: var(--radius-lg);
            padding: 30px 34px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-lg);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            border-left: 5px solid #6366f1;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-left {
            position: relative;
            z-index: 2;
            max-width: 760px;
        }

        .hero-title-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .hero-icon-box {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #a5b4fc;
        }

        .hero-title {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .hero-sub {
            color: #cbd5e1;
            font-size: 14.5px;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .hero-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .hero-badge-admin {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(110, 231, 183, 0.4);
        }

        .hero-badge-read {
            background: rgba(99, 102, 241, 0.2);
            color: #c7d2fe;
            border: 1px solid rgba(199, 210, 254, 0.4);
        }

        .hero-actions {
            position: relative;
            z-index: 2;
        }

        .btn-upload-trigger {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            border: none;
            padding: 12px 22px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
            transition: all 0.2s ease;
        }
        .btn-upload-trigger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
            background: linear-gradient(135deg, #4f46e5, #4338ca);
        }

        /* ── Alertas ── */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Tarjetas de Divisiones Autorizadas ── */
        .division-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .division-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 18px 20px;
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .division-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .division-card.active {
            border-width: 2px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        /* Estilos por división */
        .div-rh  { border-top: 4px solid var(--rh-color); }
        .div-rh.active { border-color: var(--rh-color); background: var(--rh-bg); }
        .div-rh .div-icon-box { background: var(--rh-bg); color: var(--rh-color); border: 1px solid var(--rh-border); }

        .div-ger { border-top: 4px solid var(--ger-color); }
        .div-ger.active { border-color: var(--ger-color); background: var(--ger-bg); }
        .div-ger .div-icon-box { background: var(--ger-bg); color: var(--ger-color); border: 1px solid var(--ger-border); }

        .div-tec { border-top: 4px solid var(--tec-color); }
        .div-tec.active { border-color: var(--tec-color); background: var(--tec-bg); }
        .div-tec .div-icon-box { background: var(--tec-bg); color: var(--tec-color); border: 1px solid var(--tec-border); }

        .div-adm { border-top: 4px solid var(--adm-color); }
        .div-adm.active { border-color: var(--adm-color); background: var(--adm-bg); }
        .div-adm .div-icon-box { background: var(--adm-bg); color: var(--adm-color); border: 1px solid var(--adm-border); }

        .div-emp { border-top: 4px solid var(--emp-color); }
        .div-emp.active { border-color: var(--emp-color); background: var(--emp-bg); }
        .div-emp .div-icon-box { background: var(--emp-bg); color: var(--emp-color); border: 1px solid var(--emp-border); }

        .div-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .div-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .div-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .div-sub {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .div-count-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
        }

        /* ── Contenedor Principal de Flujos ── */
        .flujos-main-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .flujos-toolbar {
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
        }

        .flujos-heading-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .flujos-heading-text h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
        }

        .flujos-heading-text p {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .btn-ver-todos {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            background: var(--primary-light);
            transition: all 0.2s;
        }
        .btn-ver-todos:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .search-box-container {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 280px;
            flex: 1;
            max-width: 420px;
        }

        .search-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%2394a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>') no-repeat 12px center;
        }

        .search-input:focus {
            background-color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* ── Grilla de Flujos ── */
        .flujos-container {
            padding: 24px;
            background: #ffffff;
        }

        .flujos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 18px;
        }

        .flujo-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            position: relative;
        }

        .flujo-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .flujo-card-top {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .flujo-ext-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        /* Badges de división */
        .area-pill {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        .pill-rh  { background: var(--rh-bg); color: var(--rh-color); border: 1px solid var(--rh-border); }
        .pill-ger { background: var(--ger-bg); color: var(--ger-color); border: 1px solid var(--ger-border); }
        .pill-tec { background: var(--tec-bg); color: var(--tec-color); border: 1px solid var(--tec-border); }
        .pill-adm { background: var(--adm-bg); color: var(--adm-color); border: 1px solid var(--adm-border); }
        .pill-emp { background: var(--emp-bg); color: var(--emp-color); border: 1px solid var(--emp-border); }

        .flujo-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.3;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .flujo-orig-name {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .flujo-desc {
            font-size: 12.5px;
            color: #475569;
            background: #f8fafc;
            padding: 8px 10px;
            border-radius: 6px;
            border-left: 3px solid #6366f1;
            margin: 10px 0 14px;
            line-height: 1.4;
            word-break: break-word;
        }

        .flujo-meta {
            border-top: 1px dashed var(--border-light);
            padding-top: 10px;
            font-size: 11.5px;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 12px;
        }

        .flujo-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flujo-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-download-flujo {
            flex: 1;
            background: #f5f3ff;
            color: #5b21b6;
            border: 1px solid #ddd6fe;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-download-flujo:hover {
            background: #6366f1;
            color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.35);
        }

        .btn-delete-flujo {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
            padding: 8px 10px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-delete-flujo:hover {
            background: #fee2e2;
            color: #b91c1c;
            border-color: #fca5a5;
        }

        /* ── Modal Cargar Flujo (Solo Sistema de Gestión) ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(3px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: modalFadeIn 0.25s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(12px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            padding: 20px 24px;
            background: #0b1728;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #6366f1;
        }

        .modal-title {
            font-size: 17px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #cbd5e1;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-close:hover {
            background: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .modal-body {
            padding: 24px;
            max-height: 78vh;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-label span.req {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s;
            background: #ffffff;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Selector de División con 5 opciones */
        .division-selector-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 10px;
            margin-top: 6px;
        }

        .division-option-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            border: 2px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
            background: #ffffff;
            user-select: none;
            font-size: 12.5px;
        }

        .division-option-label input[type="radio"] {
            margin: 0;
            accent-color: #6366f1;
        }

        .division-option-label:hover {
            border-color: #a5b4fc;
            background: #f8fafc;
        }

        .division-option-label.selected {
            border-color: #6366f1;
            background: #f5f3ff;
            font-weight: 700;
        }

        .file-dropzone {
            border: 2px dashed #94a3b8;
            border-radius: var(--radius-md);
            padding: 24px 16px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-dropzone:hover, .file-dropzone.dragover {
            border-color: #6366f1;
            background: #f5f3ff;
        }

        .file-dropzone-icon {
            font-size: 32px;
            margin-bottom: 8px;
            color: #6366f1;
        }

        .file-dropzone-text {
            font-size: 13px;
            color: var(--text-main);
            font-weight: 600;
        }

        .file-dropzone-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .modal-footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1px solid var(--border-light);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: var(--text-main);
            border: none;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .btn-primary-flujo {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary-flujo:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
        }

        /* ── Estado Vacío ── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            background: #f8fafc;
            border-radius: var(--radius-md);
            border: 2px dashed #cbd5e1;
            margin: 10px 0;
        }
        .empty-icon {
            font-size: 48px;
            margin-bottom: 12px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .hero { padding: 24px 20px; }
            .hero-title { font-size: 22px; }
            .division-selector-grid { grid-template-columns: 1fr; }
            .flujos-toolbar { flex-direction: column; align-items: stretch; }
            .search-box-container { max-width: 100%; }
            .flujos-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Header / Barra de Navegación Superior -->
    <?php require_once __DIR__ . '/../partials/navbar/navbar.php'; ?>

    <!-- Menú Lateral Off-Canvas -->
    <?php require_once __DIR__ . '/../partials/sidebar/sidebar.php'; ?>

    <main>
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Ruta de navegación">
            <a href="<?= $urlBase ?>index.php">Inicio</a>
            <span class="breadcrumb-sep">/</span>
            <span>Flujos de Procesos</span>
        </nav>

        <!-- Mensajes de Notificación -->
        <?php if (!empty($mensajeExito)): ?>
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span><?= htmlspecialchars($mensajeExito) ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensajeError)): ?>
            <div class="alert alert-danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span><?= htmlspecialchars($mensajeError) ?></span>
            </div>
        <?php endif; ?>

        <!-- Hero Banner Principal -->
        <div class="hero">
            <div class="hero-left">
                <div class="hero-title-row">
                    <div class="hero-icon-box">🔀</div>
                    <h1 class="hero-title">Flujos de Procesos</h1>
                </div>
                <p class="hero-sub">
                    Diagramas, mapas de procesos y flujos operativos organizacionales asignados por área y rol funcional.
                </p>
                <div>
                    <?php if ($puedeCargar): ?>
                        <span class="hero-badge-pill hero-badge-admin">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            Rol: Sistema de Gestión — Habilitado para Cargar y Administrar Flujos
                        </span>
                    <?php else: ?>
                        <span class="hero-badge-pill hero-badge-read">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            Modo Consulta: Área(s) Autorizada(s) para tu Perfil
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($puedeCargar): ?>
                <div class="hero-actions">
                    <button class="btn-upload-trigger" onclick="abrirModalCargarFlujo()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        Cargar Flujo
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             DIVISIONES DE FLUJOS AUTORIZADAS PARA EL USUARIO
             ═══════════════════════════════════════════════════════ -->
        <div class="division-grid">
            <!-- 1. Recursos Humanos -->
            <?php if (in_array('RECURSOS HUMANOS', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?area=<?= urlencode('RECURSOS HUMANOS') ?>" 
                   class="division-card div-rh <?= ($areaFiltro === 'RECURSOS HUMANOS') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">👥</div>
                        <div>
                            <div class="div-title">Recursos Humanos</div>
                            <div class="div-sub">Flujos y procesos de talento</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['RECURSOS HUMANOS'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 2. Gerencia -->
            <?php if (in_array('GERENCIA', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?area=<?= urlencode('GERENCIA') ?>" 
                   class="division-card div-ger <?= ($areaFiltro === 'GERENCIA') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">👔</div>
                        <div>
                            <div class="div-title">Gerencia</div>
                            <div class="div-sub">Dirección y toma de decisiones</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['GERENCIA'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 3. Técnicos -->
            <?php if (in_array('TECNICOS', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?area=<?= urlencode('TECNICOS') ?>" 
                   class="division-card div-tec <?= ($areaFiltro === 'TECNICOS') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">🔧</div>
                        <div>
                            <div class="div-title">Técnicos</div>
                            <div class="div-sub">Operaciones y mantenimiento</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['TECNICOS'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 4. Administrativo -->
            <?php if (in_array('ADMINISTRATIVO', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?area=<?= urlencode('ADMINISTRATIVO') ?>" 
                   class="division-card div-adm <?= ($areaFiltro === 'ADMINISTRATIVO') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">📊</div>
                        <div>
                            <div class="div-title">Administrativo</div>
                            <div class="div-sub">Gestión, compras y control</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['ADMINISTRATIVO'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 5. Empleado -->
            <?php if (in_array('EMPLEADO', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?area=<?= urlencode('EMPLEADO') ?>" 
                   class="division-card div-emp <?= ($areaFiltro === 'EMPLEADO') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">👤</div>
                        <div>
                            <div class="div-title">Empleado</div>
                            <div class="div-sub">Flujos generales del colaborador</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['EMPLEADO'] ?? 0) ?></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             CONTENEDOR PRINCIPAL DE FLUJOS
             ═══════════════════════════════════════════════════════ -->
        <div class="flujos-main-card">
            
            <div class="flujos-toolbar">
                <div class="flujos-heading-group">
                    <div class="flujos-heading-text">
                        <h2>
                            <?= !empty($areaFiltro) ? 'División: ' . htmlspecialchars($areaFiltro) : 'Flujos Disponibles' ?>
                        </h2>
                        <p>
                            <?= count($flujos) ?> <?= count($flujos) === 1 ? 'flujo disponible' : 'flujos disponibles' ?>
                        </p>
                    </div>

                    <?php if ($esSistemaGestion && !empty($areaFiltro)): ?>
                        <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?area=TODOS" class="btn-ver-todos">
                            <span>✕</span> Ver Todas las Divisiones
                        </a>
                    <?php endif; ?>
                </div>

                <div class="search-box-container">
                    <input type="text" id="inputBuscarFlujos" class="search-input" placeholder="Buscar flujo de proceso..." onkeyup="filtrarFlujosEnVivo()">
                </div>
            </div>

            <div class="flujos-container">
                <?php if (empty($flujos)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">🔀</div>
                        <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                            No hay flujos disponibles en la división <?= htmlspecialchars($areaFiltro) ?>
                        </div>
                        <p style="font-size: 13.5px; color: #64748b; max-width: 440px; margin: 0 auto;">
                            <?php if ($puedeCargar): ?>
                                Haz clic en "Cargar Flujo" para publicar el primer diagrama o flujo en esta división.
                            <?php else: ?>
                                Tan pronto el equipo de Sistema de Gestión publique flujos para esta área aparecerán aquí.
                            <?php endif; ?>
                        </p>
                        <?php if ($puedeCargar): ?>
                            <div style="margin-top: 18px;">
                                <button class="btn-upload-trigger" onclick="abrirModalCargarFlujo(<?= !empty($areaFiltro) ? "'" . htmlspecialchars($areaFiltro) . "'" : "''" ?>)">
                                    <span>➕</span> Cargar Flujo Aquí
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="flujos-grid" id="gridFlujos">
                        <?php foreach ($flujos as $f): ?>
                            <?php
                                $ext = strtolower(pathinfo($f['nombre_original'], PATHINFO_EXTENSION));
                                $extLabel = strtoupper($ext ?: 'DOC');
                                $extClass = 'ext-file';
                                if ($ext === 'pdf') $extClass = 'ext-pdf';
                                elseif (in_array($ext, ['doc', 'docx'])) $extClass = 'ext-word';
                                elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) $extClass = 'ext-excel';
                                elseif (in_array($ext, ['ppt', 'pptx'])) $extClass = 'ext-ppt';
                                elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'svg'])) $extClass = 'ext-img';

                                $pillClass = 'pill-emp';
                                if ($f['area'] === 'RECURSOS HUMANOS') $pillClass = 'pill-rh';
                                elseif ($f['area'] === 'GERENCIA') $pillClass = 'pill-ger';
                                elseif ($f['area'] === 'TECNICOS') $pillClass = 'pill-tec';
                                elseif ($f['area'] === 'ADMINISTRATIVO') $pillClass = 'pill-adm';
                                elseif ($f['area'] === 'EMPLEADO') $pillClass = 'pill-emp';

                                $tamBytes = (int)$f['tamano'];
                                if ($tamBytes >= 1048576) {
                                    $tamanoFmt = number_format($tamBytes / 1048576, 1) . ' MB';
                                } elseif ($tamBytes >= 1024) {
                                    $tamanoFmt = number_format($tamBytes / 1024, 0) . ' KB';
                                } else {
                                    $tamanoFmt = $tamBytes . ' B';
                                }

                                $fechaFmt = date('d/m/Y h:i a', strtotime($f['fecha_subida']));
                                $searchData = strtolower($f['titulo'] . ' ' . $f['area'] . ' ' . $f['nombre_original'] . ' ' . ($f['descripcion'] ?? ''));
                            ?>
                            <div class="flujo-card" data-search="<?= htmlspecialchars($searchData, ENT_QUOTES, 'UTF-8') ?>">
                                <div>
                                    <div class="flujo-card-top">
                                        <div class="flujo-ext-icon" style="background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe;">
                                            <?= htmlspecialchars(substr($extLabel, 0, 4)) ?>
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <span class="area-pill <?= $pillClass ?>">
                                                <?= htmlspecialchars($f['area']) ?>
                                            </span>
                                            <div class="flujo-title" title="<?= htmlspecialchars($f['titulo']) ?>">
                                                <?= htmlspecialchars($f['titulo']) ?>
                                            </div>
                                            <div class="flujo-orig-name" title="<?= htmlspecialchars($f['nombre_original']) ?>">
                                                <?= htmlspecialchars($f['nombre_original']) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (!empty($f['descripcion'])): ?>
                                        <div class="flujo-desc">
                                            <?= nl2br(htmlspecialchars($f['descripcion'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <div class="flujo-meta">
                                        <div class="flujo-meta-row">
                                            <span>📅 <?= $fechaFmt ?></span>
                                            <span>💾 <?= $tamanoFmt ?></span>
                                        </div>
                                        <div style="color: #334155; font-weight: 600;">
                                            <span>👤</span> <?= htmlspecialchars($f['autor_nombre'] ?? 'Sistema de Gestión') ?>
                                        </div>
                                    </div>

                                    <div class="flujo-actions">
                                        <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php?accion=descargar&id=<?= $f['id'] ?>" 
                                           class="btn-download-flujo" 
                                           target="_blank"
                                           title="Ver o descargar este flujo">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Descargar / Ver
                                        </a>

                                        <?php if ($puedeCargar): ?>
                                            <button type="button" 
                                                    class="btn-delete-flujo" 
                                                    onclick="confirmarEliminarFlujo(<?= $f['id'] ?>, '<?= htmlspecialchars(addslashes($f['titulo'])) ?>')"
                                                    title="Eliminar este flujo">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </main>

    <!-- ═══════════════════════════════════════════════════════
         MODAL CARGAR FLUJO (SOLO SISTEMA DE GESTIÓN)
         ═══════════════════════════════════════════════════════ -->
    <?php if ($puedeCargar): ?>
        <div id="modalCargarFlujo" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <div class="modal-title">
                        <span>📤</span> Cargar Flujo de Procesos
                    </div>
                    <button type="button" class="modal-close" onclick="cerrarModalCargarFlujo()">&times;</button>
                </div>

                <form action="<?= $urlBase ?>controladores/flujos/flujosControlador.php" method="POST" enctype="multipart/form-data" id="formCargarFlujo">
                    <input type="hidden" name="accion" value="cargar_flujo">

                    <div class="modal-body">
                        <!-- Título -->
                        <div class="form-group">
                            <label class="form-label" for="tituloFlujo">
                                Título del Flujo <span class="req">*</span>
                            </label>
                            <input type="text" 
                                   id="tituloFlujo" 
                                   name="titulo" 
                                   class="form-control" 
                                   placeholder="Ej: Flujo de Contratación, Procedimiento de Mantenimiento..." 
                                   required>
                        </div>

                        <!-- 5 Divisiones Disponibles para Cargar -->
                        <div class="form-group">
                            <label class="form-label">
                                División / Rol al que pertenece el Flujo <span class="req">*</span>
                            </label>
                            <div class="division-selector-grid">
                                <label class="division-option-label" id="label_RH" onclick="seleccionarDivision('RECURSOS HUMANOS')">
                                    <input type="radio" name="area" value="RECURSOS HUMANOS" id="radio_RH" required>
                                    <span>👥 Recursos Humanos</span>
                                </label>

                                <label class="division-option-label" id="label_GER" onclick="seleccionarDivision('GERENCIA')">
                                    <input type="radio" name="area" value="GERENCIA" id="radio_GER" required>
                                    <span>👔 Gerencia</span>
                                </label>

                                <label class="division-option-label" id="label_TEC" onclick="seleccionarDivision('TECNICOS')">
                                    <input type="radio" name="area" value="TECNICOS" id="radio_TEC" required>
                                    <span>🔧 Técnicos</span>
                                </label>

                                <label class="division-option-label" id="label_ADM" onclick="seleccionarDivision('ADMINISTRATIVO')">
                                    <input type="radio" name="area" value="ADMINISTRATIVO" id="radio_ADM" required>
                                    <span>📊 Administrativo</span>
                                </label>

                                <label class="division-option-label" id="label_EMP" onclick="seleccionarDivision('EMPLEADO')">
                                    <input type="radio" name="area" value="EMPLEADO" id="radio_EMP" required>
                                    <span>👤 Empleado</span>
                                </label>
                            </div>
                        </div>

                        <!-- Descripción opcional -->
                        <div class="form-group">
                            <label class="form-label" for="descFlujo">
                                Descripción o Alcance del Flujo (Opcional)
                            </label>
                            <textarea id="descFlujo" 
                                      name="descripcion" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Indica el objetivo del flujo, participantes o versión..."></textarea>
                        </div>

                        <!-- Selector de archivo con dropzone -->
                        <div class="form-group">
                            <label class="form-label">
                                Seleccionar Archivo del Flujo <span class="req">*</span>
                            </label>
                            <div class="file-dropzone" id="dropzoneFlujo" onclick="document.getElementById('inputFileFlujo').click()">
                                <div class="file-dropzone-icon">🔀</div>
                                <div class="file-dropzone-text" id="dropzoneFlujoText">Haz clic aquí o arrastra el archivo del flujo</div>
                                <div class="file-dropzone-sub">
                                    Admite PDF, Word (.docx), Excel (.xlsx), PPT, Imágenes (PNG, JPG, SVG), ZIP (Máx. 35 MB)
                                </div>
                            </div>
                            <input type="file" 
                                   id="inputFileFlujo" 
                                   name="archivo" 
                                   style="display: none;" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.svg,.zip,.rar" 
                                   required 
                                   onchange="actualizarNombreFlujo(this)">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="cerrarModalCargarFlujo()">Cancelar</button>
                        <button type="submit" class="btn-primary-flujo">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Cargar Flujo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div id="modalEliminarFlujo" class="modal-overlay">
            <div class="modal-card" style="max-width: 460px;">
                <div class="modal-header" style="background: #991b1b; border-bottom: 2px solid #ef4444;">
                    <div class="modal-title">
                        <span>⚠️</span> Eliminar Flujo
                    </div>
                    <button type="button" class="modal-close" onclick="cerrarModalEliminarFlujo()">&times;</button>
                </div>

                <form action="<?= $urlBase ?>controladores/flujos/flujosControlador.php" method="POST">
                    <input type="hidden" name="accion" value="eliminar_flujo">
                    <input type="hidden" name="flujo_id" id="eliminarFlujoId" value="">

                    <div class="modal-body">
                        <div style="background: #fef2f2; border: 1px solid #fca5a5; border-radius: var(--radius-sm); padding: 14px; color: #991b1b; font-size: 13.5px; margin-bottom: 16px;">
                            ¿Estás seguro de que deseas eliminar este flujo de procesos?
                        </div>
                        <p style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 6px;" id="eliminarFlujoTitulo"></p>
                        <p style="font-size: 12.5px; color: #64748b;">
                            El flujo quedará inactivo y ya no estará disponible para su consulta.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="cerrarModalEliminarFlujo()">Cancelar</button>
                        <button type="submit" class="btn-primary-flujo" style="background: #dc2626;">
                            Sí, Eliminar Flujo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function filtrarFlujosEnVivo() {
            var input = document.getElementById('inputBuscarFlujos');
            var filtro = input ? input.value.toLowerCase().trim() : '';
            var cards = document.querySelectorAll('.flujo-card');

            cards.forEach(function(card) {
                var data = card.getAttribute('data-search') || '';
                if (data.indexOf(filtro) !== -1) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function seleccionarDivision(area) {
            document.querySelectorAll('.division-option-label').forEach(function(l) {
                l.classList.remove('selected');
            });
            var radio = document.querySelector('input[name="area"][value="' + area + '"]');
            if (radio) {
                radio.checked = true;
                radio.closest('.division-option-label').classList.add('selected');
            }
        }

        function abrirModalCargarFlujo(preseleccionArea) {
            var m = document.getElementById('modalCargarFlujo');
            if (m) {
                m.classList.add('active');
                if (preseleccionArea) {
                    seleccionarDivision(preseleccionArea);
                }
            }
        }

        function cerrarModalCargarFlujo() {
            var m = document.getElementById('modalCargarFlujo');
            if (m) m.classList.remove('active');
        }

        function actualizarNombreFlujo(input) {
            var text = document.getElementById('dropzoneFlujoText');
            if (input.files && input.files[0]) {
                text.innerHTML = '<strong>Archivo seleccionado:</strong> ' + input.files[0].name + ' (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
                text.style.color = '#4f46e5';
            }
        }

        function confirmarEliminarFlujo(id, titulo) {
            var modal = document.getElementById('modalEliminarFlujo');
            var idInput = document.getElementById('eliminarFlujoId');
            var titText = document.getElementById('eliminarFlujoTitulo');
            if (modal && idInput && titText) {
                idInput.value = id;
                titText.textContent = titulo;
                modal.classList.add('active');
            }
        }

        function cerrarModalEliminarFlujo() {
            var modal = document.getElementById('modalEliminarFlujo');
            if (modal) modal.classList.remove('active');
        }

        // Drag & drop
        var dropzone = document.getElementById('dropzoneFlujo');
        if (dropzone) {
            ['dragenter', 'dragover'].forEach(function(eventName) {
                dropzone.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(function(eventName) {
                dropzone.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('dragover');
                }, false);
            });

            dropzone.addEventListener('drop', function(e) {
                var dt = e.dataTransfer;
                var files = dt.files;
                var fileInput = document.getElementById('inputFileFlujo');
                if (files && files.length > 0 && fileInput) {
                    fileInput.files = files;
                    actualizarNombreFlujo(fileInput);
                }
            }, false);
        }

        // Escape para cerrar
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModalCargarFlujo();
                cerrarModalEliminarFlujo();
            }
        });
    </script>
</body>
</html>
