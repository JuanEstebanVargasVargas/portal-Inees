<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../img/logo.png">
    <title>Formato de Permisos — Portal INEES</title>
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
            --superusuario-color: #7c3aed;
            --gh-color:           #0d9488;
            --empleado-color:     #0284c7;
        }

        * { box-sizing: border-box; margin: 0; padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        body { background: var(--bg-page); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; }

        main {
            max-width: 1200px;
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
        .permiso-hero {
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

        .permiso-hero::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(13,148,136,.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .permiso-hero-info {
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 1;
        }

        .permiso-hero-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: rgba(13,148,136,.15);
            border: 1.5px solid rgba(13,148,136,.4);
            color: #2dd4bf;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(13,148,136,.2);
        }

        .permiso-hero-text h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .permiso-hero-text p {
            color: #94a3b8;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .permiso-hero-badge {
            background: rgba(13,148,136,.2);
            color: #5eead4;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(45,212,191,.3);
        }

        .permiso-hero-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1;
        }

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

        .btn-outline {
            background: rgba(255,255,255,.08);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,.2);
        }
        .btn-outline:hover {
            background: rgba(255,255,255,.16);
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

        /* ── Form Grid ── */
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
            cursor: not-allowed;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
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

        /* ── Radio / Switch Box ── */
        .radio-options-box {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 10px 16px;
            background: #f8fafc;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
        }
        .radio-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }
        .radio-label input[type="radio"] {
            accent-color: var(--primary);
            width: 17px;
            height: 17px;
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
        .badge-pendiente {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-aprobado {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-rechazado, .badge-no_aprueba {
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

        /* ── Actions Dropdown / Group ── */
        .table-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Physical Format Print Sheet (Matches Image 2 exactly) ── */
        .print-sheet-wrapper {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            box-shadow: var(--shadow-md);
            max-width: 820px;
            margin: 0 auto 30px;
            padding: 40px 48px;
            color: #000000;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            font-size: 12.5px;
            line-height: 1.45;
        }

        /* Encabezado formal según imagen */
        .official-header-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000000;
            margin-bottom: 22px;
        }
        .official-header-table td {
            border: 1.5px solid #000000;
            vertical-align: middle;
            padding: 8px 12px;
        }
        .header-logo-box {
            width: 25%;
            text-align: center;
        }
        .header-logo-box img {
            max-height: 48px;
            max-width: 130px;
            object-fit: contain;
            display: block;
            margin: 0 auto 3px;
        }
        .header-logo-box .logo-caption {
            font-size: 9px;
            color: #000;
            font-weight: 600;
            letter-spacing: .2px;
        }
        .header-title-box {
            width: 48%;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            line-height: 1.35;
        }
        .header-meta-box {
            width: 27%;
            padding: 0 !important;
        }
        .meta-inner-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .meta-inner-table td, .meta-inner-table th {
            border: 1px solid #000000;
            padding: 3px 6px;
            font-size: 9.5px;
        }
        .meta-inner-table th {
            font-weight: 700;
            text-align: left;
            width: 50%;
            background: #f4f4f4;
        }
        .meta-inner-table td {
            text-align: center;
            font-weight: 500;
        }

        .official-doc-title {
            text-align: center;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: .3px;
            margin-bottom: 18px;
            text-transform: uppercase;
        }

        .official-section-title {
            font-size: 12px;
            font-weight: 600;
            margin: 14px 0 8px;
        }

        .official-field-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 7px;
            font-size: 12px;
        }
        .official-field-label {
            font-weight: 500;
            white-space: nowrap;
            margin-right: 6px;
        }
        .official-field-line {
            flex: 1;
            border-bottom: 1px solid #475569;
            min-height: 18px;
            padding-left: 6px;
            padding-bottom: 1px;
            font-weight: 500;
            color: #000;
        }

        .official-split-row {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .official-check-group {
            display: inline-flex;
            align-items: center;
            gap: 16px;
        }
        .check-square {
            display: inline-block;
            width: 13px;
            height: 13px;
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
            line-height: 11px;
            font-size: 11px;
            font-weight: bold;
            margin-right: 3px;
        }

        .official-signature-block {
            margin-top: 32px;
            padding-top: 8px;
        }
        .official-signature-line {
            width: 60%;
            border-bottom: 1px solid #000;
            height: 38px;
            margin-bottom: 4px;
        }
        .official-signature-caption {
            font-size: 11px;
            color: #000;
        }

        .official-divider {
            border-top: 1px solid #94a3b8;
            margin: 14px 0;
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
            max-width: 580px;
            width: 100%;
            padding: 24px 28px;
            box-shadow: var(--shadow-lg);
            position: relative;
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
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
        }
        .modal-close {
            background: transparent;
            border: none;
            font-size: 22px;
            color: #94a3b8;
            cursor: pointer;
            line-height: 1;
        }

        /* ── PRINT STYLES ── */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .navbar-container,
            .sidebar-overlay,
            .sidebar-container,
            .breadcrumb,
            .permiso-hero,
            .tabs-container,
            .no-print,
            .modal-overlay {
                display: none !important;
            }
            main {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .tab-pane {
                display: none !important;
            }
            #pane-formato-impresion {
                display: block !important;
            }
            .print-sheet-wrapper {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                padding: 15px 25px !important;
                margin: 0 !important;
            }
            @page {
                size: letter portrait;
                margin: 1.2cm;
            }
        }
    </style>
</head>
<body>

<?php
// Navbar y sidebar
require_once __DIR__ . '/../partials/navbar/navbar.php';
require_once __DIR__ . '/../partials/sidebar/sidebar.php';
?>

<main>

    <!-- Breadcrumb -->
    <nav class="breadcrumb no-print">
        <a href="../../index.php">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Inicio
        </a>
        <span class="breadcrumb-sep">›</span>
        <span>Talento Humano</span>
        <span class="breadcrumb-sep">›</span>
        <span>Formato de permisos</span>
    </nav>

    <!-- Hero Banner -->
    <div class="permiso-hero no-print">
        <div class="permiso-hero-info">
            <div class="permiso-hero-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="permiso-hero-text">
                <h1>Formato de Solicitud de Permiso</h1>
                <p>
                    <span>Gestión de Talento Humano</span>
                    <span class="permiso-hero-badge">Código: GTH-05-01 · Versión 1</span>
                </p>
            </div>
        </div>
        <div class="permiso-hero-actions">
            <?php if ($puedeVerHistorialYFormato): ?>
            <button type="button" class="btn btn-outline" onclick="imprimirFormatoOficial()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                Imprimir Formato Físico
            </button>
            <?php endif; ?>
            <button type="button" class="btn btn-primary" onclick="cambiarTab('solicitar')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Nueva Solicitud
            </button>
        </div>
    </div>

    <!-- Mensajes de feedback -->
    <?php if (!empty($mensajeExito)): ?>
        <div class="alert alert-success no-print">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div><?= htmlspecialchars($mensajeExito) ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensajeError)): ?>
        <div class="alert alert-danger no-print">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div><?= htmlspecialchars($mensajeError) ?></div>
        </div>
    <?php endif; ?>

    <?php if ($puedeVerHistorialYFormato): ?>
    <!-- Tabs Navigation (Visible exclusivamente para Gestión Humana y Administrador) -->
    <div class="tabs-container no-print">
        <button type="button" class="tab-btn <?= (!$permisoSeleccionado && !isset($_GET['tab_historial'])) ? 'active' : '' ?>" id="tab-btn-solicitar" onclick="cambiarTab('solicitar')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Diligenciar Solicitud
        </button>
        <button type="button" class="tab-btn <?= (isset($_GET['tab_historial'])) ? 'active' : '' ?>" id="tab-btn-historial" onclick="cambiarTab('historial')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Historial de Solicitudes (<?= count($listaPermisos) ?>)
        </button>
        <button type="button" class="tab-btn <?= ($permisoSeleccionado) ? 'active' : '' ?>" id="tab-btn-formato" onclick="cambiarTab('formato')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Vista Formato Físico Oficial (GTH-05-01)
        </button>
    </div>
    <?php endif; ?>

    <!-- ═════════════════════════════════════════════════════════════════
         TAB 1: DILIGENCIAR SOLICITUD
         ═════════════════════════════════════════════════════════════════ -->
    <div class="tab-pane <?= (!$permisoSeleccionado && !isset($_GET['tab_historial'])) ? 'active' : '' ?>" id="pane-solicitar">
        <!-- Mensaje de Notificación de Proceso para Empleado -->
        <div class="aviso-proceso-empleado no-print">
            <div class="aviso-proceso-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <div class="aviso-proceso-body">
                <div class="aviso-proceso-titulo">Información sobre el trámite de solicitud de permiso</div>
                <div class="aviso-proceso-texto">
                    Diligencia los datos de tu permiso laboral (Formato GTH-05-01). La solicitud será revisada y validada por tu jefe inmediato y el área de Gestión Humana. Se te notificará oportunamente a tu <strong>correo electrónico registrado</strong> y en el portal institucional si tu permiso fue <strong>Aprobado</strong> o <strong>Denegado</strong>.
                </div>
            </div>
        </div>

        <form method="POST" action="formatoPermisosControlador.php" class="card" id="form-solicitud-permiso">
            <input type="hidden" name="accion" value="crear_permiso">

            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Información del Empleado y del Permiso
                </div>
                <span class="badge-status badge-pendiente">Código: GTH-05-01</span>
            </div>

            <div class="form-grid">
                <!-- Información del Empleado -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    1. Información del Empleado
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Nombre Completo <span class="req">*</span></label>
                    <input type="text" name="nombre_empleado" class="form-control" value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>" required>
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Documento de Identidad (Cédula) <span class="req">*</span></label>
                    <input type="text" name="cedula" class="form-control" value="<?= htmlspecialchars($perfil['cedula'] ?? '') ?>" required>
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Cargo <span class="req">*</span></label>
                    <input type="text" name="cargo" class="form-control" value="<?= htmlspecialchars($perfil['cargo'] ?? '') ?>" required>
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Departamento / Área <span class="req">*</span></label>
                    <input type="text" name="departamento_area" class="form-control" value="<?= htmlspecialchars($perfil['area'] ?? '') ?>" required>
                </div>

                <!-- Detalle y Motivo -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    2. Detalle y Motivo del Permiso
                </div>

                <div class="form-group col-8">
                    <label class="form-label">Detalle del Permiso <span class="req">*</span></label>
                    <input type="text" name="detalle_permiso" class="form-control" placeholder="Ej: Cita médica especialista EPS, diligencia notarial, calamidad..." required>
                    <span class="form-hint">Especifique claramente la actividad o compromiso a realizar.</span>
                </div>

                <div class="form-group col-4">
                    <label class="form-label">Fecha de Solicitud <span class="req">*</span></label>
                    <input type="date" name="fecha_solicitud" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group col-12">
                    <label class="form-label">Motivo del Permiso <span class="req">*</span></label>
                    <textarea name="motivo_permiso" class="form-control" rows="3" placeholder="Explique las razones y justificación de la solicitud de permiso..." required></textarea>
                </div>

                <!-- Tiempo del Permiso -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    3. Tiempo del Permiso
                </div>

                <div class="form-group col-3">
                    <label class="form-label">Desde (Fecha) <span class="req">*</span></label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="<?= date('Y-m-d') ?>" required onchange="sincronizarFechas()">
                </div>

                <div class="form-group col-3">
                    <label class="form-label">Hasta (Fecha) <span class="req">*</span></label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group col-3">
                    <label class="form-label">Horario: Desde (Hora)</label>
                    <input type="time" name="hora_desde" class="form-control" value="08:00">
                </div>

                <div class="form-group col-3">
                    <label class="form-label">Horario: Hasta (Hora)</label>
                    <input type="time" name="hora_hasta" class="form-control" value="12:00">
                </div>

                <!-- ¿Remunerado? -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    4. ¿El permiso es remunerado?
                </div>

                <div class="form-group col-12">
                    <div class="radio-options-box">
                        <label class="radio-label">
                            <input type="radio" name="es_remunerado" value="si">
                            <strong>Sí</strong> (Remunerado)
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="es_remunerado" value="no" checked>
                            <strong>No</strong> (No Remunerado)
                        </label>
                    </div>
                </div>

                <!-- Firma del Solicitante -->
                <div class="section-separator">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    5. Firma del Solicitante
                </div>

                <div class="form-group col-6">
                    <label class="form-label">Nombre y firma del empleado</label>
                    <input type="text" name="firma_empleado" class="form-control" value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>" required>
                    <span class="form-hint">Al radicar la solicitud declara la veracidad de la información consignada.</span>
                </div>

                <div class="form-group col-6" style="display:flex; justify-content:flex-end; align-items:flex-end; gap:12px;">
                    <?php if ($puedeVerHistorialYFormato): ?>
                    <button type="button" class="btn btn-secondary" onclick="previsualizarBorrador()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Vista Previa Formato
                    </button>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Radicar Solicitud
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($puedeVerHistorialYFormato): ?>
    <!-- ═════════════════════════════════════════════════════════════════
         TAB 2: HISTORIAL DE SOLICITUDES (EXCLUSIVO GESTIÓN HUMANA)
         ═════════════════════════════════════════════════════════════════ -->
    <div class="tab-pane <?= (isset($_GET['tab_historial'])) ? 'active' : '' ?>" id="pane-historial">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Historial de Solicitudes Radicadas
                </div>
                <button type="button" class="btn btn-primary btn-sm" onclick="cambiarTab('solicitar')">
                    + Nuevo Permiso
                </button>
            </div>

            <?php if (empty($listaPermisos)): ?>
                <div style="text-align:center; padding: 40px 20px; color: var(--text-muted);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px; color:#94a3b8;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <p style="font-size:15px; font-weight:600;">No hay solicitudes de permiso registradas.</p>
                    <p style="font-size:13px; margin-top:4px;">Haz clic en "Diligenciar Solicitud" para enviar una nueva.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th># ID</th>
                                <th>Fecha Solicitud</th>
                                <th>Empleado</th>
                                <th>Detalle / Motivo</th>
                                <th>Período</th>
                                <th>Horario</th>
                                <th>Remunerado</th>
                                <th>Jefe Inmediato</th>
                                <th>Recursos Humanos</th>
                                <th style="text-align:right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaPermisos as $p): ?>
                                <tr>
                                    <td><strong>#<?= $p['id'] ?></strong></td>
                                    <td><?= htmlspecialchars($p['fecha_solicitud']) ?></td>
                                    <td>
                                        <div style="font-weight:600;"><?= htmlspecialchars($p['nombre_empleado']) ?></div>
                                        <div style="font-size:11px; color:var(--text-muted);"><?= htmlspecialchars($p['cargo']) ?> · <?= htmlspecialchars($p['departamento_area']) ?></div>
                                    </td>
                                    <td>
                                        <div style="font-weight:500;"><?= htmlspecialchars($p['detalle_permiso']) ?></div>
                                        <div style="font-size:11px; color:var(--text-muted); max-width:240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            <?= htmlspecialchars($p['motivo_permiso']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($p['fecha_desde']) ?>
                                        <?php if ($p['fecha_desde'] !== $p['fecha_hasta']): ?>
                                            <br><span style="font-size:11px; color:var(--text-muted);">al <?= htmlspecialchars($p['fecha_hasta']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($p['hora_desde'] ?: '--') ?> a <?= htmlspecialchars($p['hora_hasta'] ?: '--') ?>
                                    </td>
                                    <td>
                                        <span class="badge-status <?= ($p['es_remunerado'] === 'si') ? 'badge-aprobado' : 'badge-pendiente' ?>">
                                            <?= ($p['es_remunerado'] === 'si') ? 'Sí' : 'No' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($p['estado_jefe'] === 'aprobado'): ?>
                                            <span class="badge-status badge-aprobado">Aprueba</span>
                                        <?php elseif ($p['estado_jefe'] === 'no_aprueba'): ?>
                                            <span class="badge-status badge-rechazado">No Aprueba</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-pendiente">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($p['estado_rh'] === 'registrado' || $p['estado_rh'] === 'recibido'): ?>
                                            <span class="badge-status badge-aprobado"><?= ucfirst($p['estado_rh']) ?></span>
                                        <?php elseif ($p['estado_rh'] === 'rechazado'): ?>
                                            <span class="badge-status badge-rechazado">Rechazado</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-pendiente">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <div class="table-actions" style="justify-content: flex-end;">
                                            <!-- Ver / Imprimir -->
                                            <a href="formatoPermisosControlador.php?ver_id=<?= $p['id'] ?>" class="btn btn-secondary btn-sm" title="Ver Formato Físico">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                                Formato
                                            </a>

                                            <!-- Aprobación Jefe / RH para SuperUsuario y Gestión Humana -->
                                            <?php if ($esSuperUsuario || $esGestionHumana): ?>
                                                <button type="button" class="btn btn-primary btn-sm" onclick='abrirModalGestion(<?= json_encode($p) ?>)' title="Gestionar Aprobación">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                    Aprobar
                                                </button>
                                            <?php endif; ?>

                                            <!-- Eliminar -->
                                            <?php if ($esSuperUsuario || $esGestionHumana || $p['estado_general'] === 'pendiente'): ?>
                                                <form method="POST" action="formatoPermisosControlador.php" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar esta solicitud de permiso?');">
                                                    <input type="hidden" name="accion" value="eliminar_permiso">
                                                    <input type="hidden" name="permiso_id" value="<?= $p['id'] ?>">
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

    <!-- ═════════════════════════════════════════════════════════════════
         TAB 3: VISTA FORMATO FÍSICO OFICIAL (DOCUMENTO IDÉNTICO A IMAGEN 2)
         ═════════════════════════════════════════════════════════════════ -->
    <?php
    // Datos a proyectar en el formato oficial
    $dataPrint = $permisoSeleccionado ?: [
        'id'                => '',
        'codigo_formato'    => 'GTH-05-01',
        'version_formato'   => '1',
        'nombre_empleado'   => $perfil['nombre'] ?? '',
        'cedula'            => $perfil['cedula'] ?? '',
        'cargo'             => $perfil['cargo'] ?? '',
        'departamento_area' => $perfil['area'] ?? '',
        'detalle_permiso'   => '',
        'fecha_solicitud'   => date('Y-m-d'),
        'motivo_permiso'    => '',
        'fecha_desde'       => date('Y-m-d'),
        'fecha_hasta'       => date('Y-m-d'),
        'hora_desde'        => '08:00',
        'hora_hasta'        => '12:00',
        'es_remunerado'     => 'no',
        'estado_jefe'       => 'pendiente',
        'jefe_nombre'       => '',
        'observaciones_jefe'=> '',
        'fecha_firma_jefe'  => '',
        'recibido_por_rh'   => '',
        'fecha_registro_rh' => '',
        'observaciones_rh'  => '',
        'firma_empleado'    => $perfil['nombre'] ?? ''
    ];

    // Funciones auxiliares de formato de fecha
    $fmtFecha = function($fechaStr) {
        if (empty($fechaStr) || $fechaStr === '0000-00-00') return '__ / __ / ____';
        $t = strtotime($fechaStr);
        return date('d / m / Y', $t);
    };
    ?>

    <div class="tab-pane <?= ($permisoSeleccionado) ? 'active' : '' ?>" id="pane-formato-impresion">
        <!-- Barra de herramientas para impresión -->
        <div class="card no-print" style="margin-bottom: 20px; padding: 14px 20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="font-size:14px; font-weight:600; color:var(--text-main); display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Vista Previa del Formato Oficial Físico</span>
                <?php if ($permisoSeleccionado): ?>
                    <span class="badge-status badge-aprobado" style="font-size:11px;">Solicitud #<?= $permisoSeleccionado['id'] ?></span>
                <?php else: ?>
                    <span class="badge-status badge-pendiente" style="font-size:11px;">Formato en Blanco / Borrador</span>
                <?php endif; ?>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFormatoEnBlanco()">
                    Ver Formato en Blanco
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="imprimirFormatoOficial()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Imprimir Formato (PDF)
                </button>
            </div>
        </div>

        <!-- ── HOJA FÍSICA SEGÚN IMAGEN 2 ── -->
        <div class="print-sheet-wrapper" id="hoja-fisica-permiso">

            <!-- Encabezado formal -->
            <table class="official-header-table">
                <tr>
                    <td class="header-logo-box">
                        <img src="../../img/logo.png" alt="INEES">
                        <div class="logo-caption">Electrónica IT Seguridad</div>
                    </td>
                    <td class="header-title-box">
                        <div>GESTIÓN DE TALENTO HUMANO</div>
                        <div>FORMATO DE SOLICITUD DE PERMISO</div>
                    </td>
                    <td class="header-meta-box">
                        <table class="meta-inner-table">
                            <tr>
                                <th>CÓDIGO</th>
                                <td><?= htmlspecialchars($dataPrint['codigo_formato'] ?? 'GTH-05-01') ?></td>
                            </tr>
                            <tr>
                                <th>VERSIÓN</th>
                                <td><?= htmlspecialchars($dataPrint['version_formato'] ?? '1') ?></td>
                            </tr>
                            <tr>
                                <th>FECHA</th>
                                <td>01/09/2025</td>
                            </tr>
                            <tr>
                                <th>PÁGINA</th>
                                <td>1 de 1</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Título central del formato -->
            <div class="official-doc-title">FORMATO DE SOLICITUD DE PERMISO</div>

            <!-- Información del Empleado -->
            <div class="official-section-title">Información del Empleado.</div>

            <div class="official-field-row">
                <span class="official-field-label">Nombre Completo:</span>
                <span class="official-field-line" id="print-nombre"><?= htmlspecialchars($dataPrint['nombre_empleado'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Documento de Identidad:</span>
                <span class="official-field-line" id="print-cedula"><?= htmlspecialchars($dataPrint['cedula'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Cargo:</span>
                <span class="official-field-line" id="print-cargo"><?= htmlspecialchars($dataPrint['cargo'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Departamento/Área:</span>
                <span class="official-field-line" id="print-area"><?= htmlspecialchars($dataPrint['departamento_area'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Detalle del Permiso:</span>
                <span class="official-field-line" id="print-detalle"><?= htmlspecialchars($dataPrint['detalle_permiso'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Fecha de Solicitud:</span>
                <span class="official-field-line" id="print-fecha-solicitud"><?= $fmtFecha($dataPrint['fecha_solicitud'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Motivo del Permiso:</span>
                <span class="official-field-line" id="print-motivo"><?= htmlspecialchars($dataPrint['motivo_permiso'] ?? '') ?></span>
            </div>

            <br>

            <!-- Tiempo del Permiso -->
            <div class="official-section-title">Tiempo del Permiso:</div>

            <div class="official-split-row">
                <div style="flex:1; display:flex; align-items:flex-end;">
                    <span class="official-field-label">Desde</span>
                    <span class="official-field-line" id="print-fecha-desde" style="text-align:center;"><?= $fmtFecha($dataPrint['fecha_desde'] ?? '') ?></span>
                </div>
                <div style="flex:1; display:flex; align-items:flex-end;">
                    <span class="official-field-label">Hasta</span>
                    <span class="official-field-line" id="print-fecha-hasta" style="text-align:center;"><?= $fmtFecha($dataPrint['fecha_hasta'] ?? '') ?></span>
                </div>
            </div>

            <div class="official-split-row">
                <div style="flex:1; display:flex; align-items:flex-end;">
                    <span class="official-field-label">Horario: Desde</span>
                    <span class="official-field-line" id="print-hora-desde" style="text-align:center;"><?= htmlspecialchars($dataPrint['hora_desde'] ?: '______') ?></span>
                </div>
                <div style="flex:1; display:flex; align-items:flex-end;">
                    <span class="official-field-label">Hasta</span>
                    <span class="official-field-line" id="print-hora-hasta" style="text-align:center;"><?= htmlspecialchars($dataPrint['hora_hasta'] ?: '______') ?></span>
                </div>
            </div>

            <div class="official-divider"></div>

            <!-- ¿El permiso es remunerado? -->
            <div class="official-split-row">
                <span class="official-field-label">¿El permiso es remunerado?</span>
                <div class="official-check-group" id="print-check-remunerado">
                    <span><span class="check-square"><?= ($dataPrint['es_remunerado'] === 'si') ? 'X' : '' ?></span> Sí</span>
                    <span><span class="check-square"><?= ($dataPrint['es_remunerado'] === 'no') ? 'X' : '' ?></span> No</span>
                </div>
            </div>

            <!-- Aprobación -->
            <div class="official-section-title" style="margin-top:10px;">Aprobación.</div>

            <div class="official-split-row">
                <span class="official-field-label">Jefe Inmediato:</span>
                <div class="official-check-group">
                    <span><span class="check-square"><?= ($dataPrint['estado_jefe'] === 'aprobado') ? 'X' : '' ?></span> Aprueba</span>
                    <span><span class="check-square"><?= ($dataPrint['estado_jefe'] === 'no_aprueba') ? 'X' : '' ?></span> No Aprueba</span>
                </div>
            </div>

            <div class="official-field-row" style="margin-top:6px;">
                <span class="official-field-label">Observaciones:</span>
                <span class="official-field-line"><?= htmlspecialchars($dataPrint['observaciones_jefe'] ?? '') ?></span>
            </div>

            <div class="official-split-row" style="margin-top:14px;">
                <div style="flex:1.4; display:flex; align-items:flex-end;">
                    <span class="official-field-label">Firma Jefe Inmediato:</span>
                    <span class="official-field-line"><?= htmlspecialchars($dataPrint['jefe_nombre'] ?? '') ?></span>
                </div>
                <div style="flex:0.8; display:flex; align-items:flex-end;">
                    <span class="official-field-label">Fecha:</span>
                    <span class="official-field-line" style="text-align:center;"><?= $fmtFecha($dataPrint['fecha_firma_jefe'] ?? '') ?></span>
                </div>
            </div>

            <br>

            <!-- Recursos Humanos -->
            <div class="official-section-title">Recursos Humanos</div>

            <div class="official-field-row">
                <span class="official-field-label">Recibido por:</span>
                <span class="official-field-line"><?= htmlspecialchars($dataPrint['recibido_por_rh'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Fecha de Registro:</span>
                <span class="official-field-line"><?= $fmtFecha($dataPrint['fecha_registro_rh'] ?? '') ?></span>
            </div>

            <div class="official-field-row">
                <span class="official-field-label">Observaciones:</span>
                <span class="official-field-line"><?= htmlspecialchars($dataPrint['observaciones_rh'] ?? '') ?></span>
            </div>

            <br>

            <!-- Firma del Solicitante -->
            <div class="official-section-title">Firma del Solicitante</div>

            <div class="official-signature-block">
                <div class="official-signature-line">
                    <span style="font-size:12px; font-weight:600; padding-left:10px;"><?= htmlspecialchars($dataPrint['firma_empleado'] ?: $dataPrint['nombre_empleado']) ?></span>
                </div>
                <div class="official-signature-caption">Nombre y firma del empleado</div>
            </div>

        </div>
    </div>
    <?php endif; // Fin sección exclusiva de historial y formato oficial ?>

</main>

<!-- ═════════════════════════════════════════════════════════════════
     MODAL DE APROBACIÓN (SUPERUSUARIO / GESTIÓN HUMANA)
     ═════════════════════════════════════════════════════════════════ -->
<?php if ($esSuperUsuario || $esGestionHumana): ?>
<div class="modal-overlay" id="modal-aprobacion">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="modal-aprobacion-titulo">Gestionar Solicitud de Permiso</div>
            <button type="button" class="modal-close" onclick="cerrarModalGestion()">&times;</button>
        </div>

        <!-- Formulario Aprobación Jefe -->
        <form method="POST" action="formatoPermisosControlador.php" style="margin-bottom: 22px;">
            <input type="hidden" name="accion" value="aprobar_jefe">
            <input type="hidden" name="permiso_id" id="modal-permiso-id-jefe" value="">

            <div style="font-weight:700; font-size:14px; margin-bottom:12px; color:var(--primary-dark);">
                Aprobación - Jefe Inmediato
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label class="form-label">Decisión del Jefe Inmediato</label>
                <div class="radio-options-box">
                    <label class="radio-label">
                        <input type="radio" name="estado_jefe" value="aprobado" id="modal-jefe-aprueba">
                        <strong>Aprueba</strong>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="estado_jefe" value="no_aprueba" id="modal-jefe-no-aprueba">
                        <strong>No Aprueba</strong>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="estado_jefe" value="pendiente" id="modal-jefe-pendiente">
                        Pendiente
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label class="form-label">Nombre de quien firma / aprueba</label>
                <input type="text" name="jefe_nombre" class="form-control" value="<?= htmlspecialchars($perfil['nombre']) ?>" required>
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label class="form-label">Observaciones del Jefe</label>
                <textarea name="observaciones_jefe" id="modal-jefe-observaciones" class="form-control" rows="2" placeholder="Observaciones o condiciones del permiso..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Guardar Aprobación Jefe</button>
        </form>

        <hr style="border:0; border-top:1px solid var(--border-light); margin:18px 0;">

        <!-- Formulario Registro Gestión Humana -->
        <form method="POST" action="formatoPermisosControlador.php">
            <input type="hidden" name="accion" value="gestion_rh">
            <input type="hidden" name="permiso_id" id="modal-permiso-id-rh" value="">

            <div style="font-weight:700; font-size:14px; margin-bottom:12px; color:var(--primary-dark);">
                Recursos Humanos / Talento Humano
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label class="form-label">Estado en RH</label>
                <select name="estado_rh" id="modal-rh-estado" class="form-control">
                    <option value="recibido">Recibido</option>
                    <option value="registrado">Registrado en Sistema</option>
                    <option value="rechazado">Rechazado</option>
                    <option value="pendiente">Pendiente</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label class="form-label">Recibido por (Nombre RH)</label>
                <input type="text" name="recibido_por_rh" class="form-control" value="<?= htmlspecialchars($perfil['nombre']) ?>" required>
            </div>

            <div class="form-group" style="margin-bottom:12px;">
                <label class="form-label">Observaciones de RH</label>
                <textarea name="observaciones_rh" id="modal-rh-observaciones" class="form-control" rows="2" placeholder="Notas internas de Recursos Humanos..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Guardar Registro RH</button>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function cambiarTab(tab) {
    const tabs = ['solicitar', 'historial', 'formato'];
    tabs.forEach(t => {
        const pane = document.getElementById('pane-' + (t === 'formato' ? 'formato-impresion' : t));
        const btn = document.getElementById('tab-btn-' + t);
        if (pane) pane.classList.remove('active');
        if (btn) btn.classList.remove('active');
    });

    const activePane = document.getElementById('pane-' + (tab === 'formato' ? 'formato-impresion' : tab));
    const activeBtn = document.getElementById('tab-btn-' + tab);
    if (activePane) activePane.classList.add('active');
    if (activeBtn) activeBtn.classList.add('active');
}

function sincronizarFechas() {
    const fDesde = document.getElementById('fecha_desde').value;
    const fHasta = document.getElementById('fecha_hasta');
    if (fHasta && (!fHasta.value || fHasta.value < fDesde)) {
        fHasta.value = fDesde;
    }
}

function imprimirFormatoOficial() {
    cambiarTab('formato');
    setTimeout(() => {
        window.print();
    }, 250);
}

function previsualizarBorrador() {
    const printEl = document.getElementById('print-nombre');
    if (!printEl) return;

    const form = document.getElementById('form-solicitud-permiso');
    if (!form) return;

    const fd = new FormData(form);

    document.getElementById('print-nombre').textContent = fd.get('nombre_empleado') || '';
    document.getElementById('print-cedula').textContent = fd.get('cedula') || '';
    document.getElementById('print-cargo').textContent = fd.get('cargo') || '';
    document.getElementById('print-area').textContent = fd.get('departamento_area') || '';
    document.getElementById('print-detalle').textContent = fd.get('detalle_permiso') || '';
    document.getElementById('print-motivo').textContent = fd.get('motivo_permiso') || '';

    const fmt = (d) => {
        if (!d) return '__ / __ / ____';
        const parts = d.split('-');
        return parts.length === 3 ? `${parts[2]} / ${parts[1]} / ${parts[0]}` : d;
    };

    if (document.getElementById('print-fecha-solicitud')) document.getElementById('print-fecha-solicitud').textContent = fmt(fd.get('fecha_solicitud'));
    if (document.getElementById('print-fecha-desde')) document.getElementById('print-fecha-desde').textContent = fmt(fd.get('fecha_desde'));
    if (document.getElementById('print-fecha-hasta')) document.getElementById('print-fecha-hasta').textContent = fmt(fd.get('fecha_hasta'));
    if (document.getElementById('print-hora-desde')) document.getElementById('print-hora-desde').textContent = fd.get('hora_desde') || '______';
    if (document.getElementById('print-hora-hasta')) document.getElementById('print-hora-hasta').textContent = fd.get('hora_hasta') || '______';

    const esRem = fd.get('es_remunerado') === 'si';
    const checkRem = document.getElementById('print-check-remunerado');
    if (checkRem) {
        checkRem.innerHTML = `
            <span><span class="check-square">${esRem ? 'X' : ''}</span> Sí</span>
            <span><span class="check-square">${!esRem ? 'X' : ''}</span> No</span>
        `;
    }

    cambiarTab('formato');
}

function limpiarFormatoEnBlanco() {
    const printEl = document.getElementById('print-nombre');
    if (!printEl) return;
    document.getElementById('print-nombre').textContent = '';
    document.getElementById('print-cedula').textContent = '';
    document.getElementById('print-cargo').textContent = '';
    document.getElementById('print-area').textContent = '';
    document.getElementById('print-detalle').textContent = '';
    document.getElementById('print-motivo').textContent = '';
    if (document.getElementById('print-fecha-solicitud')) document.getElementById('print-fecha-solicitud').textContent = '__ / __ / ____';
    if (document.getElementById('print-fecha-desde')) document.getElementById('print-fecha-desde').textContent = '__ / __ / ____';
    if (document.getElementById('print-fecha-hasta')) document.getElementById('print-fecha-hasta').textContent = '__ / __ / ____';
    if (document.getElementById('print-hora-desde')) document.getElementById('print-hora-desde').textContent = '______';
    if (document.getElementById('print-hora-hasta')) document.getElementById('print-hora-hasta').textContent = '______';
    const checkRem = document.getElementById('print-check-remunerado');
    if (checkRem) {
        checkRem.innerHTML = `
            <span><span class="check-square">&nbsp;</span> Sí</span>
            <span><span class="check-square">&nbsp;</span> No</span>
        `;
    }
    cambiarTab('formato');
}

function abrirModalGestion(permiso) {
    document.getElementById('modal-aprobacion-titulo').textContent = `Gestionar Solicitud de Permiso #${permiso.id} (${permiso.nombre_empleado})`;
    document.getElementById('modal-permiso-id-jefe').value = permiso.id;
    document.getElementById('modal-permiso-id-rh').value = permiso.id;

    if (permiso.estado_jefe === 'aprobado') {
        document.getElementById('modal-jefe-aprueba').checked = true;
    } else if (permiso.estado_jefe === 'no_aprueba') {
        document.getElementById('modal-jefe-no-aprueba').checked = true;
    } else {
        document.getElementById('modal-jefe-pendiente').checked = true;
    }

    document.getElementById('modal-jefe-observaciones').value = permiso.observaciones_jefe || '';
    document.getElementById('modal-rh-estado').value = permiso.estado_rh || 'recibido';
    document.getElementById('modal-rh-observaciones').value = permiso.observaciones_rh || '';

    document.getElementById('modal-aprobacion').classList.add('active');
}

function cerrarModalGestion() {
    document.getElementById('modal-aprobacion').classList.remove('active');
}
</script>

</body>
</html>
