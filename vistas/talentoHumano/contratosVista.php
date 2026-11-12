<?php
// vistas/talentoHumano/contratosVista.php
$tituloPagina = "Contratos y Formato de Hoja de Vida — Portal INEES";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">`r`n    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title><?= htmlspecialchars($tituloPagina) ?></title>
    <style>
        :root {
            --primary:       #0d9488;
            --primary-dark:  #0f766e;
            --primary-light: #f0fdfa;
            --navy-hdv:      #0b315b;
            --navy-dark:     #072242;
            --green-hdv:     #28591f;
            --green-light:   #347728;
            --bg-page:       #f1f5f9;
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
            --shadow-lg:     0 12px 28px -4px rgba(15,34,61,.14);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 20px 60px;
            flex: 1;
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 22px;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb-sep { color: var(--border); }

        /* ── Hero Banner ── */
        .contratos-hero {
            background: linear-gradient(135deg, #0b1728 0%, #0c2b4e 50%, #0d4a3e 100%);
            border-radius: var(--radius-lg);
            padding: 26px 30px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 28px -5px rgba(11,23,40,.35);
            border: 1px solid rgba(13,148,136,.35);
        }

        .contratos-hero::after {
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
            background: rgba(13,148,136,.18);
            border: 1.5px solid rgba(13,148,136,.4);
            color: #2dd4bf;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(13,148,136,.25);
        }

        .hero-title h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-title p {
            color: #cbd5e1;
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

        /* ── Botones de acción del Hero ── */
        .hero-actions {
            display: flex;
            gap: 10px;
            z-index: 1;
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

        /* ── Navigation Tabs ── */
        .tabs-container {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 2px;
        }
        .tab-btn {
            background: transparent;
            border: none;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            border-radius: 8px 8px 0 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .tab-btn:hover {
            color: var(--primary);
            background: rgba(13, 148, 136, 0.05);
        }
        .tab-btn.active {
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
            background: #ffffff;
        }

        /* ── General Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
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
            background: #ffffff;
            color: #334155;
            border: 1px solid var(--border);
        }
        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .btn-success {
            background: #16a34a;
            color: #ffffff;
        }
        .btn-success:hover {
            background: #15803d;
        }
        .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        /* ── Card Content Box ── */
        .card-box {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            margin-bottom: 24px;
        }

        .card-box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-light);
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-box-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── Table Styles ── */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
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

        .emp-avatar-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .emp-thumb {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            background: #e2e8f0;
        }
        .emp-thumb-placeholder {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #0b315b;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11.5px;
            font-weight: 600;
        }
        .badge-activo {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-inactivo {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Form Styles ── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
        }
        .col-12 { grid-column: span 12; }
        .col-8  { grid-column: span 8; }
        .col-6  { grid-column: span 6; }
        .col-4  { grid-column: span 4; }
        .col-3  { grid-column: span 3; }

        @media (max-width: 900px) {
            .col-8, .col-6, .col-4, .col-3 { grid-column: span 12; }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }
        .form-group label .required {
            color: #dc2626;
        }
        .form-control {
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-size: 13.5px;
            color: var(--text-main);
            background: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,.15);
        }
        .form-help {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .form-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #0b315b;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
            margin-top: 15px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Auto-completar box */
        .autofill-box {
            background: #eff6ff;
            border: 1.5px dashed #60a5fa;
            border-radius: var(--radius-md);
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
        }
        .autofill-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .autofill-icon {
            width: 38px;
            height: 38px;
            background: #2563eb;
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Preview foto */
        .photo-upload-container {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 14px;
        }
        .preview-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            background: #e2e8f0;
        }

        /* Tablas dinámicas en el formulario */
        .dynamic-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 8px;
        }
        .dynamic-table th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 600;
            padding: 8px 10px;
            border: 1px solid var(--border);
            text-align: left;
        }
        .dynamic-table td {
            padding: 6px 8px;
            border: 1px solid var(--border);
            vertical-align: middle;
        }
        .dynamic-table input {
            width: 100%;
            padding: 6px 8px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 12.5px;
        }
        .btn-remove-row {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 12px;
        }

        /* ═══════════════════════════════════════════════════════════
           FORMATO OFICIAL DE HOJA DE VIDA (RÉPLICA EXACTA DE LA IMAGEN)
           ═══════════════════════════════════════════════════════════ */
        .hdv-wrapper {
            margin: 0 auto;
            max-width: 800px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.18);
            border-radius: 4px;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            position: relative;
        }

        .hdv-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hdv-container {
            display: grid;
            grid-template-columns: 37% 63%;
            min-height: 1080px;
            background: #ffffff;
            box-sizing: border-box;
            position: relative;
        }

        /* ── Columna Izquierda (Azul) ── */
        .hdv-left-col {
            background: #093466; /* Azul profundo idéntico al formato */
            color: #ffffff;
            padding: 0 20px 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .hdv-avatar-box {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px 0 16px;
        }

        .hdv-avatar-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffffff;
            background: #ffffff;
            box-shadow: 0 6px 16px rgba(0,0,0,0.35);
        }

        .hdv-left-section {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .hdv-left-title {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff;
            text-transform: uppercase;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #ffffff;
            margin-bottom: 6px;
        }

        .hdv-left-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12.5px;
            line-height: 1.45;
            color: #f1f5f9;
            word-break: break-word;
        }

        .hdv-left-item .icon-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #ffffff;
            color: #093466;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
            font-size: 11px;
        }

        .hdv-left-item-block {
            font-size: 12.5px;
            line-height: 1.45;
            color: #f1f5f9;
        }
        .hdv-left-item-block strong {
            color: #ffffff;
            font-weight: 700;
        }

        /* ── Columna Derecha (Blanca y Verde) ── */
        .hdv-right-col {
            background: #ffffff;
            color: #0f172a;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        /* Top INEES Logo Banner */
        .hdv-logo-header {
            padding: 16px 20px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .hdv-logo-img {
            height: 38px;
            object-fit: contain;
            margin-bottom: 2px;
        }
        .hdv-logo-sub {
            font-size: 10px;
            color: #1e3a8a;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Green Title Banner */
        .hdv-green-banner {
            background: #2b5d1e; /* Verde bosque institucional idéntico al formato */
            color: #ffffff;
            padding: 18px 24px;
            text-align: center;
        }
        .hdv-employee-name {
            font-size: 21px;
            font-weight: 900;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            line-height: 1.25;
            margin-bottom: 6px;
        }
        .hdv-employee-cargo {
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.3px;
            color: #f1f5f9;
        }

        /* Right Column Body Content */
        .hdv-right-body {
            padding: 20px 24px 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .hdv-right-section {
            display: flex;
            flex-direction: column;
            gap: 6px;
            text-align: center;
        }

        .hdv-right-title {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #1e293b;
            text-transform: uppercase;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #94a3b8;
            margin-bottom: 8px;
            text-align: center;
        }

        .hdv-right-text {
            font-size: 13.5px;
            color: #334155;
            line-height: 1.5;
        }

        /* Tabla de Vencimientos SOAT/Tecnomecánica/Licencia */
        .hdv-docs-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 12.5px;
        }
        .hdv-docs-table th {
            background: #008acb; /* Azul cyan encabezado tabla formato */
            color: #ffffff;
            font-weight: 800;
            padding: 6px 10px;
            border: 1px solid #0284c7;
            text-align: center;
            text-transform: uppercase;
            font-size: 12px;
        }
        .hdv-docs-table td {
            padding: 6px 10px;
            border: 1px solid #cbd5e1;
            text-align: center;
            font-weight: 600;
            color: #1e293b;
        }
        .hdv-docs-table td.cell-label {
            background: #ffffff;
            font-weight: 700;
            text-align: left;
            padding-left: 12px;
        }
        .hdv-docs-table tr.highlight-green td.cell-label {
            background: #22c55e;
            color: #ffffff;
        }
        .hdv-docs-table tr.highlight-green td {
            background: #f0fdf4;
            color: #15803d;
        }

        /* Tabla de Dotación */
        .hdv-dotacion-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 11px;
        }
        .hdv-dotacion-table th {
            background: #ffffff;
            color: #334155;
            font-weight: 800;
            padding: 5px 6px;
            border: 1px solid #64748b;
            text-align: center;
            text-transform: uppercase;
            font-size: 10.5px;
        }
        .hdv-dotacion-table td {
            padding: 5px 6px;
            border: 1px solid #64748b;
            text-align: center;
            font-weight: 600;
            color: #1e293b;
            height: 22px;
        }
        .hdv-dotacion-table td.col-ref {
            text-align: left;
            padding-left: 8px;
            font-weight: 700;
        }

        /* ── Estilos de Impresión (@media print) ── */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .sidebar-overlay, .sidebar-drawer, .btn-hamburger,
            header, .portal-navbar, .breadcrumb, .contratos-hero,
            .tabs-container, .hdv-toolbar, .alert, footer {
                display: none !important;
            }
            main {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .card-box {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .hdv-wrapper {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
            }
            .hdv-container {
                min-height: 100vh !important;
                grid-template-columns: 36% 64% !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .hdv-left-col {
                background: #093466 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .hdv-green-banner {
                background: #2b5d1e !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .hdv-docs-table th {
                background: #008acb !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: letter portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body>

<?php
// Inclusión modular de Navbar y Menú Lateral
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
        <span>Contratos y Hoja de Vida</span>
    </nav>

    <!-- Hero Banner -->
    <div class="contratos-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div class="hero-title">
                <h1>Contratos y Formato de Hoja de Vida</h1>
                <p>Gestión de información laboral, dotación y generación del formato oficial de hoja de vida INEES.</p>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Total: <strong><?= (int)($estadisticas['total'] ?? 0) ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>Activos: <strong style="color:#4ade80;"><?= (int)($estadisticas['activos'] ?? 0) ?></strong></span>
            </div>
            <?php if (!empty($estadisticas['conductores'])): ?>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                <span>Conductores: <strong style="color:#67e8f9;"><?= (int)$estadisticas['conductores'] ?></strong></span>
            </div>
            <?php endif; ?>
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

    <!-- Pestañas de Navegación -->
    <div class="tabs-container">
        <?php if ($esSuperUsuario || $esGestionHumana): ?>
            <a href="contratosControlador.php?accion=listar" class="tab-btn <?= ($accionGet === 'listar') ? 'active' : '' ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                Listado de Contratos
            </a>
            <a href="contratosControlador.php?accion=crear" class="tab-btn <?= ($accionGet === 'crear') ? 'active' : '' ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Agregar / Crear Hoja de Vida
            </a>
        <?php endif; ?>

        <?php if ($registroActual && ($accionGet === 'ver' || $accionGet === 'imprimir')): ?>
            <a href="contratosControlador.php?accion=ver&id=<?= (int)$registroActual['id'] ?>" class="tab-btn active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                Formato Hoja de Vida: <?= htmlspecialchars($registroActual['nombre_completo']) ?>
            </a>
        <?php endif; ?>

        <?php if ($registroActual && $accionGet === 'editar'): ?>
            <a href="contratosControlador.php?accion=editar&id=<?= (int)$registroActual['id'] ?>" class="tab-btn active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Editar: <?= htmlspecialchars($registroActual['nombre_completo']) ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- ═══════════════════════════════════════════════════════════
         VISTA 1: FORMATO OFICIAL HOJA DE VIDA (VER / IMPRIMIR)
         ═══════════════════════════════════════════════════════════ -->
    <?php if (($accionGet === 'ver' || $accionGet === 'imprimir') && $registroActual): ?>
        <?php
            // Parsear documentos y dotación
            $docsList = [];
            if (!empty($registroActual['documentos_vencimientos'])) {
                $docsList = json_decode($registroActual['documentos_vencimientos'], true) ?: [];
            }
            $dotList = [];
            if (!empty($registroActual['dotacion_datos'])) {
                $dotList = json_decode($registroActual['dotacion_datos'], true) ?: [];
            }
            // Foto fallback
            $fotoRuta = !empty($registroActual['foto']) ? '../../' . $registroActual['foto'] : '../../img/carrusel/slide1.png';
            if (!empty($registroActual['foto']) && !file_exists(__DIR__ . '/../../' . $registroActual['foto'])) {
                $fotoRuta = '../../uploads/hojas_vida/javier_patino.jpg';
            }
        ?>

        <div class="hdv-toolbar">
            <div style="display:flex; gap:10px; align-items:center;">
                <?php if ($esSuperUsuario || $esGestionHumana): ?>
                    <a href="contratosControlador.php?accion=listar" class="btn btn-secondary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Volver a la Lista
                    </a>
                    <a href="contratosControlador.php?accion=editar&id=<?= (int)$registroActual['id'] ?>" class="btn btn-primary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar Datos
                    </a>
                <?php endif; ?>
            </div>
            <div>
                <button type="button" onclick="window.print()" class="btn btn-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Imprimir / Guardar en PDF
                </button>
            </div>
        </div>

        <div class="hdv-wrapper" id="hojaDeVidaImprimible">
            <div class="hdv-container">

                <!-- ── COLUMNA IZQUIERDA (AZUL) ── -->
                <div class="hdv-left-col">
                    <div class="hdv-avatar-box">
                        <img src="<?= htmlspecialchars($fotoRuta) ?>" alt="Foto Colaborador" class="hdv-avatar-img" onerror="this.src='../../img/logo.png'">
                    </div>

                    <!-- CONTACTO -->
                    <div class="hdv-left-section">
                        <div class="hdv-left-title">CONTACTO</div>
                        <div class="hdv-left-item">
                            <span class="icon-circle">📞</span>
                            <span><?= htmlspecialchars($registroActual['telefono'] ?: 'N/A') ?></span>
                        </div>
                        <div class="hdv-left-item">
                            <span class="icon-circle">✉️</span>
                            <span><?= htmlspecialchars($registroActual['email'] ?: 'N/A') ?></span>
                        </div>
                        <div class="hdv-left-item">
                            <span class="icon-circle">📍</span>
                            <span><?= htmlspecialchars($registroActual['direccion'] ?: 'N/A') ?></span>
                        </div>
                    </div>

                    <!-- DATOS PERSONALES -->
                    <div class="hdv-left-section">
                        <div class="hdv-left-title">DATOS PERSONALES</div>
                        <div class="hdv-left-item-block">
                            C.C <?= htmlspecialchars($registroActual['cedula'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Fecha de Nacimiento<br>
                            <?= htmlspecialchars($registroActual['fecha_nacimiento'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            RH <?= htmlspecialchars($registroActual['rh'] ?: 'N/A') ?>
                        </div>
                    </div>

                    <!-- CONTACTO DE EMERGENCIA -->
                    <div class="hdv-left-section">
                        <div class="hdv-left-title">CONTACTO DE EMERGENCIA</div>
                        <div class="hdv-left-item-block">
                            Nombre: <?= htmlspecialchars($registroActual['contacto_emergencia_nombre'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Cel: <?= htmlspecialchars($registroActual['contacto_emergencia_cel'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Parentesco: <?= htmlspecialchars($registroActual['contacto_emergencia_parentesco'] ?: 'N/A') ?>
                        </div>
                    </div>

                    <!-- ESTADO CIVIL -->
                    <div class="hdv-left-section">
                        <div class="hdv-left-title">ESTADO CIVIL</div>
                        <div class="hdv-left-item-block">
                            <?= htmlspecialchars($registroActual['estado_civil'] ?: 'Soltero') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Nombre: <?= htmlspecialchars($registroActual['conyuge_nombre'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Cel: <?= htmlspecialchars($registroActual['conyuge_cel'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Nº Hijos: <?= htmlspecialchars($registroActual['num_hijos'] ?? '0') ?>
                        </div>
                    </div>

                    <!-- SEGURIDAD SOCIAL -->
                    <div class="hdv-left-section">
                        <div class="hdv-left-title">SEGURIDAD SOCIAL</div>
                        <div class="hdv-left-item-block">
                            EPS: <?= htmlspecialchars($registroActual['eps'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            ARL: <?= htmlspecialchars($registroActual['arl'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Caja de compensaciones:<br>
                            <?= htmlspecialchars($registroActual['caja_compensacion'] ?: 'N/A') ?>
                        </div>
                        <div class="hdv-left-item-block">
                            Fondo de Pensiones:<br>
                            <?= htmlspecialchars($registroActual['fondo_pensiones'] ?: 'N/A') ?>
                        </div>
                    </div>
                </div>

                <!-- ── COLUMNA DERECHA (BLANCA / VERDE) ── -->
                <div class="hdv-right-col">

                    <!-- Header Logo INEES -->
                    <div class="hdv-logo-header">
                        <img src="../../img/logo.png" alt="Logo INEES" class="hdv-logo-img">
                        <div class="hdv-logo-sub">Electrónica IT Seguridad</div>
                    </div>

                    <!-- Green Name Banner -->
                    <div class="hdv-green-banner">
                        <div class="hdv-employee-name"><?= htmlspecialchars($registroActual['nombre_completo']) ?></div>
                        <div class="hdv-employee-cargo"><?= htmlspecialchars($registroActual['cargo']) ?></div>
                    </div>

                    <!-- Body Content -->
                    <div class="hdv-right-body">

                        <!-- FORMACION ACADEMICA -->
                        <div class="hdv-right-section">
                            <div class="hdv-right-title">FORMACION ACADEMICA</div>
                            <div class="hdv-right-text">
                                • <?= htmlspecialchars($registroActual['formacion_academica'] ?: 'Bachiller Academico') ?>
                            </div>
                        </div>

                        <!-- EXPERIENCIA LABORAL -->
                        <div class="hdv-right-section">
                            <div class="hdv-right-title">EXPERIENCIA LABORAL</div>
                            <div class="hdv-right-text">
                                Empresa: <?= htmlspecialchars($registroActual['experiencia_empresa'] ?: 'N/A') ?>
                            </div>
                            <div class="hdv-right-text">
                                Cargo: <?= htmlspecialchars($registroActual['experiencia_cargo'] ?: $registroActual['cargo']) ?>
                            </div>

                            <?php if (!empty($docsList)): ?>
                                <table class="hdv-docs-table">
                                    <thead>
                                        <tr>
                                            <th>DATOS</th>
                                            <th>FECHA DE VENCIMIENTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($docsList as $doc): ?>
                                            <?php 
                                                $isLicencia = (stripos($doc['dato'] ?? '', 'licencia') !== false);
                                            ?>
                                            <tr class="<?= $isLicencia ? 'highlight-green' : '' ?>">
                                                <td class="cell-label"><?= htmlspecialchars($doc['dato'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($doc['fecha_vencimiento'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>

                        <!-- INFORMACIÓN DE CONTRATO -->
                        <div class="hdv-right-section">
                            <div class="hdv-right-title">INFORMACIÓN DE CONTRATO</div>
                            <div class="hdv-right-text">
                                <?= htmlspecialchars($registroActual['tipo_contrato'] ?: 'Contrato a término indefinido') ?>
                            </div>
                            <div class="hdv-right-text">
                                Fecha de Ingreso: <?= htmlspecialchars($registroActual['fecha_ingreso'] ?: 'N/A') ?>
                            </div>
                            <div class="hdv-right-text">
                                Salario: <?= htmlspecialchars($registroActual['salario'] ?: 'N/A') ?>
                            </div>
                        </div>

                        <!-- INFORMACIÓN BANCARIA -->
                        <div class="hdv-right-section">
                            <div class="hdv-right-title">INFORMACIÓN BANCARIA</div>
                            <div class="hdv-right-text">
                                Banco: <?= htmlspecialchars($registroActual['banco'] ?: 'N/A') ?>
                            </div>
                            <div class="hdv-right-text">
                                Tipo de Cuenta: <?= htmlspecialchars($registroActual['tipo_cuenta'] ?: 'Ahorros') ?>
                            </div>
                            <div class="hdv-right-text">
                                Nº Cuenta: <?= htmlspecialchars($registroActual['num_cuenta'] ?: 'N/A') ?>
                            </div>
                        </div>

                        <!-- ENTREGA DE DOTACION -->
                        <div class="hdv-right-section">
                            <div class="hdv-right-title">ENTREGA DE DOTACION</div>
                            <table class="hdv-dotacion-table">
                                <thead>
                                    <tr>
                                        <th>REFERENCIA</th>
                                        <th>TALLA</th>
                                        <th>ENTREGA # 1</th>
                                        <th>ENTREGA # 2</th>
                                        <th>ENTREGA # 3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($dotList)): ?>
                                        <?php foreach ($dotList as $dot): ?>
                                            <tr>
                                                <td class="col-ref"><?= htmlspecialchars($dot['referencia'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($dot['talla'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($dot['entrega_1'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($dot['entrega_2'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($dot['entrega_3'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td class="col-ref">PANTALON</td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td class="col-ref">BUSO MANGA LARGA</td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td class="col-ref">CHALECO</td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td class="col-ref">CALZADO</td><td></td><td></td><td></td><td></td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div><!-- /.hdv-right-body -->

                </div><!-- /.hdv-right-col -->

            </div><!-- /.hdv-container -->
        </div><!-- /.hdv-wrapper -->

        <?php if ($accionGet === 'imprimir'): ?>
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => { window.print(); }, 400);
                });
            </script>
        <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════════
         VISTA 2: FORMULARIO AGREGAR / EDITAR HOJA DE VIDA Y CONTRATO
         ═══════════════════════════════════════════════════════════ -->
    <?php elseif ($accionGet === 'crear' || $accionGet === 'editar'): ?>
        <?php
            $isEdicion = ($accionGet === 'editar' && $registroActual);
            $formTitulo = $isEdicion ? "Editar Hoja de Vida y Contrato" : "Agregar / Crear Nueva Hoja de Vida de Contrato";
            
            // Valores predeterminados
            $f_usuario_id   = $registroActual['usuario_id'] ?? '';
            $f_nombre       = $registroActual['nombre_completo'] ?? '';
            $f_cargo        = $registroActual['cargo'] ?? '';
            $f_foto         = $registroActual['foto'] ?? '';
            $f_telefono     = $registroActual['telefono'] ?? '';
            $f_email        = $registroActual['email'] ?? '';
            $f_direccion    = $registroActual['direccion'] ?? '';
            $f_cedula       = $registroActual['cedula'] ?? '';
            $f_nacimiento   = $registroActual['fecha_nacimiento'] ?? '';
            $f_rh           = $registroActual['rh'] ?? 'A+';
            $f_em_nombre    = $registroActual['contacto_emergencia_nombre'] ?? '';
            $f_em_cel       = $registroActual['contacto_emergencia_cel'] ?? '';
            $f_em_parent    = $registroActual['contacto_emergencia_parentesco'] ?? '';
            $f_est_civil    = $registroActual['estado_civil'] ?? 'Soltero';
            $f_cony_nombre  = $registroActual['conyuge_nombre'] ?? 'N/A';
            $f_cony_cel     = $registroActual['conyuge_cel'] ?? 'N/A';
            $f_hijos        = $registroActual['num_hijos'] ?? '0';
            $f_eps          = $registroActual['eps'] ?? 'Compensar';
            $f_arl          = $registroActual['arl'] ?? 'Sura';
            $f_caja         = $registroActual['caja_compensacion'] ?? 'Compensar';
            $f_pension      = $registroActual['fondo_pensiones'] ?? 'Porvenir';
            $f_academia     = $registroActual['formacion_academica'] ?? 'Bachiller Academico';
            $f_exp_empresa  = $registroActual['experiencia_empresa'] ?? '';
            $f_exp_cargo    = $registroActual['experiencia_cargo'] ?? '';
            $f_tipo_con     = $registroActual['tipo_contrato'] ?? 'Contrato a término indefinido';
            $f_fec_ingreso  = $registroActual['fecha_ingreso'] ?? date('d-m-Y');
            $f_salario      = $registroActual['salario'] ?? '$ ';
            $f_banco        = $registroActual['banco'] ?? 'Davivienda';
            $f_tipo_cuenta  = $registroActual['tipo_cuenta'] ?? 'Ahorros';
            $f_num_cuenta   = $registroActual['num_cuenta'] ?? '';
            $f_estado       = $registroActual['estado'] ?? 'activo';

            // Documentos
            $formDocs = [];
            if ($isEdicion && !empty($registroActual['documentos_vencimientos'])) {
                $formDocs = json_decode($registroActual['documentos_vencimientos'], true) ?: [];
            }
            if (empty($formDocs) && !$isEdicion) {
                $formDocs = [
                    ['dato' => 'SOAT', 'fecha_vencimiento' => ''],
                    ['dato' => 'TECNOMECANICA', 'fecha_vencimiento' => ''],
                    ['dato' => 'LICENCIA A2-B1-C1', 'fecha_vencimiento' => '']
                ];
            }

            // Dotación
            $formDot = [];
            if ($isEdicion && !empty($registroActual['dotacion_datos'])) {
                $formDot = json_decode($registroActual['dotacion_datos'], true) ?: [];
            }
            if (empty($formDot) && !$isEdicion) {
                $formDot = [
                    ['referencia' => 'PANTALON', 'talla' => '32', 'entrega_1' => '', 'entrega_2' => '', 'entrega_3' => ''],
                    ['referencia' => 'BUSO MANGA LARGA', 'talla' => 'L', 'entrega_1' => '', 'entrega_2' => '', 'entrega_3' => ''],
                    ['referencia' => 'CHALECO', 'talla' => 'L', 'entrega_1' => '', 'entrega_2' => '', 'entrega_3' => ''],
                    ['referencia' => 'CALZADO', 'talla' => '40', 'entrega_1' => '', 'entrega_2' => '', 'entrega_3' => '']
                ];
            }
        ?>

        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <?= htmlspecialchars($formTitulo) ?>
                </div>
                <a href="contratosControlador.php?accion=listar" class="btn btn-secondary btn-sm">
                    Cancelar y Volver
                </a>
            </div>

            <!-- Auto-completar desde Usuario del Sistema -->
            <div class="autofill-box">
                <div class="autofill-info">
                    <div class="autofill-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    </div>
                    <div>
                        <strong style="color:#1e3a8a; font-size:14px;">Auto-completar desde Colaborador Registrado:</strong>
                        <div style="font-size:12px; color:#475569;">Selecciona un usuario de la base del portal para precargar al instante su nombre, cédula, cargo, celular y correo.</div>
                    </div>
                </div>
                <div style="min-width: 280px;">
                    <select id="selectUsuarioAutoFill" class="form-control" onchange="autoCompletarUsuario(this.value)">
                        <option value="">-- Seleccionar Colaborador --</option>
                        <?php foreach ($listaUsuarios as $u): ?>
                            <option value="<?= (int)$u['usuario_id'] ?>" <?= ($f_usuario_id == $u['usuario_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($u['nombre']) ?> (<?= htmlspecialchars($u['cargo'] ?? 'Sin cargo') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Formulario Principal -->
            <form action="contratosControlador.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="<?= $isEdicion ? 'editar' : 'crear' ?>">
                <?php if ($isEdicion): ?>
                    <input type="hidden" name="id" value="<?= (int)$registroActual['id'] ?>">
                <?php endif; ?>
                <input type="hidden" name="usuario_id" id="hidden_usuario_id" value="<?= htmlspecialchars((string)$f_usuario_id) ?>">

                <!-- 1. FOTO Y ENCABEZADO -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    1. Fotografía del Colaborador
                </div>

                <div class="photo-upload-container">
                    <?php 
                        $previewSrc = !empty($f_foto) ? '../../' . $f_foto : '../../img/logo.png';
                        if (!empty($f_foto) && !file_exists(__DIR__ . '/../../' . $f_foto)) {
                            $previewSrc = '../../uploads/hojas_vida/javier_patino.jpg';
                        }
                    ?>
                    <img id="imgPreview" src="<?= htmlspecialchars($previewSrc) ?>" alt="Vista Previa" class="preview-avatar" onerror="this.src='../../img/logo.png'">
                    <div style="flex:1;">
                        <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Seleccionar Foto (.jpg, .png, .webp):</label>
                        <input type="file" name="foto" id="inputFoto" class="form-control" accept="image/jpeg,image/png,image/webp" onchange="previsualizarFoto(event)">
                        <div class="form-help">Foto para el círculo superior de la hoja de vida. Se recomienda foto formal tipo documento.</div>
                    </div>
                </div>

                <!-- 2. IDENTIFICACIÓN Y CARGO -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    2. Datos de Identificación y Cargo
                </div>

                <div class="form-grid">
                    <div class="form-group col-6">
                        <label>Nombre Completo <span class="required">*</span></label>
                        <input type="text" name="nombre_completo" id="campo_nombre" class="form-control" value="<?= htmlspecialchars($f_nombre) ?>" required placeholder="Ej: JAVIER ALONSO PATIÑO LOZADA">
                    </div>
                    <div class="form-group col-6">
                        <label>Cargo Desempeñado <span class="required">*</span></label>
                        <input type="text" name="cargo" id="campo_cargo" class="form-control" value="<?= htmlspecialchars($f_cargo) ?>" required placeholder="Ej: Conductor">
                    </div>
                    <div class="form-group col-4">
                        <label>Cédula de Ciudadanía (C.C) <span class="required">*</span></label>
                        <input type="text" name="cedula" id="campo_cedula" class="form-control" value="<?= htmlspecialchars($f_cedula) ?>" required placeholder="Ej: 80057501">
                    </div>
                    <div class="form-group col-4">
                        <label>Fecha de Nacimiento</label>
                        <input type="text" name="fecha_nacimiento" id="campo_nacimiento" class="form-control" value="<?= htmlspecialchars($f_nacimiento) ?>" placeholder="Ej: 02-07-1980">
                    </div>
                    <div class="form-group col-4">
                        <label>Grupo Sanguíneo y RH</label>
                        <select name="rh" class="form-control">
                            <?php foreach (['A+', 'O+', 'B+', 'AB+', 'A-', 'O-', 'B-', 'AB-'] as $g): ?>
                                <option value="<?= $g ?>" <?= ($f_rh === $g) ? 'selected' : '' ?>><?= $g ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- 3. CONTACTO Y RESIDENCIA -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    3. Contacto y Residencia (Columna Izquierda)
                </div>

                <div class="form-grid">
                    <div class="form-group col-4">
                        <label>Celular / Teléfono</label>
                        <input type="text" name="telefono" id="campo_telefono" class="form-control" value="<?= htmlspecialchars($f_telefono) ?>" placeholder="Ej: 3132751686">
                    </div>
                    <div class="form-group col-4">
                        <label>Correo Electrónico</label>
                        <input type="email" name="email" id="campo_email" class="form-control" value="<?= htmlspecialchars($f_email) ?>" placeholder="Ej: javierp_mus@hotmail.com">
                    </div>
                    <div class="form-group col-4">
                        <label>Dirección de Residencia</label>
                        <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($f_direccion) ?>" placeholder="Ej: Carrera 77 P Sur # 55 -41 Bloque 9 APT 202">
                    </div>
                </div>

                <!-- 4. CONTACTO DE EMERGENCIA -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    4. Contacto de Emergencia
                </div>

                <div class="form-grid">
                    <div class="form-group col-4">
                        <label>Nombre del Contacto</label>
                        <input type="text" name="contacto_emergencia_nombre" class="form-control" value="<?= htmlspecialchars($f_em_nombre) ?>" placeholder="Ej: Susan Patiña">
                    </div>
                    <div class="form-group col-4">
                        <label>Celular de Emergencia</label>
                        <input type="text" name="contacto_emergencia_cel" id="campo_emergencia_cel" class="form-control" value="<?= htmlspecialchars($f_em_cel) ?>" placeholder="Ej: 3193252192">
                    </div>
                    <div class="form-group col-4">
                        <label>Parentesco</label>
                        <input type="text" name="contacto_emergencia_parentesco" class="form-control" value="<?= htmlspecialchars($f_em_parent) ?>" placeholder="Ej: Hermana">
                    </div>
                </div>

                <!-- 5. ESTADO CIVIL Y FAMILIA -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    5. Estado Civil y Familia
                </div>

                <div class="form-grid">
                    <div class="form-group col-3">
                        <label>Estado Civil</label>
                        <select name="estado_civil" class="form-control">
                            <?php foreach (['Separado', 'Soltero', 'Casado', 'Unión Libre', 'Viudo'] as $ec): ?>
                                <option value="<?= $ec ?>" <?= ($f_est_civil === $ec) ? 'selected' : '' ?>><?= $ec ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label>Nombre Pareja / Cónyuge</label>
                        <input type="text" name="conyuge_nombre" class="form-control" value="<?= htmlspecialchars($f_cony_nombre) ?>" placeholder="Ej: N/A">
                    </div>
                    <div class="form-group col-3">
                        <label>Celular Pareja</label>
                        <input type="text" name="conyuge_cel" class="form-control" value="<?= htmlspecialchars($f_cony_cel) ?>" placeholder="Ej: N/A">
                    </div>
                    <div class="form-group col-3">
                        <label>Nº de Hijos</label>
                        <input type="number" min="0" max="20" name="num_hijos" class="form-control" value="<?= htmlspecialchars($f_hijos) ?>">
                    </div>
                </div>

                <!-- 6. SEGURIDAD SOCIAL -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    6. Seguridad Social
                </div>

                <div class="form-grid">
                    <div class="form-group col-3">
                        <label>EPS</label>
                        <input type="text" name="eps" class="form-control" value="<?= htmlspecialchars($f_eps) ?>" placeholder="Ej: Compensar">
                    </div>
                    <div class="form-group col-3">
                        <label>ARL</label>
                        <input type="text" name="arl" class="form-control" value="<?= htmlspecialchars($f_arl) ?>" placeholder="Ej: Sura">
                    </div>
                    <div class="form-group col-3">
                        <label>Caja de Compensación</label>
                        <input type="text" name="caja_compensacion" class="form-control" value="<?= htmlspecialchars($f_caja) ?>" placeholder="Ej: Compensar">
                    </div>
                    <div class="form-group col-3">
                        <label>Fondo de Pensiones</label>
                        <input type="text" name="fondo_pensiones" class="form-control" value="<?= htmlspecialchars($f_pension) ?>" placeholder="Ej: Porvenir">
                    </div>
                </div>

                <!-- 7. FORMACIÓN ACADÉMICA Y EXPERIENCIA -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    7. Formación Académica y Experiencia Laboral
                </div>

                <div class="form-grid">
                    <div class="form-group col-4">
                        <label>Formación Académica</label>
                        <input type="text" name="formacion_academica" class="form-control" value="<?= htmlspecialchars($f_academia) ?>" placeholder="Ej: Bachiller Academico">
                    </div>
                    <div class="form-group col-4">
                        <label>Empresa de Experiencia</label>
                        <input type="text" name="experiencia_empresa" class="form-control" value="<?= htmlspecialchars($f_exp_empresa) ?>" placeholder="Ej: Asesores Auditores Integrales">
                    </div>
                    <div class="form-group col-4">
                        <label>Cargo en Experiencia</label>
                        <input type="text" name="experiencia_cargo" class="form-control" value="<?= htmlspecialchars($f_exp_cargo) ?>" placeholder="Ej: Conductor">
                    </div>
                </div>

                <!-- 8. DOCUMENTOS Y VENCIMIENTOS (TABLA DINÁMICA) -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    8. Tabla de Vencimientos (SOAT, Tecnomecánica, Licencias, Certificaciones)
                </div>

                <table class="dynamic-table" id="tablaDocsVencimiento">
                    <thead>
                        <tr>
                            <th style="width:55%;">DATOS (Nombre del Documento)</th>
                            <th style="width:35%;">FECHA DE VENCIMIENTO</th>
                            <th style="width:10%; text-align:center;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($formDocs as $doc): ?>
                            <tr>
                                <td>
                                    <input type="text" name="doc_nombre[]" value="<?= htmlspecialchars($doc['dato'] ?? '') ?>" placeholder="Ej: SOAT, LICENCIA A2-B1-C1">
                                </td>
                                <td>
                                    <input type="text" name="doc_fecha[]" value="<?= htmlspecialchars($doc['fecha_vencimiento'] ?? '') ?>" placeholder="Ej: 27/05/2026">
                                </td>
                                <td style="text-align:center;">
                                    <button type="button" class="btn-remove-row" onclick="eliminarFila(this)">✕</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="margin-top:8px;">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="agregarFilaDoc()">
                        ➕ Agregar Otro Documento / Vencimiento
                    </button>
                </div>

                <!-- 9. CONTRATO Y BANCO -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    9. Información Contractual y Bancaria
                </div>

                <div class="form-grid">
                    <div class="form-group col-4">
                        <label>Tipo de Contrato</label>
                        <select name="tipo_contrato" class="form-control">
                            <?php foreach (['Contrato a término indefinido', 'Contrato a término fijo', 'Contrato por obra o labor', 'Prestación de servicios', 'Aprendizaje'] as $tc): ?>
                                <option value="<?= $tc ?>" <?= ($f_tipo_con === $tc) ? 'selected' : '' ?>><?= $tc ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label>Fecha de Ingreso</label>
                        <input type="text" name="fecha_ingreso" class="form-control" value="<?= htmlspecialchars($f_fec_ingreso) ?>" placeholder="Ej: 01-12-2025">
                    </div>
                    <div class="form-group col-4">
                        <label>Salario</label>
                        <input type="text" name="salario" class="form-control" value="<?= htmlspecialchars($f_salario) ?>" placeholder="Ej: $ 1.927.000">
                    </div>
                    <div class="form-group col-4">
                        <label>Banco</label>
                        <input type="text" name="banco" class="form-control" value="<?= htmlspecialchars($f_banco) ?>" placeholder="Ej: Davivienda, Bancolombia">
                    </div>
                    <div class="form-group col-4">
                        <label>Tipo de Cuenta</label>
                        <select name="tipo_cuenta" class="form-control">
                            <option value="Ahorros" <?= ($f_tipo_cuenta === 'Ahorros') ? 'selected' : '' ?>>Ahorros</option>
                            <option value="Corriente" <?= ($f_tipo_cuenta === 'Corriente') ? 'selected' : '' ?>>Corriente</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label>Nº de Cuenta</label>
                        <input type="text" name="num_cuenta" class="form-control" value="<?= htmlspecialchars($f_num_cuenta) ?>" placeholder="Ej: 550488456826889">
                    </div>
                </div>

                <!-- 10. ENTREGA DE DOTACIÓN (TABLA DINÁMICA) -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>
                    10. Entrega de Dotación
                </div>

                <table class="dynamic-table" id="tablaDotacion">
                    <thead>
                        <tr>
                            <th style="width:35%;">REFERENCIA</th>
                            <th style="width:15%;">TALLA</th>
                            <th style="width:15%;">ENTREGA # 1</th>
                            <th style="width:15%;">ENTREGA # 2</th>
                            <th style="width:15%;">ENTREGA # 3</th>
                            <th style="width:5%; text-align:center;">✕</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($formDot as $dot): ?>
                            <tr>
                                <td>
                                    <input type="text" name="dot_ref[]" value="<?= htmlspecialchars($dot['referencia'] ?? '') ?>" placeholder="Ej: PANTALON">
                                </td>
                                <td>
                                    <input type="text" name="dot_talla[]" value="<?= htmlspecialchars($dot['talla'] ?? '') ?>" placeholder="Ej: 32 / L / 40">
                                </td>
                                <td>
                                    <input type="text" name="dot_e1[]" value="<?= htmlspecialchars($dot['entrega_1'] ?? '') ?>" placeholder="Fecha / Cant.">
                                </td>
                                <td>
                                    <input type="text" name="dot_e2[]" value="<?= htmlspecialchars($dot['entrega_2'] ?? '') ?>" placeholder="Fecha / Cant.">
                                </td>
                                <td>
                                    <input type="text" name="dot_e3[]" value="<?= htmlspecialchars($dot['entrega_3'] ?? '') ?>" placeholder="Fecha / Cant.">
                                </td>
                                <td style="text-align:center;">
                                    <button type="button" class="btn-remove-row" onclick="eliminarFila(this)">✕</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="margin-top:8px;">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="agregarFilaDotacion()">
                        ➕ Agregar Otra Prenda / Elemento de Dotación
                    </button>
                </div>

                <!-- 11. ESTADO DEL REGISTRO -->
                <div class="form-section-title" style="margin-top:25px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                    11. Estado del Contrato
                </div>
                <div class="form-grid">
                    <div class="form-group col-4">
                        <label>Estado del Colaborador</label>
                        <select name="estado" class="form-control">
                            <option value="activo" <?= ($f_estado === 'activo') ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= ($f_estado === 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                            <option value="finalizado" <?= ($f_estado === 'finalizado') ? 'selected' : '' ?>>Finalizado</option>
                        </select>
                    </div>
                </div>

                <!-- BOTONES DE ACCIÓN FINAL -->
                <div style="margin-top: 30px; display: flex; gap: 12px; align-items: center; border-top: 1px solid var(--border); padding-top: 20px;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 15px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <?= $isEdicion ? 'Actualizar y Ver Formato' : 'Guardar y Generar Formato de Hoja de Vida' ?>
                    </button>
                    <a href="contratosControlador.php?accion=listar" class="btn btn-secondary" style="padding: 12px 20px;">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    <!-- ═══════════════════════════════════════════════════════════
         VISTA 3: LISTADO DE CONTRATOS Y HOJAS DE VIDA
         ═══════════════════════════════════════════════════════════ -->
    <?php else: ?>

        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Contratos y Hojas de Vida Registradas
                </div>

                <?php if ($esSuperUsuario || $esGestionHumana): ?>
                    <a href="contratosControlador.php?accion=crear" class="btn btn-primary btn-sm">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Agregar / Crear Hoja de Vida
                    </a>
                <?php endif; ?>
            </div>

            <!-- Filtros y Búsqueda -->
            <form action="contratosControlador.php" method="GET" style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
                <input type="hidden" name="accion" value="listar">
                <div style="flex:1; min-width:260px;">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por Nombre, Cédula, Cargo o Correo..." value="<?= htmlspecialchars($busqueda) ?>">
                </div>
                <div style="width:160px;">
                    <select name="filtro_estado" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="activo" <?= ($filtroEst === 'activo') ? 'selected' : '' ?>>Activos</option>
                        <option value="inactivo" <?= ($filtroEst === 'inactivo') ? 'selected' : '' ?>>Inactivos</option>
                        <option value="finalizado" <?= ($filtroEst === 'finalizado') ? 'selected' : '' ?>>Finalizados</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Buscar
                </button>
                <?php if (!empty($busqueda) || !empty($filtroEst)): ?>
                    <a href="contratosControlador.php?accion=listar" class="btn btn-secondary btn-sm">Limpiar</a>
                <?php endif; ?>
            </form>

            <!-- Tabla de Registros -->
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Colaborador</th>
                            <th>Cédula</th>
                            <th>Cargo</th>
                            <th>Tipo de Contrato</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th style="text-align:right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contratos)): ?>
                            <?php foreach ($contratos as $c): ?>
                                <?php 
                                    $cFoto = !empty($c['foto']) ? '../../' . $c['foto'] : '../../img/logo.png';
                                    if (!empty($c['foto']) && !file_exists(__DIR__ . '/../../' . $c['foto'])) {
                                        $cFoto = '../../uploads/hojas_vida/javier_patino.jpg';
                                    }
                                    $estBadge = ($c['estado'] === 'activo') ? 'badge-activo' : 'badge-inactivo';
                                ?>
                                <tr>
                                    <td>
                                        <div class="emp-avatar-cell">
                                            <img src="<?= htmlspecialchars($cFoto) ?>" alt="" class="emp-thumb" onerror="this.src='../../img/logo.png'">
                                            <div>
                                                <strong style="color:#0f223d; display:block;"><?= htmlspecialchars($c['nombre_completo']) ?></strong>
                                                <span style="font-size:12px; color:#64748b;"><?= htmlspecialchars($c['email'] ?: 'Sin correo') ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong><?= htmlspecialchars($c['cedula']) ?></strong></td>
                                    <td><?= htmlspecialchars($c['cargo']) ?></td>
                                    <td><?= htmlspecialchars($c['tipo_contrato'] ?: 'Término Indefinido') ?></td>
                                    <td><?= htmlspecialchars($c['fecha_ingreso'] ?: 'N/A') ?></td>
                                    <td>
                                        <span class="badge-status <?= $estBadge ?>">
                                            ● <?= ucfirst(htmlspecialchars($c['estado'] ?? 'activo')) ?>
                                        </span>
                                    </td>
                                    <td style="text-align:right; white-space:nowrap;">
                                        <!-- Ver Formato Hoja de Vida -->
                                        <a href="contratosControlador.php?accion=ver&id=<?= (int)$c['id'] ?>" class="btn btn-secondary btn-sm" title="Ver Formato Hoja de Vida">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            Ver Formato
                                        </a>

                                        <!-- Imprimir / PDF -->
                                        <a href="contratosControlador.php?accion=imprimir&id=<?= (int)$c['id'] ?>" target="_blank" class="btn btn-secondary btn-sm" title="Imprimir o guardar PDF">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                        </a>

                                        <?php if ($esSuperUsuario || $esGestionHumana): ?>
                                            <!-- Editar -->
                                            <a href="contratosControlador.php?accion=editar&id=<?= (int)$c['id'] ?>" class="btn btn-secondary btn-sm" title="Editar">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </a>

                                            <!-- Eliminar -->
                                            <form action="contratosControlador.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro de que deseas eliminar este contrato y hoja de vida?');">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                                                <button type="submit" class="btn btn-secondary btn-sm" style="color:#dc2626;" title="Eliminar">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align:center; padding:35px 20px; color:#64748b;">
                                    <div style="font-size:24px; margin-bottom:8px;">📄</div>
                                    <div style="font-weight:600; font-size:15px; color:#334155;">No se encontraron contratos registrados.</div>
                                    <div style="font-size:13px; margin-top:4px;">Haz clic en "Agregar / Crear Hoja de Vida" para registrar el primer colaborador.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>

</main>

<script>
// Auto-completar usuario desde API
function autoCompletarUsuario(usuarioId) {
    if (!usuarioId) return;

    fetch('contratosControlador.php?api=usuario_data&uid=' + encodeURIComponent(usuarioId))
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const u = response.data;
                document.getElementById('hidden_usuario_id').value = u.usuario_id || '';
                if (u.nombre) document.getElementById('campo_nombre').value = u.nombre;
                if (u.cargo) document.getElementById('campo_cargo').value = u.cargo;
                if (u.cedula) document.getElementById('campo_cedula').value = u.cedula;
                if (u.celular) document.getElementById('campo_telefono').value = u.celular;
                if (u.email) document.getElementById('campo_email').value = u.email;
                if (u.telefono_emergencia) {
                    const emCel = document.getElementById('campo_emergencia_cel');
                    if (emCel) emCel.value = u.telefono_emergencia;
                }
            }
        })
        .catch(err => console.error("Error al auto-completar:", err));
}

// Previsualización de foto cargada
function previsualizarFoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Eliminar fila de tabla dinámica
function eliminarFila(btn) {
    const row = btn.closest('tr');
    if (row) {
        row.remove();
    }
}

// Agregar fila en tabla de documentos / vencimientos
function agregarFilaDoc() {
    const tbody = document.querySelector('#tablaDocsVencimiento tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="doc_nombre[]" placeholder="Ej: SOAT, LICENCIA A2-B1-C1"></td>
        <td><input type="text" name="doc_fecha[]" placeholder="Ej: 27/05/2026"></td>
        <td style="text-align:center;"><button type="button" class="btn-remove-row" onclick="eliminarFila(this)">✕</button></td>
    `;
    tbody.appendChild(tr);
}

// Agregar fila en tabla de dotación
function agregarFilaDotacion() {
    const tbody = document.querySelector('#tablaDotacion tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="dot_ref[]" placeholder="Ej: BOTAS DE SEGURIDAD"></td>
        <td><input type="text" name="dot_talla[]" placeholder="Ej: 41"></td>
        <td><input type="text" name="dot_e1[]" placeholder="Fecha / Cant."></td>
        <td><input type="text" name="dot_e2[]" placeholder="Fecha / Cant."></td>
        <td><input type="text" name="dot_e3[]" placeholder="Fecha / Cant."></td>
        <td style="text-align:center;"><button type="button" class="btn-remove-row" onclick="eliminarFila(this)">✕</button></td>
    `;
    tbody.appendChild(tr);
}
</script>

</body>
</html>
