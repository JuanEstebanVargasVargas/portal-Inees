<?php
// vistas/miArea/miAreaVista.php
// Espacio "Mi Área" - Vista institucional
// Solo el rol Sistema de Gestión puede publicar o eliminar archivos.
// Todos los roles (Empleado, Gestión Humana, SuperUsuario) pueden ver y descargar.

// Detección dinámica de la URL base
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
    <title>Mi Área — Portal INEES</title>
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
            --folder-color:  #f59e0b;
            --folder-hover:  #d97706;
            --radius-sm:     8px;
            --radius-md:     12px;
            --radius-lg:     16px;
            --shadow-sm:     0 1px 3px rgba(15,34,61,.06);
            --shadow-md:     0 4px 14px rgba(15,34,61,.08);
            --shadow-lg:     0 12px 28px -4px rgba(15,34,61,.13);

            /* Colores específicos por división */
            --gen-color:      #0d9488;
            --gen-bg:         #f0fdfa;
            --gen-border:     #99f6e4;

            --rh-color:       #059669;
            --rh-bg:          #ecfdf5;
            --rh-border:      #a7f3d0;

            --ger-color:      #7c3aed;
            --ger-bg:         #f5f3ff;
            --ger-border:     #ddd6fe;

            --tec-color:      #0284c7;
            --tec-bg:         #f0f9ff;
            --tec-border:     #bae6fd;

            --adm-color:      #d97706;
            --adm-bg:         #fffbeb;
            --adm-border:     #fde68a;

            --emp-color:      #2563eb;
            --emp-bg:         #eff6ff;
            --emp-border:     #bfdbfe;
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
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 55%, #0d9488 100%);
            border-radius: var(--radius-lg);
            padding: 32px 36px;
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
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.25) 0%, transparent 70%);
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
            color: #fcd34d;
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
            background: rgba(56, 189, 248, 0.2);
            color: #7dd3fc;
            border: 1px solid rgba(125, 211, 252, 0.4);
        }

        .hero-actions {
            position: relative;
            z-index: 2;
        }

        .btn-upload-trigger {
            background: linear-gradient(135deg, #10b981, #059669);
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
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
            transition: all 0.2s ease;
        }
        .btn-upload-trigger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
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

        /* ── Tarjetas de Divisiones Autorizadas en Mi Área ── */
        .division-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .division-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 16px 18px;
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
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
        .div-gen  { border-top: 4px solid var(--gen-color); }
        .div-gen.active { border-color: var(--gen-color); background: var(--gen-bg); }
        .div-gen .div-icon-box { background: var(--gen-bg); color: var(--gen-color); border: 1px solid var(--gen-border); }

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
            gap: 12px;
        }

        .div-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .div-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .div-sub {
            font-size: 11px;
            color: var(--text-muted);
        }

        .div-count-badge {
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
        }

        /* Selector de División en Modal */
        .division-selector-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 6px;
        }

        .division-option-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            border: 2px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
            background: #ffffff;
            user-select: none;
            font-size: 12px;
        }

        .division-option-label input[type="radio"] {
            margin: 0;
            accent-color: var(--primary);
        }

        .division-option-label:hover {
            border-color: #5eead4;
            background: #f0fdfa;
        }

        .division-option-label.selected {
            border-color: var(--primary);
            background: #f0fdfa;
            font-weight: 700;
        }

        .pill-area {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }
        .pill-gen { background: var(--gen-bg); color: var(--gen-color); border: 1px solid var(--gen-border); }
        .pill-rh  { background: var(--rh-bg); color: var(--rh-color); border: 1px solid var(--rh-border); }
        .pill-ger { background: var(--ger-bg); color: var(--ger-color); border: 1px solid var(--ger-border); }
        .pill-tec { background: var(--tec-bg); color: var(--tec-color); border: 1px solid var(--tec-border); }
        .pill-adm { background: var(--adm-bg); color: var(--adm-color); border: 1px solid var(--adm-border); }
        .pill-emp { background: var(--emp-bg); color: var(--emp-color); border: 1px solid var(--emp-border); }

        /* ── Contenedor Carpeta "Mi Área" ── */
        .folder-main-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            margin-bottom: 28px;
            overflow: hidden;
            position: relative;
        }

        /* Solapa de carpeta decorativa */
        .folder-tab-bar {
            background: #f1f5f9;
            padding: 12px 20px 0;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            overflow-x: auto;
        }

        .folder-tab {
            background: #e2e8f0;
            color: var(--text-muted);
            padding: 10px 18px;
            border-radius: 10px 10px 0 0;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: 1px solid #cbd5e1;
            border-bottom: none;
            transition: all 0.2s;
            text-decoration: none;
            white-space: nowrap;
        }

        .folder-tab.active {
            background: #ffffff;
            color: var(--primary-dark);
            border-color: #cbd5e1;
            box-shadow: 0 -2px 6px rgba(0,0,0,0.03);
            position: relative;
            margin-bottom: -2px;
            padding-bottom: 12px;
            border-bottom: 2px solid #ffffff;
        }

        .folder-tab:hover:not(.active) {
            background: #e6edf4;
            color: var(--text-main);
        }

        .folder-count-badge {
            background: rgba(13, 148, 136, 0.12);
            color: var(--primary);
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 12px;
            font-weight: 700;
        }

        /* Controles de la carpeta */
        .folder-toolbar {
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
        }

        .folder-info-heading {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .big-folder-icon {
            font-size: 32px;
            line-height: 1;
        }

        .folder-heading-text h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
        }

        .folder-heading-text p {
            font-size: 12.5px;
            color: var(--text-muted);
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
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        /* ── Modal de Publicación (Solo Sistema de Gestión) ── */
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
            max-width: 580px;
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
            border-bottom: 2px solid var(--primary);
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
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
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
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .file-dropzone-icon {
            font-size: 32px;
            margin-bottom: 8px;
            color: var(--primary);
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

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(13, 148, 136, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
        }

        /* ── Grilla de Archivos ── */
        .files-container {
            padding: 24px;
            background: #ffffff;
        }

        .files-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 18px;
        }

        .file-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .file-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .file-card-top {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .file-ext-icon {
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
        }

        /* Colores según extensión */
        .ext-pdf  { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .ext-word { background: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
        .ext-excel{ background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .ext-ppt  { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
        .ext-img  { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
        .ext-zip  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .ext-file { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

        .file-main-info {
            flex: 1;
            min-width: 0;
        }

        .file-category-badge {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 2px 7px;
            border-radius: 4px;
            background: #f1f5f9;
            color: #475569;
            margin-bottom: 5px;
        }

        .file-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.3;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .file-orig-name {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-desc {
            font-size: 12.5px;
            color: #475569;
            background: #f8fafc;
            padding: 8px 10px;
            border-radius: 6px;
            border-left: 3px solid var(--primary);
            margin: 10px 0 14px;
            line-height: 1.4;
            word-break: break-word;
        }

        .file-card-meta {
            border-top: 1px dashed var(--border-light);
            padding-top: 10px;
            font-size: 11.5px;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 12px;
        }

        .file-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-meta-uploader {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #334155;
            font-weight: 600;
        }

        .file-card-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-download {
            flex: 1;
            background: #f0fdfa;
            color: var(--primary-dark);
            border: 1px solid #99f6e4;
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

        .btn-download:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.3);
        }

        .btn-delete-file {
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

        .btn-delete-file:hover {
            background: #fee2e2;
            color: #b91c1c;
            border-color: #fca5a5;
        }

        /* ── Estado vacío ── */
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

        .empty-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13.5px;
            color: var(--text-muted);
            max-width: 440px;
            margin: 0 auto;
        }

        /* ── Modal de confirmación para eliminar ── */
        .delete-confirm-box {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: var(--radius-sm);
            padding: 14px;
            color: #991b1b;
            font-size: 13.5px;
            margin-bottom: 16px;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 24px 20px;
            }
            .hero-title {
                font-size: 22px;
            }
            .folder-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box-container {
                max-width: 100%;
            }
            .files-grid {
                grid-template-columns: 1fr;
            }
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
            <span>Mi Área</span>
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
                    <div class="hero-icon-box">📁</div>
                    <h1 class="hero-title">Mi Área</h1>
                </div>
                <p class="hero-sub">
                    Repositorio corporativo de documentación oficial, normativas, formatos y procedimientos institucionales, administrado por el equipo de <strong>Sistema de Gestión</strong>.
                </p>
                <div>
                    <?php if ($puedePublicar): ?>
                        <span class="hero-badge-pill hero-badge-admin">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            Rol: Sistema de Gestión — Habilitado para Publicar Archivos
                        </span>
                    <?php else: ?>
                        <span class="hero-badge-pill hero-badge-read">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            Modo Consulta: Acceso a Documentación Oficial
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($puedePublicar): ?>
                <div class="hero-actions">
                    <button class="btn-upload-trigger" onclick="abrirModalPublicar()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        Publicar Archivo
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             DIVISIONES DE MI ÁREA AUTORIZADAS PARA EL USUARIO
             ═══════════════════════════════════════════════════════ -->
        <div class="division-grid">
            <!-- 1. General (todos los que tengan GENERAL) -->
            <?php if (in_array('GENERAL', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?area=<?= urlencode('GENERAL') ?>" 
                   class="division-card div-gen <?= ($areaFiltro === 'GENERAL') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">🏛️</div>
                        <div>
                            <div class="div-title">General</div>
                            <div class="div-sub">Normativas y formatos globales</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['GENERAL'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 2. Recursos Humanos -->
            <?php if (in_array('RECURSOS HUMANOS', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?area=<?= urlencode('RECURSOS HUMANOS') ?>" 
                   class="division-card div-rh <?= ($areaFiltro === 'RECURSOS HUMANOS') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">👥</div>
                        <div>
                            <div class="div-title">Recursos Humanos</div>
                            <div class="div-sub">Políticas y formatos de talento</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['RECURSOS HUMANOS'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 3. Gerencia -->
            <?php if (in_array('GERENCIA', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?area=<?= urlencode('GERENCIA') ?>" 
                   class="division-card div-ger <?= ($areaFiltro === 'GERENCIA') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">👔</div>
                        <div>
                            <div class="div-title">Gerencia</div>
                            <div class="div-sub">Documentación de dirección</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['GERENCIA'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 4. Técnicos -->
            <?php if (in_array('TECNICOS', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?area=<?= urlencode('TECNICOS') ?>" 
                   class="division-card div-tec <?= ($areaFiltro === 'TECNICOS') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">🔧</div>
                        <div>
                            <div class="div-title">Técnicos</div>
                            <div class="div-sub">Instructivos y guías técnicas</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['TECNICOS'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 5. Administrativo -->
            <?php if (in_array('ADMINISTRATIVO', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?area=<?= urlencode('ADMINISTRATIVO') ?>" 
                   class="division-card div-adm <?= ($areaFiltro === 'ADMINISTRATIVO') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">📊</div>
                        <div>
                            <div class="div-title">Administrativo</div>
                            <div class="div-sub">Procedimientos y compras</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['ADMINISTRATIVO'] ?? 0) ?></span>
                </a>
            <?php endif; ?>

            <!-- 6. Empleado -->
            <?php if (in_array('EMPLEADO', $areasPermitidas, true)): ?>
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?area=<?= urlencode('EMPLEADO') ?>" 
                   class="division-card div-emp <?= ($areaFiltro === 'EMPLEADO') ? 'active' : '' ?>">
                    <div class="div-left">
                        <div class="div-icon-box">👤</div>
                        <div>
                            <div class="div-title">Empleado</div>
                            <div class="div-sub">Formatos para el colaborador</div>
                        </div>
                    </div>
                    <span class="div-count-badge"><?= (int)($conteos['EMPLEADO'] ?? 0) ?></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             CARPETA PRINCIPAL INTERACTIVA "MI ÁREA"
             ═══════════════════════════════════════════════════════ -->
        <div class="folder-main-card">
            
            <!-- Pestañas Superiores de la Carpeta (Categorías) -->
            <div class="folder-tab-bar">
                <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php<?= !empty($areaFiltro) ? '?area=' . urlencode($areaFiltro) : '' ?>" 
                   class="folder-tab <?= (empty($categoriaFiltro) || $categoriaFiltro === 'todos') ? 'active' : '' ?>">
                    <span>📁 Carpeta: <?= !empty($areaFiltro) ? htmlspecialchars($areaFiltro) : 'Mi Área' ?> (Todo)</span>
                    <span class="folder-count-badge"><?= count($archivos) ?></span>
                </a>

                <?php foreach ($categorias as $cat): ?>
                    <?php 
                        $catUrl = $urlBase . 'controladores/miArea/miAreaControlador.php?cat=' . urlencode($cat['categoria']);
                        if (!empty($areaFiltro)) $catUrl .= '&area=' . urlencode($areaFiltro);
                    ?>
                    <a href="<?= $catUrl ?>" 
                       class="folder-tab <?= ($categoriaFiltro === $cat['categoria']) ? 'active' : '' ?>">
                        <span>📂 <?= htmlspecialchars($cat['categoria']) ?></span>
                        <span class="folder-count-badge"><?= (int)$cat['total'] ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Barra de Herramientas de la Carpeta -->
            <div class="folder-toolbar">
                <div class="folder-info-heading">
                    <div class="big-folder-icon">📂</div>
                    <div class="folder-heading-text">
                        <h2>
                            <?= !empty($areaFiltro) ? 'División ' . htmlspecialchars($areaFiltro) . (!empty($categoriaFiltro) ? ' &bull; ' . htmlspecialchars($categoriaFiltro) : '') : (!empty($categoriaFiltro) ? htmlspecialchars($categoriaFiltro) : 'Carpeta General: Mi Área') ?>
                        </h2>
                        <p>
                            <?= count($archivos) ?> <?= count($archivos) === 1 ? 'archivo disponible' : 'archivos disponibles' ?> para consulta y descarga
                        </p>
                    </div>

                    <?php if (!empty($areaFiltro)): ?>
                        <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php" style="margin-left: 12px; font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 600; padding: 4px 10px; background: #f0fdfa; border-radius: 6px; border: 1px solid #99f6e4;">
                            ✕ Ver Todas las Divisiones Permitidas
                        </a>
                    <?php endif; ?>
                </div>

                <div class="search-box-container">
                    <input type="text" id="inputBuscarArchivos" class="search-input" placeholder="Buscar documento en Mi Área..." onkeyup="filtrarArchivosEnVivo()">
                </div>
            </div>

            <!-- Grilla de Archivos -->
            <div class="files-container">
                <?php if (empty($archivos)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📂</div>
                        <div class="empty-title">Esta carpeta aún no contiene archivos publicados</div>
                        <p class="empty-sub">
                            <?php if ($puedePublicar): ?>
                                Como encargado de <strong>Sistema de Gestión</strong>, puedes hacer clic en "Publicar Archivo" para subir el primer documento a esta carpeta.
                            <?php else: ?>
                                Los documentos oficiales publicados por el equipo de Sistema de Gestión aparecerán listados aquí tan pronto estén disponibles.
                            <?php endif; ?>
                        </p>
                        <?php if ($puedePublicar): ?>
                            <div style="margin-top: 18px;">
                                <button class="btn-upload-trigger" onclick="abrirModalPublicar()">
                                    <span>➕</span> Subir Documento
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="files-grid" id="contenedorArchivosGrid">
                        <?php foreach ($archivos as $arc): ?>
                            <?php
                                $ext = strtolower(pathinfo($arc['nombre_original'], PATHINFO_EXTENSION));
                                $extClass = 'ext-file';
                                $extLabel = strtoupper($ext ?: 'DOC');
                                if (in_array($ext, ['pdf'])) {
                                    $extClass = 'ext-pdf';
                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                    $extClass = 'ext-word';
                                } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                    $extClass = 'ext-excel';
                                } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                    $extClass = 'ext-ppt';
                                } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                    $extClass = 'ext-img';
                                } elseif (in_array($ext, ['zip', 'rar'])) {
                                    $extClass = 'ext-zip';
                                }

                                // Formatear tamaño
                                $tamBytes = (int)$arc['tamano'];
                                if ($tamBytes >= 1048576) {
                                    $tamanoFmt = number_format($tamBytes / 1048576, 1) . ' MB';
                                } elseif ($tamBytes >= 1024) {
                                    $tamanoFmt = number_format($tamBytes / 1024, 0) . ' KB';
                                } else {
                                    $tamanoFmt = $tamBytes . ' B';
                                }

                                // Formatear fecha
                                $fechaFmt = date('d/m/Y h:i a', strtotime($arc['fecha_subida']));

                                // Área y badge correspondiente
                                $areaDoc = $arc['area'] ?? 'GENERAL';
                                $pillClass = 'pill-gen';
                                if ($areaDoc === 'RECURSOS HUMANOS') $pillClass = 'pill-rh';
                                elseif ($areaDoc === 'GERENCIA') $pillClass = 'pill-ger';
                                elseif ($areaDoc === 'TECNICOS') $pillClass = 'pill-tec';
                                elseif ($areaDoc === 'ADMINISTRATIVO') $pillClass = 'pill-adm';
                                elseif ($areaDoc === 'EMPLEADO') $pillClass = 'pill-emp';

                                // Texto de búsqueda
                                $searchData = strtolower($arc['titulo'] . ' ' . $arc['categoria'] . ' ' . $areaDoc . ' ' . $arc['nombre_original'] . ' ' . ($arc['descripcion'] ?? ''));
                            ?>
                            <div class="file-card" data-search="<?= htmlspecialchars($searchData, ENT_QUOTES, 'UTF-8') ?>">
                                <div>
                                    <div class="file-card-top">
                                        <div class="file-ext-icon <?= $extClass ?>">
                                            <?= htmlspecialchars(substr($extLabel, 0, 4)) ?>
                                        </div>
                                        <div class="file-main-info">
                                            <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
                                                <span class="pill-area <?= $pillClass ?>">
                                                    <?= htmlspecialchars($areaDoc) ?>
                                                </span>
                                                <span class="file-category-badge">
                                                    <?= htmlspecialchars($arc['categoria']) ?>
                                                </span>
                                            </div>
                                            <div class="file-title" title="<?= htmlspecialchars($arc['titulo']) ?>">
                                                <?= htmlspecialchars($arc['titulo']) ?>
                                            </div>
                                            <div class="file-orig-name" title="<?= htmlspecialchars($arc['nombre_original']) ?>">
                                                <?= htmlspecialchars($arc['nombre_original']) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (!empty($arc['descripcion'])): ?>
                                        <div class="file-desc">
                                            <?= nl2br(htmlspecialchars($arc['descripcion'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <div class="file-card-meta">
                                        <div class="file-meta-row">
                                            <span>📅 <?= $fechaFmt ?></span>
                                            <span>💾 <?= $tamanoFmt ?></span>
                                        </div>
                                        <div class="file-meta-uploader">
                                            <span>👤</span>
                                            <span><?= htmlspecialchars($arc['autor_nombre'] ?? 'Sistema de Gestión') ?></span>
                                        </div>
                                    </div>

                                    <div class="file-card-actions">
                                        <a href="<?= $urlBase ?>controladores/miArea/miAreaControlador.php?accion=descargar&id=<?= $arc['id'] ?>" 
                                           class="btn-download" 
                                           target="_blank"
                                           title="Ver o descargar este documento">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Descargar / Abrir
                                        </a>

                                        <?php if ($puedePublicar): ?>
                                            <button type="button" 
                                                    class="btn-delete-file" 
                                                    onclick="confirmarEliminarArchivo(<?= $arc['id'] ?>, '<?= htmlspecialchars(addslashes($arc['titulo'])) ?>')"
                                                    title="Eliminar este archivo">
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

        </div><!-- /.folder-main-card -->

    </main>

    <!-- ═══════════════════════════════════════════════════════
         MODAL PUBLICAR ARCHIVO (SOLO SISTEMA DE GESTIÓN)
         ═══════════════════════════════════════════════════════ -->
    <?php if ($puedePublicar): ?>
        <div id="modalPublicar" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <div class="modal-title">
                        <span>📤</span> Publicar Archivo en Mi Área
                    </div>
                    <button type="button" class="modal-close" onclick="cerrarModalPublicar()" aria-label="Cerrar modal">&times;</button>
                </div>

                <form action="<?= $urlBase ?>controladores/miArea/miAreaControlador.php" method="POST" enctype="multipart/form-data" id="formPublicarArchivo">
                    <input type="hidden" name="accion" value="publicar_archivo">

                    <div class="modal-body">
                        <!-- Título -->
                        <div class="form-group">
                            <label class="form-label" for="tituloArchivo">
                                Título del Documento <span class="req">*</span>
                            </label>
                            <input type="text" 
                                   id="tituloArchivo" 
                                   name="titulo" 
                                   class="form-control" 
                                   placeholder="Ej: Manual de Calidad 2026, Matriz de Riesgos..." 
                                   required>
                        </div>

                        <!-- División de Destino (Para segmentar por Área) -->
                        <div class="form-group">
                            <label class="form-label">
                                División / Área de Destino <span class="req">*</span>
                            </label>
                            <div class="division-selector-grid">
                                <label class="division-option-label selected" onclick="seleccionarDivision(this)">
                                    <input type="radio" name="area_destino" value="GENERAL" checked>
                                    <span>🏛️ General</span>
                                </label>
                                <label class="division-option-label" onclick="seleccionarDivision(this)">
                                    <input type="radio" name="area_destino" value="RECURSOS HUMANOS">
                                    <span>👥 Recursos Humanos</span>
                                </label>
                                <label class="division-option-label" onclick="seleccionarDivision(this)">
                                    <input type="radio" name="area_destino" value="GERENCIA">
                                    <span>👔 Gerencia</span>
                                </label>
                                <label class="division-option-label" onclick="seleccionarDivision(this)">
                                    <input type="radio" name="area_destino" value="TECNICOS">
                                    <span>🔧 Técnicos</span>
                                </label>
                                <label class="division-option-label" onclick="seleccionarDivision(this)">
                                    <input type="radio" name="area_destino" value="ADMINISTRATIVO">
                                    <span>📊 Administrativo</span>
                                </label>
                                <label class="division-option-label" onclick="seleccionarDivision(this)">
                                    <input type="radio" name="area_destino" value="EMPLEADO">
                                    <span>👤 Empleado</span>
                                </label>
                            </div>
                            <small style="display:block; margin-top:6px; font-size:11.5px; color:#64748b;">
                                Selecciona qué colaboradores podrán consultar este documento en su carpeta Mi Área.
                            </small>
                        </div>

                        <!-- Categoría / Clasificación -->
                        <div class="form-group">
                            <label class="form-label" for="selectCategoria">
                                Carpeta / Categoría <span class="req">*</span>
                            </label>
                            <select id="selectCategoria" name="categoria" class="form-control" onchange="toggleOtraCategoria(this.value)" required>
                                <option value="General">General</option>
                                <option value="Formatos">Formatos</option>
                                <option value="Procedimientos">Procedimientos</option>
                                <option value="Políticas">Políticas</option>
                                <option value="Instructivos">Instructivos</option>
                                <option value="Matriz de Riesgos">Matriz de Riesgos</option>
                                <option value="Planes y Programas">Planes y Programas</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <?php if (!in_array($cat['categoria'], ['General', 'Formatos', 'Procedimientos', 'Políticas', 'Instructivos', 'Matriz de Riesgos', 'Planes y Programas'])): ?>
                                        <option value="<?= htmlspecialchars($cat['categoria']) ?>">
                                            <?= htmlspecialchars($cat['categoria']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="__otra__">➕ Crear una nueva carpeta / categoría...</option>
                            </select>
                        </div>

                        <!-- Campo para escribir nueva categoría si selecciona "otra" -->
                        <div class="form-group" id="grupoOtraCategoria" style="display: none;">
                            <label class="form-label" for="inputOtraCategoria">
                                Nombre de la Nueva Carpeta / Categoría <span class="req">*</span>
                            </label>
                            <input type="text" 
                                   id="inputOtraCategoria" 
                                   name="otra_categoria" 
                                   class="form-control" 
                                   placeholder="Escribe el nombre de la nueva categoría...">
                        </div>

                        <!-- Descripción opcional -->
                        <div class="form-group">
                            <label class="form-label" for="descArchivo">
                                Descripción u Observaciones (Opcional)
                            </label>
                            <textarea id="descArchivo" 
                                      name="descripcion" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Indica brevemente el alcance, vigencia o versión del documento..."></textarea>
                        </div>

                        <!-- Selector de archivo con dropzone -->
                        <div class="form-group">
                            <label class="form-label">
                                Seleccionar Archivo <span class="req">*</span>
                            </label>
                            <div class="file-dropzone" id="dropzone" onclick="document.getElementById('inputArchivoFile').click()">
                                <div class="file-dropzone-icon">📁</div>
                                <div class="file-dropzone-text" id="dropzoneText">Haz clic aquí o arrastra un archivo</div>
                                <div class="file-dropzone-sub">
                                    Admite PDF, Word (.docx), Excel (.xlsx), PPT, JPG, PNG, ZIP (Máx. 35 MB)
                                </div>
                            </div>
                            <input type="file" 
                                   id="inputArchivoFile" 
                                   name="archivo" 
                                   style="display: none;" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.txt,.jpg,.jpeg,.png,.zip,.rar" 
                                   required 
                                   onchange="actualizarNombreArchivo(this)">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="cerrarModalPublicar()">Cancelar</button>
                        <button type="submit" class="btn-primary" id="btnSubmitPublicar">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Publicar Archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             MODAL CONFIRMAR ELIMINACIÓN
             ═══════════════════════════════════════════════════════ -->
        <div id="modalEliminar" class="modal-overlay">
            <div class="modal-card" style="max-width: 460px;">
                <div class="modal-header" style="background: #991b1b; border-bottom: 2px solid #ef4444;">
                    <div class="modal-title">
                        <span>⚠️</span> Confirmar Eliminación
                    </div>
                    <button type="button" class="modal-close" onclick="cerrarModalEliminar()">&times;</button>
                </div>

                <form action="<?= $urlBase ?>controladores/miArea/miAreaControlador.php" method="POST">
                    <input type="hidden" name="accion" value="eliminar_archivo">
                    <input type="hidden" name="archivo_id" id="eliminarArchivoId" value="">

                    <div class="modal-body">
                        <div class="delete-confirm-box">
                            ¿Estás seguro de que deseas eliminar este archivo de la carpeta Mi Área?
                        </div>
                        <p style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 6px;" id="eliminarArchivoTitulo"></p>
                        <p style="font-size: 12.5px; color: #64748b;">
                            Esta acción deshabilitará el archivo y ya no estará visible para los colaboradores.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="cerrarModalEliminar()">Cancelar</button>
                        <button type="submit" class="btn-primary" style="background: #dc2626;">
                            Sí, Eliminar Archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Filtrado en vivo de archivos mediante input
        function filtrarArchivosEnVivo() {
            var input = document.getElementById('inputBuscarArchivos');
            var filtro = input ? input.value.toLowerCase().trim() : '';
            var cards = document.querySelectorAll('.file-card');

            cards.forEach(function(card) {
                var data = card.getAttribute('data-search') || '';
                if (data.indexOf(filtro) !== -1) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Selección visual de división en radio buttons
        function seleccionarDivision(labelEl) {
            document.querySelectorAll('.division-option-label').forEach(function(l) {
                l.classList.remove('selected');
            });
            labelEl.classList.add('selected');
            var radio = labelEl.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        }

        // Modales
        function abrirModalPublicar(areaDefecto) {
            var m = document.getElementById('modalPublicar');
            if (m) {
                if (areaDefecto) {
                    var radio = m.querySelector('input[name="area_destino"][value="' + areaDefecto + '"]');
                    if (radio) {
                        seleccionarDivision(radio.closest('.division-option-label'));
                    }
                }
                m.classList.add('active');
            }
        }

        function cerrarModalPublicar() {
            var m = document.getElementById('modalPublicar');
            if (m) m.classList.remove('active');
        }

        function toggleOtraCategoria(val) {
            var grupo = document.getElementById('grupoOtraCategoria');
            var input = document.getElementById('inputOtraCategoria');
            if (grupo && input) {
                if (val === '__otra__') {
                    grupo.style.display = 'block';
                    input.required = true;
                    input.focus();
                } else {
                    grupo.style.display = 'none';
                    input.required = false;
                }
            }
        }

        function actualizarNombreArchivo(input) {
            var text = document.getElementById('dropzoneText');
            if (input.files && input.files[0]) {
                text.innerHTML = '<strong>Archivo seleccionado:</strong> ' + input.files[0].name + ' (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
                text.style.color = '#0d9488';
            }
        }

        function confirmarEliminarArchivo(id, titulo) {
            var modal = document.getElementById('modalEliminar');
            var idInput = document.getElementById('eliminarArchivoId');
            var titText = document.getElementById('eliminarArchivoTitulo');
            if (modal && idInput && titText) {
                idInput.value = id;
                titText.textContent = titulo;
                modal.classList.add('active');
            }
        }

        function cerrarModalEliminar() {
            var modal = document.getElementById('modalEliminar');
            if (modal) modal.classList.remove('active');
        }

        // Drag & drop en dropzone
        var dropzone = document.getElementById('dropzone');
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
                var fileInput = document.getElementById('inputArchivoFile');
                if (files && files.length > 0 && fileInput) {
                    fileInput.files = files;
                    actualizarNombreArchivo(fileInput);
                }
            }, false);
        }

        // Cerrar modales con escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModalPublicar();
                cerrarModalEliminar();
            }
        });
    </script>
</body>
</html>
