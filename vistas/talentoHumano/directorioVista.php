<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">`r`n    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title>Directorio de Empleados — Portal INEES</title>
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
            --whatsapp-green:#25D366;
            --whatsapp-hover:#128C7E;
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
        .directorio-hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #083344 100%);
            border-radius: var(--radius-lg);
            padding: 30px 34px;
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

        .directorio-hero::after {
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

        /* ── Controles de Filtro y Búsqueda ── */
        .controls-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 20px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .search-box-wrapper {
            position: relative;
            flex: 1;
            min-width: 260px;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            background: #f8fafc;
            color: var(--text-main);
            transition: all .2s;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(13,148,136,.15);
        }

        .filters-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .select-filter {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13px;
            background: #ffffff;
            color: var(--text-main);
            cursor: pointer;
            transition: border-color .2s;
        }
        .select-filter:focus {
            outline: none;
            border-color: var(--primary);
        }

        .view-toggle-group {
            display: flex;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            background: #f8fafc;
        }

        .view-toggle-btn {
            background: transparent;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all .2s;
        }
        .view-toggle-btn.active {
            background: var(--primary);
            color: #ffffff;
        }

        /* ── Barra de Contador ── */
        .results-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding: 0 4px;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ── VISTA CUADRÍCULA (CARDS) ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 20px;
        }

        .employee-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            transition: transform .2s, box-shadow .2s, border-color .2s;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .employee-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
        }

        .card-top {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
        }

        .avatar-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #0284c7);
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 8px rgba(13,148,136,.25);
        }

        .card-header-info {
            flex: 1;
            min-width: 0;
        }

        .employee-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 3px;
            line-height: 1.25;
            word-break: break-word;
        }

        .employee-cargo {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .badge-area {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-transform: capitalize;
        }

        .card-details-list {
            margin: 12px 0 16px;
            padding-top: 12px;
            border-top: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 13px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
        }
        .detail-row svg {
            color: #94a3b8;
            flex-shrink: 0;
        }
        .detail-label {
            font-weight: 600;
            color: #475569;
            min-width: 65px;
            font-size: 12px;
        }
        .detail-value {
            color: var(--text-main);
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .detail-value a {
            color: var(--primary);
            text-decoration: none;
        }
        .detail-value a:hover {
            text-decoration: underline;
        }

        .badge-usuario {
            background: #f0fdfa;
            color: var(--primary-dark);
            border: 1px solid #ccfbf1;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11.5px;
            font-family: monospace;
            font-weight: 600;
        }

        /* ── Botones de Acción de Tarjeta ── */
        .card-actions {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-whatsapp {
            flex: 1;
            background: var(--whatsapp-green);
            color: #ffffff;
            border: none;
            padding: 9px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(37,211,102,.25);
        }
        .btn-whatsapp:hover {
            background: var(--whatsapp-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(37,211,102,.35);
        }

        .btn-whatsapp.disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
            pointer-events: none;
        }

        .btn-email-icon {
            background: #f8fafc;
            border: 1px solid var(--border);
            color: var(--text-muted);
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all .2s;
            flex-shrink: 0;
        }
        .btn-email-icon:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        /* ── VISTA TABLA ── */
        .table-view-container {
            display: none;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .directorio-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }
        .directorio-table th {
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .directorio-table td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }
        .directorio-table tr:hover td {
            background: #f8fafc;
        }

        .table-user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .table-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #0284c7);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            border: 1.5px solid #ffffff;
            box-shadow: 0 1px 4px rgba(0,0,0,.1);
        }

        .btn-wa-table {
            background: var(--whatsapp-green);
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background .2s;
            white-space: nowrap;
        }
        .btn-wa-table:hover {
            background: var(--whatsapp-hover);
        }
        .btn-wa-table.disabled {
            background: #f1f5f9;
            color: #94a3b8;
            pointer-events: none;
        }

        .badge-status-dot {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-status-dot::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .status-activo::before { background: #22c55e; }
        .status-inactivo::before { background: #94a3b8; }

        /* ── Empty State ── */
        .empty-results {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 48px 24px;
            text-align: center;
            color: var(--text-muted);
            display: none;
        }

        /* ── CRUD Superusuario ── */
        .btn-nuevo-usuario {
            background: linear-gradient(135deg, #0d9488, #0b7a70);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-nuevo-usuario:hover {
            background: linear-gradient(135deg, #0b7a70, #096056);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13,148,136,.35);
        }

        .btn-accion-card {
            background: #f8fafc;
            border: 1px solid var(--border);
            color: var(--text-muted);
            width: 34px; height: 34px;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            flex-shrink: 0;
        }
        .btn-accion-card:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
        .btn-accion-card.danger:hover { border-color: #ef4444; color: #ef4444; background: #fef2f2; }

        /* ── Modal Base ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(10,20,40,.55);
            backdrop-filter: blur(3px);
            z-index: 1000;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            opacity: 0; pointer-events: none;
            transition: opacity .25s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }

        .modal-box {
            background: #fff;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 680px;
            max-height: 92vh;
            overflow-y: auto;
            box-shadow: 0 20px 50px -5px rgba(10,20,40,.35);
            transform: translateY(10px);
            transition: transform .25s;
            padding: 0;
        }
        .modal-overlay.open .modal-box { transform: translateY(0); }

        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border-light);
            background: linear-gradient(90deg, rgba(13,148,136,.06) 0%, transparent 100%);
            position: sticky; top: 0; background: #fff; z-index: 1;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }
        .modal-title {
            font-size: 16px; font-weight: 700; color: var(--text-main);
            display: flex; align-items: center; gap: 10px;
        }
        .modal-close {
            background: #f1f5f9; border: none; border-radius: 8px;
            width: 32px; height: 32px; cursor: pointer; color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; transition: all .2s; line-height: 1;
        }
        .modal-close:hover { background: #fee2e2; color: #ef4444; }

        .modal-body { padding: 22px 24px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .form-grid .span2 { grid-column: span 2; }

        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-label { font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .4px; }
        .form-input, .form-select {
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            color: var(--text-main);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,.15);
        }
        .form-hint { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        .form-section-title {
            font-size: 11.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .5px; color: var(--primary-dark);
            padding-bottom: 8px; border-bottom: 1px solid var(--border-light);
            margin: 4px 0 4px; grid-column: span 2;
        }

        /* Avatar en modal */
        .modal-avatar-zone {
            display: flex; align-items: center; gap: 16px;
            padding: 14px 16px;
            background: #f8fafc;
            border-radius: var(--radius-md);
            border: 1px dashed var(--border);
            cursor: pointer;
            transition: border-color .2s, background .2s;
            grid-column: span 2;
        }
        .modal-avatar-zone:hover { border-color: var(--primary); background: var(--primary-light); }
        .modal-avatar-preview {
            width: 64px; height: 64px; border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #0284c7);
            color: #fff; font-size: 22px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .modal-avatar-preview img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .modal-avatar-info { flex: 1; }
        .modal-avatar-title { font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 2px; }
        .modal-avatar-hint { font-size: 12px; color: var(--text-muted); }

        .modal-footer {
            display: flex; gap: 10px; justify-content: flex-end;
            padding: 16px 24px 20px;
            border-top: 1px solid var(--border-light);
        }
        .btn-cancelar {
            background: #f1f5f9; color: var(--text-muted); border: 1px solid var(--border);
            padding: 9px 20px; border-radius: var(--radius-sm); font-size: 13px;
            font-weight: 600; cursor: pointer; transition: all .2s;
        }
        .btn-cancelar:hover { background: #e2e8f0; }
        .btn-guardar {
            background: linear-gradient(135deg, #0d9488, #0b7a70);
            color: #fff; border: none; padding: 9px 24px;
            border-radius: var(--radius-sm); font-size: 13px; font-weight: 700;
            cursor: pointer; transition: all .2s; display: flex; align-items: center; gap: 7px;
        }
        .btn-guardar:hover { background: linear-gradient(135deg, #0b7a70, #096056); transform: translateY(-1px); }
        .btn-guardar:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        /* Toast */
        #dir-toast {
            position: fixed; bottom: 24px; right: 24px;
            background: #0f172a; color: #fff;
            border-radius: 10px; padding: 12px 18px;
            font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,.35); z-index: 9999;
            opacity: 0; transform: translateY(10px);
            transition: opacity .3s, transform .3s; pointer-events: none;
        }
        #dir-toast.show { opacity: 1; transform: translateY(0); }

        /* Badge estado en tarjeta */
        .card-estado-badge {
            position: absolute; top: 12px; right: 12px;
            font-size: 10px; font-weight: 700; padding: 2px 8px;
            border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;
        }
        .estado-activo { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .estado-inactivo { background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0; }

        /* Avatar en tarjeta con foto real */
        .avatar-circle img { width:100%; height:100%; object-fit:cover; object-position:center; border-radius:50%; display:block; }
        .table-avatar img { width:100%; height:100%; object-fit:cover; object-position:center; border-radius:50%; display:block; }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .span2 { grid-column: span 1; }
            .form-section-title { grid-column: span 1; }
            .modal-avatar-zone { grid-column: span 1; }
        }
    </style>
</head>
<body>

<?php
// Inclusión de Navbar y Sidebar del portal
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
        <span>Directorio de Empleados</span>
    </nav>

    <!-- Hero Banner -->
    <div class="directorio-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="hero-title">
                <h1>Directorio de Empleados</h1>
                <p>Contacto del equipo INEES: áreas, correos corporativos y mensajería directa por WhatsApp.</p>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                <span>Total: <strong><?= $datosStats['total'] ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                <span>Activos: <strong><?= $datosStats['activos'] ?></strong></span>
            </div>
            <div class="hero-stat-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:#25D366;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>Con WhatsApp: <strong><?= $datosStats['con_celular'] ?></strong></span>
            </div>
            <?php if ($esSuperUsuario): ?>
            <button type="button" class="btn-nuevo-usuario" onclick="abrirModalCrear()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nuevo Usuario
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Controles de Búsqueda y Filtros -->
    <div class="controls-card">
        <div class="search-box-wrapper">
            <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="filtro-busqueda" class="search-input" placeholder="Buscar por nombre, cédula, cargo, usuario o correo..." oninput="filtrarColaboradores()">
        </div>

        <div class="filters-group">
            <!-- Filtro por Área -->
            <select id="filtro-area" class="select-filter" onchange="filtrarColaboradores()">
                <option value="todas">Todas las áreas (<?= $datosStats['total'] ?>)</option>
                <?php foreach ($datosStats['areas'] as $a): ?>
                    <option value="<?= htmlspecialchars(strtolower($a['area_nombre'])) ?>">
                        <?= htmlspecialchars(ucfirst($a['area_nombre'])) ?> (<?= $a['cantidad'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Filtro por Estado -->
            <select id="filtro-estado" class="select-filter" onchange="filtrarColaboradores()">
                <option value="todos">Todos los estados</option>
                <option value="activo" selected>Solo Activos</option>
                <option value="inactivo">Inactivos</option>
            </select>

            <!-- Selector de Vista: Tarjetas / Tabla -->
            <div class="view-toggle-group">
                <button type="button" class="view-toggle-btn active" id="btn-vista-cards" onclick="alternarVista('cards')" title="Vista Tarjetas">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Tarjetas
                </button>
                <button type="button" class="view-toggle-btn" id="btn-vista-tabla" onclick="alternarVista('tabla')" title="Vista Tabla">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    Tabla
                </button>
            </div>
        </div>
    </div>

    <!-- Barra de Conteo de Resultados -->
    <div class="results-summary">
        <div>Mostrando <strong id="contador-mostrados"><?= count($empleados) ?></strong> colaboradores</div>
        <div style="font-size:12px;">Haz clic en WhatsApp para iniciar conversación instantánea.</div>
    </div>

    <!-- ═════════════════════════════════════════════════════════════════
         VISTA 1: TARJETAS (CARDS GRID)
         ═════════════════════════════════════════════════════════════════ -->
    <div class="cards-grid" id="contenedor-cards">
        <?php foreach ($empleados as $emp): 
            $nombre      = trim($emp['nombre'] ?? '');
            $iniciales   = mb_strtoupper(mb_substr($nombre, 0, 1));
            $areaNombre  = !empty(trim($emp['area'] ?? '')) ? trim($emp['area']) : 'Sin área';
            $cedula      = !empty(trim($emp['cedula'] ?? '')) ? trim($emp['cedula']) : 'No registra';
            $usuarioSys  = !empty(trim($emp['usuario'] ?? '')) ? trim($emp['usuario']) : 'sin_usuario';
            $email       = !empty(trim($emp['email'] ?? '')) ? trim($emp['email']) : '';
            $celularRaw  = trim($emp['celular'] ?? '');
            $cargo       = !empty(trim($emp['cargo'] ?? '')) ? trim($emp['cargo']) : 'Colaborador';
            $estado      = strtolower($emp['estado'] ?? 'activo');
            $fotoEmp     = $emp['foto_perfil'] ?? null;
            $numWa       = DirectorioModelo::limpiarNumeroWhatsApp($celularRaw);
            $msgWa       = rawurlencode("Hola " . $nombre . ", te contacto desde el Portal INEES.");
            $linkWa      = $numWa ? "https://wa.me/{$numWa}?text={$msgWa}" : '#';
        ?>
            <div class="employee-card"
                 data-nombre="<?= htmlspecialchars(strtolower($nombre)) ?>"
                 data-cedula="<?= htmlspecialchars(strtolower($cedula)) ?>"
                 data-cargo="<?= htmlspecialchars(strtolower($cargo)) ?>"
                 data-usuario="<?= htmlspecialchars(strtolower($usuarioSys)) ?>"
                 data-email="<?= htmlspecialchars(strtolower($email)) ?>"
                 data-area="<?= htmlspecialchars(strtolower($areaNombre)) ?>"
                 data-estado="<?= $estado ?>">
                
                <span class="card-estado-badge estado-<?= $estado ?>">
                    <?= $estado === 'activo' ? '● Activo' : '○ Inactivo' ?>
                </span>

                <div class="card-top">
                    <div class="avatar-circle">
                        <?php if (!empty($fotoEmp)): ?>
                            <img src="../../<?= htmlspecialchars($fotoEmp) ?>?v=<?= time() ?>" alt="<?= htmlspecialchars($nombre) ?>">
                        <?php else: ?>
                            <?= $iniciales ?>
                        <?php endif; ?>
                    </div>
                    <div class="card-header-info">
                        <div class="employee-name"><?= htmlspecialchars($nombre) ?></div>
                        <div class="employee-cargo"><?= htmlspecialchars($cargo) ?></div>
                        <span class="badge-area"><?= htmlspecialchars($areaNombre) ?></span>
                    </div>
                </div>

                <div class="card-details-list">
                    <!-- Cédula -->
                    <div class="detail-row">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span class="detail-label">Cédula:</span>
                        <span class="detail-value"><?= htmlspecialchars($cedula) ?></span>
                    </div>

                    <!-- Usuario -->
                    <div class="detail-row">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="detail-label">Usuario:</span>
                        <span class="detail-value">
                            <span class="badge-usuario">@<?= htmlspecialchars($usuarioSys) ?></span>
                        </span>
                    </div>

                    <!-- Email -->
                    <div class="detail-row">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">
                            <?php if (!empty($email)): ?>
                                <a href="mailto:<?= htmlspecialchars($email) ?>" title="Enviar correo"><?= htmlspecialchars($email) ?></a>
                            <?php else: ?>
                                <span style="color:#94a3b8;">No registra</span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <!-- Celular -->
                    <div class="detail-row">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span class="detail-label">Celular:</span>
                        <span class="detail-value"><?= !empty($celularRaw) ? htmlspecialchars($celularRaw) : '<span style="color:#94a3b8;">No registra</span>' ?></span>
                    </div>
                </div>

                <!-- Botones de Acción: WhatsApp & Email & CRUD -->
                <div class="card-actions">
                    <?php if (!empty($numWa)): ?>
                        <a href="<?= $linkWa ?>" target="_blank" rel="noopener noreferrer" class="btn-whatsapp" title="Abrir chat de WhatsApp con <?= htmlspecialchars($nombre) ?>">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.392-10.416c-4.28 0-7.767 3.487-7.768 7.768 0 1.365.355 2.699 1.029 3.869l-1.095 4.004 4.104-1.077c1.127.616 2.404.943 3.727.943 4.282 0 7.769-3.486 7.77-7.768 0-4.28-3.487-7.769-7.767-7.769zm0 14.115c-1.174 0-2.32-.315-3.32-.912l-.238-.142-2.469.648.659-2.407-.156-.248c-.657-1.045-1.004-2.253-1.004-3.491 0-3.522 2.866-6.388 6.389-6.388 3.521 0 6.387 2.866 6.388 6.388 0 3.523-2.866 6.389-6.389 6.389z"/>
                            </svg>
                            WhatsApp
                        </a>
                    <?php else: ?>
                        <span class="btn-whatsapp disabled" title="Colaborador sin celular registrado">
                            Sin WhatsApp
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($email)): ?>
                        <a href="mailto:<?= htmlspecialchars($email) ?>" class="btn-email-icon" title="Enviar correo a <?= htmlspecialchars($email) ?>">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </a>
                    <?php endif; ?>

                    <?php if ($esSuperUsuario): ?>
                        <button type="button" class="btn-accion-card" title="Editar usuario"
                                onclick="abrirModalEditar(<?= (int)$emp['usuario_id'] ?>)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        <button type="button" class="btn-accion-card <?= $estado === 'activo' ? 'danger' : '' ?>"
                                title="<?= $estado === 'activo' ? 'Desactivar cuenta' : 'Activar cuenta' ?>"
                                onclick="cambiarEstado(<?= (int)$emp['usuario_id'] ?>, '<?= $estado === 'activo' ? 'inactivo' : 'activo' ?>')">
                            <?php if ($estado === 'activo'): ?>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                            </svg>
                            <?php else: ?>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- ═════════════════════════════════════════════════════════════════
         VISTA 2: TABLA COMPACTA
         ═════════════════════════════════════════════════════════════════ -->
    <div class="table-view-container" id="contenedor-tabla">
        <div style="overflow-x:auto;">
            <table class="directorio-table">
                <thead>
                    <tr>
                        <th>Colaborador</th>
                        <th>Área</th>
                        <th>Cédula</th>
                        <th>Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Celular</th>
                        <th>WhatsApp</th>
                        <th>Estado</th>
                        <?php if ($esSuperUsuario): ?><th>Acciones</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $emp): 
                        $nombre      = trim($emp['nombre'] ?? '');
                        $iniciales   = mb_strtoupper(mb_substr($nombre, 0, 1));
                        $areaNombre  = !empty(trim($emp['area'] ?? '')) ? trim($emp['area']) : 'Sin área';
                        $cedula      = !empty(trim($emp['cedula'] ?? '')) ? trim($emp['cedula']) : 'No registra';
                        $usuarioSys  = !empty(trim($emp['usuario'] ?? '')) ? trim($emp['usuario']) : 'sin_usuario';
                        $email       = !empty(trim($emp['email'] ?? '')) ? trim($emp['email']) : '';
                        $celularRaw  = trim($emp['celular'] ?? '');
                        $cargo       = !empty(trim($emp['cargo'] ?? '')) ? trim($emp['cargo']) : 'Colaborador';
                        $estado      = strtolower($emp['estado'] ?? 'activo');
                        $fotoEmp     = $emp['foto_perfil'] ?? null;
                        $numWa       = DirectorioModelo::limpiarNumeroWhatsApp($celularRaw);
                        $msgWa       = rawurlencode("Hola " . $nombre . ", te contacto desde el Portal INEES.");
                        $linkWa      = $numWa ? "https://wa.me/{$numWa}?text={$msgWa}" : '#';
                    ?>
                        <tr class="table-row-item"
                            data-nombre="<?= htmlspecialchars(strtolower($nombre)) ?>"
                            data-cedula="<?= htmlspecialchars(strtolower($cedula)) ?>"
                            data-cargo="<?= htmlspecialchars(strtolower($cargo)) ?>"
                            data-usuario="<?= htmlspecialchars(strtolower($usuarioSys)) ?>"
                            data-email="<?= htmlspecialchars(strtolower($email)) ?>"
                            data-area="<?= htmlspecialchars(strtolower($areaNombre)) ?>"
                            data-estado="<?= $estado ?>">
                            <td>
                                <div class="table-user-cell">
                                    <div class="table-avatar">
                                        <?php if (!empty($fotoEmp)): ?>
                                            <img src="../../<?= htmlspecialchars($fotoEmp) ?>?v=<?= time() ?>" alt="<?= htmlspecialchars($nombre) ?>">
                                        <?php else: ?>
                                            <?= $iniciales ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div style="font-weight:700; color:var(--text-main);"><?= htmlspecialchars($nombre) ?></div>
                                        <div style="font-size:11px; color:var(--text-muted);"><?= htmlspecialchars($cargo) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-area"><?= htmlspecialchars($areaNombre) ?></span>
                            </td>
                            <td>
                                <span style="font-weight:500; font-family:monospace;"><?= htmlspecialchars($cedula) ?></span>
                            </td>
                            <td>
                                <span class="badge-usuario">@<?= htmlspecialchars($usuarioSys) ?></span>
                            </td>
                            <td>
                                <?php if (!empty($email)): ?>
                                    <a href="mailto:<?= htmlspecialchars($email) ?>" style="color:var(--primary); text-decoration:none;"><?= htmlspecialchars($email) ?></a>
                                <?php else: ?>
                                    <span style="color:#94a3b8;">--</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= !empty($celularRaw) ? htmlspecialchars($celularRaw) : '<span style="color:#94a3b8;">--</span>' ?>
                            </td>
                            <td>
                                <?php if (!empty($numWa)): ?>
                                    <a href="<?= $linkWa ?>" target="_blank" rel="noopener noreferrer" class="btn-wa-table">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.392-10.416c-4.28 0-7.767 3.487-7.768 7.768 0 1.365.355 2.699 1.029 3.869l-1.095 4.004 4.104-1.077c1.127.616 2.404.943 3.727.943 4.282 0 7.769-3.486 7.77-7.768 0-4.28-3.487-7.769-7.767-7.769zm0 14.115c-1.174 0-2.32-.315-3.32-.912l-.238-.142-2.469.648.659-2.407-.156-.248c-.657-1.045-1.004-2.253-1.004-3.491 0-3.522 2.866-6.388 6.389-6.388 3.521 0 6.387 2.866 6.388 6.388 0 3.523-2.866 6.389-6.389 6.389z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                <?php else: ?>
                                    <span class="btn-wa-table disabled">Sin número</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge-status-dot status-<?= $estado ?>">
                                    <?= ucfirst($estado) ?>
                                </span>
                            </td>
                            <?php if ($esSuperUsuario): ?>
                            <td>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="btn-accion-card" onclick="abrirModalEditar(<?= (int)$emp['usuario_id'] ?>)" title="Editar">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-accion-card <?= $estado==='activo'?'danger':'' ?>"
                                            onclick="cambiarEstado(<?= (int)$emp['usuario_id'] ?>,'<?= $estado==='activo'?'inactivo':'activo' ?>')"
                                            title="<?= $estado==='activo'?'Desactivar':'Activar' ?>">
                                        <?php if ($estado==='activo'): ?>
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                                        </svg>
                                        <?php else: ?>
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                        <?php endif; ?>
                                    </button>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Empty State -->
    <div class="empty-results" id="empty-state">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px; color:#94a3b8;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <div style="font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:4px;">No se encontraron colaboradores</div>
        <p style="font-size:13px; color:var(--text-muted);">Intenta ajustar los términos de búsqueda o cambiar los filtros seleccionados.</p>
    </div>

    <!-- Toast de Notificaciones -->
    <div id="dir-toast">
        <span id="dir-toast-icon">✓</span>
        <span id="dir-toast-msg">Operación completada</span>
    </div>

    <?php if ($esSuperUsuario): ?>
    <!-- ═══ MODAL: CREAR / EDITAR USUARIO ═══ -->
    <div class="modal-overlay" id="modalUsuario">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title" id="modalTitulo">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Nuevo Usuario</span>
                </div>
                <button type="button" class="modal-close" onclick="cerrarModal('modalUsuario')">✕</button>
            </div>
            <div class="modal-body">
                <form id="formUsuario" enctype="multipart/form-data">
                    <input type="hidden" name="accion" id="formAccion" value="crear">
                    <input type="hidden" name="usuario_id" id="formUsuarioId" value="">

                    <div class="form-grid">
                        <!-- Foto -->
                        <div class="modal-avatar-zone" onclick="document.getElementById('modalFotoInput').click()">
                            <div class="modal-avatar-preview" id="modalAvatarPreview">
                                <span id="modalAvatarInitial">?</span>
                            </div>
                            <div class="modal-avatar-info">
                                <div class="modal-avatar-title">📷 Foto de Perfil</div>
                                <div class="modal-avatar-hint">Haz clic para seleccionar foto (JPG, PNG o WEBP · Máx. 3 MB)</div>
                            </div>
                            <input type="file" id="modalFotoInput" name="foto" accept="image/jpeg,image/png,image/webp"
                                   style="display:none;" onchange="previsualizarFoto(this)">
                        </div>

                        <!-- Sección: Datos Personales -->
                        <div class="form-section-title">👤 Datos Personales</div>

                        <div class="form-group span2">
                            <label class="form-label">Nombre Completo *</label>
                            <input type="text" name="nombre" id="f_nombre" class="form-input" placeholder="Nombre completo del colaborador" required oninput="actualizarInicialModal()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cédula</label>
                            <input type="text" name="cedula" id="f_cedula" class="form-input" placeholder="Número de cédula">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cargo</label>
                            <input type="text" name="cargo" id="f_cargo" class="form-input" placeholder="Cargo o puesto">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Área / Depto.</label>
                            <input type="text" name="area" id="f_area" class="form-input" placeholder="Área o departamento" list="listaAreas">
                            <datalist id="listaAreas">
                                <?php foreach ($directorioModelo->obtenerAreas() as $a): ?>
                                    <option value="<?= htmlspecialchars($a) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="f_email" class="form-input" placeholder="correo@ejemplo.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Celular</label>
                            <input type="text" name="celular" id="f_celular" class="form-input" placeholder="3XX XXX XXXX">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Teléfono Corporativo</label>
                            <input type="text" name="telefono_corporativo" id="f_tel_corp" class="form-input" placeholder="Ext. o línea fija">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Teléfono Emergencia</label>
                            <input type="text" name="telefono_emergencia" id="f_tel_emerg" class="form-input" placeholder="Contacto de emergencia">
                        </div>

                        <!-- Sección: Acceso al Sistema -->
                        <div class="form-section-title">🔐 Acceso al Sistema</div>

                        <div class="form-group">
                            <label class="form-label">Usuario (login) *</label>
                            <input type="text" name="usuario" id="f_usuario" class="form-input" placeholder="Nombre de usuario único" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label" id="f_pwd_label">Contraseña *</label>
                            <input type="password" name="password" id="f_password" class="form-input" placeholder="••••••••" autocomplete="new-password">
                            <span class="form-hint" id="f_pwd_hint">Mínimo 6 caracteres</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rol del Sistema</label>
                            <select name="nivel_acceso" id="f_nivel" class="form-select">
                                <?php foreach ($directorioModelo->obtenerRoles() as $rol): ?>
                                    <option value="<?= (int)$rol['idTipoUsuario'] ?>">
                                        <?= htmlspecialchars($rol['nombreTipoUsuario']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Estado de la Cuenta</label>
                            <select name="estado" id="f_estado" class="form-select">
                                <option value="activo">✅ Activo</option>
                                <option value="inactivo">⛔ Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" onclick="cerrarModal('modalUsuario')">Cancelar</button>
                <button type="button" class="btn-guardar" id="btnGuardar" onclick="guardarUsuario()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    <span id="btnGuardarTxt">Crear Usuario</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

</main>

<script>
/* ════════════════════════════════════════════
   FILTRADO Y ALTERNANCIA DE VISTA
   ════════════════════════════════════════════ */
function filtrarColaboradores() {
    const busq   = document.getElementById('filtro-busqueda').value.toLowerCase().trim();
    const area   = document.getElementById('filtro-area').value.toLowerCase();
    const estado = document.getElementById('filtro-estado').value.toLowerCase();
    const cards  = document.querySelectorAll('.employee-card');
    const rows   = document.querySelectorAll('.table-row-item');
    let count = 0;

    function coincide(el) {
        const txt  = !busq || ['nombre','cedula','cargo','usuario','email'].some(k => (el.dataset[k]||'').includes(busq));
        const areaOk   = area   === 'todas' || (el.dataset.area||'')   === area;
        const estadoOk = estado === 'todos' || (el.dataset.estado||'') === estado;
        return txt && areaOk && estadoOk;
    }

    cards.forEach(c => { const v = coincide(c); c.style.display = v ? 'flex' : 'none'; if(v) count++; });
    rows.forEach(r  => { r.style.display = coincide(r) ? '' : 'none'; });

    document.getElementById('contador-mostrados').textContent = count;
    document.getElementById('empty-state').style.display = count === 0 ? 'block' : 'none';
}

function alternarVista(modo) {
    const btnCards = document.getElementById('btn-vista-cards');
    const btnTabla = document.getElementById('btn-vista-tabla');
    const grid     = document.getElementById('contenedor-cards');
    const tabla    = document.getElementById('contenedor-tabla');
    if (modo === 'tabla') {
        grid.style.display = 'none'; tabla.style.display = 'block';
        btnCards.classList.remove('active'); btnTabla.classList.add('active');
    } else {
        grid.style.display = 'grid'; tabla.style.display = 'none';
        btnCards.classList.add('active'); btnTabla.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', () => filtrarColaboradores());

/* ════════════════════════════════════════════
   TOAST
   ════════════════════════════════════════════ */
function toast(msg, ok = true) {
    const t = document.getElementById('dir-toast');
    if (!t) return;
    document.getElementById('dir-toast-icon').textContent = ok ? '✓' : '✕';
    document.getElementById('dir-toast-msg').textContent  = msg;
    t.style.borderLeft = ok ? '4px solid #10b981' : '4px solid #ef4444';
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 3500);
}

/* ════════════════════════════════════════════
   MODALES
   ════════════════════════════════════════════ */
function abrirModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function cerrarModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('open');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', e => { if (e.target === o) cerrarModal(o.id); });
});

/* ════════════════════════════════════════════
   CRUD — CREAR
   ════════════════════════════════════════════ */
function resetFormUsuario() {
    const form = document.getElementById('formUsuario');
    if (!form) return;
    form.reset();
    document.getElementById('formAccion').value    = 'crear';
    document.getElementById('formUsuarioId').value = '';
    const titulo = document.getElementById('modalTitulo');
    if (titulo && titulo.querySelector('span')) {
        titulo.querySelector('span').textContent = 'Nuevo Usuario';
    }
    document.getElementById('btnGuardarTxt').textContent = 'Crear Usuario';
    document.getElementById('f_pwd_label').textContent   = 'Contraseña *';
    document.getElementById('f_pwd_hint').textContent    = 'Mínimo 6 caracteres';
    document.getElementById('f_password').required       = true;
    
    // Resetear preview avatar
    const prev = document.getElementById('modalAvatarPreview');
    if (prev) {
        prev.innerHTML = '<span id="modalAvatarInitial">?</span>';
    }
}

function actualizarInicialModal() {
    const nombre = (document.getElementById('f_nombre').value || '').trim();
    const init   = document.getElementById('modalAvatarInitial');
    if (init) init.textContent = nombre ? nombre[0].toUpperCase() : '?';
}

function previsualizarFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const prev = document.getElementById('modalAvatarPreview');
        prev.innerHTML = `<img src="${e.target.result}" alt="foto">`;
    };
    reader.readAsDataURL(input.files[0]);
}

function abrirModalCrear() {
    resetFormUsuario();
    abrirModal('modalUsuario');
}

/* ════════════════════════════════════════════
   CRUD — EDITAR (carga datos vía AJAX)
   ════════════════════════════════════════════ */
function abrirModalEditar(id) {
    resetFormUsuario();
    fetch(`../../controladores/talentoHumano/usuarioCRUDControlador.php?accion=obtener&id=${id}`, {credentials:'same-origin'})
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { toast(data.msg || 'Error al cargar datos.', false); return; }
            const u = data.usuario;

            const titulo = document.getElementById('modalTitulo');
            if (titulo && titulo.querySelector('span')) {
                titulo.querySelector('span').textContent = 'Editar Usuario';
            }
            document.getElementById('btnGuardarTxt').textContent = 'Guardar Cambios';
            document.getElementById('f_pwd_label').textContent   = 'Nueva Contraseña';
            document.getElementById('f_pwd_hint').textContent    = 'Dejar vacío para conservar la contraseña actual';
            document.getElementById('f_password').required       = false;

            document.getElementById('formAccion').value     = 'editar';
            document.getElementById('formUsuarioId').value  = u.usuario_id;
            document.getElementById('f_nombre').value       = u.nombre || '';
            document.getElementById('f_cedula').value       = u.cedula || '';
            document.getElementById('f_cargo').value        = u.cargo  || '';
            document.getElementById('f_area').value         = u.area   || '';
            document.getElementById('f_email').value        = u.email  || '';
            document.getElementById('f_celular').value      = u.celular || '';
            document.getElementById('f_tel_corp').value     = u.telefono_corporativo || '';
            document.getElementById('f_tel_emerg').value    = u.telefono_emergencia  || '';
            document.getElementById('f_usuario').value      = u.usuario || '';
            document.getElementById('f_nivel').value        = u.nivel_acceso || 3;
            document.getElementById('f_estado').value       = u.estado || 'activo';

            // Preview Avatar
            const prev = document.getElementById('modalAvatarPreview');
            if (u.foto_url) {
                prev.innerHTML = `<img src="${u.foto_url}" alt="foto">`;
            } else {
                const initLetra = (u.nombre || '?').trim()[0].toUpperCase();
                prev.innerHTML = `<span id="modalAvatarInitial">${initLetra}</span>`;
            }

            abrirModal('modalUsuario');
        })
        .catch(() => toast('Error de red al consultar usuario.', false));
}

/* ════════════════════════════════════════════
   CRUD — GUARDAR (crear o editar)
   ════════════════════════════════════════════ */
function guardarUsuario() {
    const btn = document.getElementById('btnGuardar');
    const form = document.getElementById('formUsuario');
    const nombre = document.getElementById('f_nombre').value.trim();
    const usuario = document.getElementById('f_usuario').value.trim();
    const pwd = document.getElementById('f_password').value.trim();
    const accion = document.getElementById('formAccion').value;

    if (!nombre || !usuario) {
        toast('Nombre y usuario son campos obligatorios.', false); return;
    }
    if (accion === 'crear' && (!pwd || pwd.length < 6)) {
        toast('La contraseña inicial debe tener al menos 6 caracteres.', false); return;
    }

    btn.disabled = true;
    document.getElementById('btnGuardarTxt').textContent = 'Guardando...';

    const fd = new FormData(form);

    fetch('../../controladores/talentoHumano/usuarioCRUDControlador.php', {
        method: 'POST', body: fd, credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            toast(data.msg, true);
            cerrarModal('modalUsuario');
            setTimeout(() => location.reload(), 900);
        } else {
            toast(data.msg || 'Error al guardar.', false);
        }
    })
    .catch(() => toast('Error de red al guardar usuario.', false))
    .finally(() => {
        btn.disabled = false;
        document.getElementById('btnGuardarTxt').textContent = accion === 'crear' ? 'Crear Usuario' : 'Guardar Cambios';
    });
}

/* ════════════════════════════════════════════
   CRUD — CAMBIAR ESTADO
   ════════════════════════════════════════════ */
function cambiarEstado(id, nuevoEstado) {
    const etiqueta = nuevoEstado === 'activo' ? 'activar' : 'desactivar';
    if (!confirm(`¿Seguro que deseas ${etiqueta} esta cuenta de usuario?`)) return;

    const fd = new FormData();
    fd.append('accion', 'estado');
    fd.append('usuario_id', id);
    fd.append('estado', nuevoEstado);

    fetch('../../controladores/talentoHumano/usuarioCRUDControlador.php', {
        method: 'POST', body: fd, credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            toast(data.msg, true);
            setTimeout(() => location.reload(), 700);
        } else {
            toast(data.msg || 'Error al cambiar estado.', false);
        }
    })
    .catch(() => toast('Error de red al cambiar estado.', false));
}
    // Auto-abrir modal si viene ?crear=1 en la URL
    <?php if ($esSuperUsuario && isset($_GET['crear'])): ?>
    abrirModalCrear();
    <?php endif; ?>
</script>

</body>
</html>
