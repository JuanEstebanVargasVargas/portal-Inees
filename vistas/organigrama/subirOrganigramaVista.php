<?php
// vistas/organigrama/subirOrganigramaVista.php
// Requiere: $organigrama, $historial, $puedeSubir, $mensaje, $error, $perfil, $rol_id
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">
    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title>Organigrama Institucional – INEES Portal</title>
    <style>
        :root {
            --primary:   #0d9488;
            --primary-d: #0f766e;
            --bg:        #f1f5f9;
            --card:      #ffffff;
            --text:      #1e293b;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --danger:    #ef4444;
            --danger-d:  #dc2626;
            --success:   #22c55e;
            --warn:      #f59e0b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f0f2f5;
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Layout ──────────────────────────────────── */
        .page-wrapper   { display: flex; flex-direction: column; min-height: 100vh; position: relative; z-index: 1; }
        .content-area   { display: flex; flex: 1; overflow: hidden; }
        .main-content   { flex: 1; overflow-y: auto; padding: 0; }

        /* ── Hero ────────────────────────────────────── */
        .hero {
            background: linear-gradient(135deg, #0b1728 0%, #1a1040 60%, #0d3d38 100%);
            padding: 2.5rem 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 60% at 80% 50%, rgba(13,148,136,.18), transparent);
            pointer-events: none;
        }
        .hero-inner   { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(13,148,136,.2); border: 1px solid rgba(13,148,136,.4);
            color: #5eead4; border-radius: 999px; padding: .25rem .9rem;
            font-size: .75rem; font-weight: 600; letter-spacing: .05em;
            text-transform: uppercase; margin-bottom: .9rem;
        }
        .hero h1 {
            font-size: 2rem; font-weight: 700; color: #fff;
            line-height: 1.2; margin-bottom: .5rem;
        }
        .hero p { color: #94a3b8; font-size: .95rem; }

        /* ── Contenedor principal ─────────────────────── */
        .page-body { padding: 2rem 2.5rem; max-width: 1200px; margin: 0 auto; width: 100%; }

        /* ── Alertas ─────────────────────────────────── */
        .alert {
            padding: .85rem 1.2rem; border-radius: .5rem; margin-bottom: 1.5rem;
            font-size: .9rem; font-weight: 500; display: flex; align-items: center; gap: .6rem;
        }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; }
        .alert-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

        /* ── Card ────────────────────────────────────── */
        .card {
            background: rgba(255,255,255,0.97); border-radius: .75rem;
            border: 1px solid var(--border); overflow: hidden;
            margin-bottom: 2rem; box-shadow: 0 4px 18px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.04);
        }
        .card-header {
            padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: .7rem;
            background: #f8fafc;
        }
        .card-header svg { color: var(--primary); flex-shrink: 0; }
        .card-header h2 { font-size: 1rem; font-weight: 600; }
        .card-header .badge-pill {
            margin-left: auto; background: var(--primary); color: #fff;
            font-size: .72rem; padding: .2rem .65rem; border-radius: 999px; font-weight: 600;
        }
        .card-body { padding: 1.5rem; }

        /* ── Formulario ─────────────────────────────── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { display: flex; flex-direction: column; gap: .35rem; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: .82rem; font-weight: 600; color: var(--muted); }
        input[type=text], textarea, input[type=file] {
            border: 1px solid var(--border); border-radius: .45rem;
            padding: .6rem .9rem; font-size: .9rem; color: var(--text);
            font-family: inherit; background: #fff; transition: border-color .2s;
        }
        input[type=text]:focus, textarea:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,.12);
        }
        textarea { resize: vertical; min-height: 80px; }
        input[type=file] {
            padding: .5rem; cursor: pointer;
            background: #f8fafc;
        }
        .file-hint {
            font-size: .78rem; color: var(--muted); margin-top: .25rem;
        }
        .btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .65rem 1.4rem; border-radius: .45rem;
            border: none; cursor: pointer; font-size: .9rem; font-weight: 600;
            font-family: inherit; transition: background .2s, transform .1s;
            text-decoration: none;
        }
        .btn:active { transform: scale(.98); }
        .btn-primary  { background: var(--primary);  color: #fff; }
        .btn-primary:hover { background: var(--primary-d); }
        .btn-danger   { background: var(--danger);   color: #fff; font-size: .8rem; padding: .35rem .8rem; }
        .btn-danger:hover { background: var(--danger-d); }
        .btn-sm       { padding: .3rem .7rem; font-size: .8rem; }
        .form-actions { margin-top: 1.2rem; display: flex; justify-content: flex-end; }

        /* ── Visor ──────────────────────────────────── */
        .viewer-wrap {
            position: relative; border-radius: .5rem; overflow: hidden;
            border: 1px solid var(--border); background: #0f172a;
        }
        .viewer-toolbar {
            position: absolute; top: .6rem; right: .6rem; z-index: 10;
            display: flex; gap: .4rem;
        }
        .btn-viewer {
            background: rgba(0,0,0,.55); color: #fff; border: 1px solid rgba(255,255,255,.2);
            border-radius: .35rem; padding: .4rem .7rem; cursor: pointer;
            font-size: .8rem; font-weight: 600; display: flex; align-items: center; gap: .4rem;
            transition: background .2s; text-decoration: none;
        }
        .btn-viewer:hover { background: rgba(0,0,0,.8); }

        .viewer-pdf {
            width: 100%; height: 680px; border: none; display: block;
        }
        .viewer-img {
            width: 100%; max-height: 680px; object-fit: contain;
            display: block; cursor: zoom-in;
        }
        .viewer-empty {
            padding: 4rem 2rem; text-align: center; color: #94a3b8;
        }
        .viewer-empty svg { opacity: .3; margin-bottom: 1rem; }
        .viewer-empty p { font-size: .95rem; }

        /* Meta info del organigrama actual */
        .org-meta {
            display: flex; flex-wrap: wrap; gap: .75rem 1.5rem;
            padding: 1rem 1.5rem; background: #f0fdf4;
            border-bottom: 1px solid #bbf7d0; font-size: .85rem;
        }
        .org-meta span { display: flex; align-items: center; gap: .4rem; color: #166534; }
        .org-meta strong { color: var(--text); }

        /* ── Tabla historial ─────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .86rem; }
        thead th {
            background: #f8fafc; padding: .7rem 1rem; text-align: left;
            font-weight: 600; color: var(--muted); border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
        tbody tr:hover { background: #f8fafc; }
        tbody td { padding: .7rem 1rem; color: var(--text); vertical-align: middle; }
        .badge {
            display: inline-block; padding: .2rem .6rem; border-radius: 999px;
            font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
        }
        .badge-activo    { background: #dcfce7; color: #166534; }
        .badge-historico { background: #fef3c7; color: #92400e; }
        .badge-inactivo  { background: #f1f5f9; color: #94a3b8; }
        .badge-pdf  { background: #fee2e2; color: #991b1b; }
        .badge-img  { background: #e0f2fe; color: #0369a1; }
        .badge-row-current td { background: #f0fdf4 !important; }

        /* ── Lightbox ────────────────────────────────── */
        #lightbox {
            display: none; position: fixed; inset: 0; z-index: 9999;
            background: rgba(0,0,0,.92); align-items: center; justify-content: center;
        }
        #lightbox.open { display: flex; }
        #lightbox img {
            max-width: 90vw; max-height: 90vh; object-fit: contain;
            border-radius: .5rem; box-shadow: 0 20px 60px rgba(0,0,0,.8);
        }
        #lightbox-close {
            position: absolute; top: 1.2rem; right: 1.5rem;
            color: #fff; font-size: 2rem; cursor: pointer; line-height: 1;
            background: none; border: none; font-family: inherit;
            transition: opacity .2s;
        }
        #lightbox-close:hover { opacity: .6; }

        @media (max-width: 700px) {
            .page-body { padding: 1.2rem; }
            .form-grid { grid-template-columns: 1fr; }
            .hero { padding: 1.5rem; }
            .hero h1 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

<?php require_once __DIR__ . '/../partials/navbar/navbar.php'; ?>

<div class="content-area">
    <?php require_once __DIR__ . '/../partials/sidebar/sidebar.php'; ?>

    <main class="main-content">

        <!-- ── Hero ──────────────────────────────────────────────── -->
        <div class="hero">
            <div class="hero-inner">
                <div class="hero-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="9" y="2" width="6" height="4" rx="1"/>
                        <rect x="1" y="14" width="6" height="4" rx="1"/>
                        <rect x="17" y="14" width="6" height="4" rx="1"/>
                        <line x1="12" y1="6" x2="12" y2="11"/>
                        <line x1="12" y1="11" x2="4" y2="14"/>
                        <line x1="12" y1="11" x2="20" y2="14"/>
                    </svg>
                    Gestión Institucional
                </div>
                <h1>Organigrama Institucional</h1>
                <p>
                    <?php if ($puedeSubir): ?>
                        Carga, actualiza y gestiona el organigrama de la institución.
                    <?php else: ?>
                        Consulta el organigrama institucional vigente.
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- ── Cuerpo ─────────────────────────────────────────────── -->
        <div class="page-body">

            <!-- Alertas -->
            <?php if ($mensaje): ?>
                <div class="alert alert-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- ── Formulario de carga (solo rol 1 y 5) ───────────── -->
            <?php if ($puedeSubir): ?>
            <div class="card">
                <div class="card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                    <h2>Cargar nuevo organigrama</h2>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input type="text" id="titulo" name="titulo"
                                       value="Organigrama General Institucional"
                                       placeholder="Ej. Organigrama General Institucional">
                            </div>
                            <div class="form-group">
                                <label for="version">Versión</label>
                                <input type="text" id="version" name="version"
                                       value="<?= $organigrama ? 'v' . (intval(ltrim($organigrama['version'] ?? '1', 'vV')) + 1) . '.0' : 'v1.0' ?>"
                                       placeholder="Ej. v2.0">
                            </div>
                            <div class="form-group full">
                                <label for="descripcion">Descripción / Notas (opcional)</label>
                                <textarea id="descripcion" name="descripcion"
                                          placeholder="Describe los cambios o la versión…"></textarea>
                            </div>
                            <div class="form-group full">
                                <label for="organigrama">Archivo del organigrama</label>
                                <input type="file" id="organigrama" name="organigrama"
                                       accept=".pdf,.png,.jpg,.jpeg" required>
                                <span class="file-hint">📎 Formatos: PDF, PNG, JPG — Tamaño máximo: 5 MB</span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                                </svg>
                                Subir organigrama
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ── Visor del organigrama actual ───────────────────── -->
            <div class="card">
                <div class="card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="2" width="6" height="4" rx="1"/>
                        <rect x="1" y="14" width="6" height="4" rx="1"/>
                        <rect x="17" y="14" width="6" height="4" rx="1"/>
                        <line x1="12" y1="6" x2="12" y2="11"/>
                        <line x1="12" y1="11" x2="4" y2="14"/>
                        <line x1="12" y1="11" x2="20" y2="14"/>
                    </svg>
                    <h2>Organigrama vigente</h2>
                    <?php if ($organigrama): ?>
                        <span class="badge-pill"><?= htmlspecialchars($organigrama['version']) ?></span>
                    <?php endif; ?>
                </div>

                <?php if ($organigrama): ?>
                    <!-- Metadatos -->
                    <div class="org-meta">
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            <strong><?= htmlspecialchars($organigrama['titulo']) ?></strong>
                        </span>
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?= date('d/m/Y H:i', strtotime($organigrama['fecha_subida'])) ?>
                        </span>
                        <?php if (!empty($organigrama['subido_por_nombre'])): ?>
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <?= htmlspecialchars($organigrama['subido_por_nombre']) ?>
                        </span>
                        <?php endif; ?>
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                            <?= round($organigrama['tamano'] / 1024, 1) ?> KB · <?= strtoupper($organigrama['tipo_archivo']) ?>
                        </span>
                    </div>

                    <!-- Visor -->
                    <div class="card-body" style="padding: 1rem;">
                        <div class="viewer-wrap">
                            <div class="viewer-toolbar">
                                <?php
                                $urlArchivo = $urlBase . 'uploads/organigrama/' . urlencode($organigrama['ruta_archivo']);
                                ?>
                                <a href="<?= $urlArchivo ?>" target="_blank" class="btn-viewer">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    Abrir
                                </a>
                                <a href="<?= $urlArchivo ?>" download class="btn-viewer">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Descargar
                                </a>
                                <?php if ($organigrama['tipo_archivo'] === 'pdf'): ?>
                                <button onclick="document.getElementById('pdfFrame').requestFullscreen()" class="btn-viewer">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                                    Pantalla completa
                                </button>
                                <?php else: ?>
                                <button onclick="openLightbox('<?= $urlArchivo ?>')" class="btn-viewer">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                                    Zoom
                                </button>
                                <?php endif; ?>
                            </div>

                            <?php if ($organigrama['tipo_archivo'] === 'pdf'): ?>
                                <iframe id="pdfFrame" class="viewer-pdf"
                                        src="<?= $urlArchivo ?>#toolbar=1&navpanes=0"
                                        title="Organigrama PDF"></iframe>
                            <?php else: ?>
                                <img class="viewer-img"
                                     src="<?= $urlArchivo ?>"
                                     alt="Organigrama institucional"
                                     onclick="openLightbox(this.src)">
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($organigrama['descripcion'])): ?>
                        <p style="margin-top:.8rem; color:var(--muted); font-size:.87rem;">
                            <?= nl2br(htmlspecialchars($organigrama['descripcion'])) ?>
                        </p>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <div class="card-body">
                        <div class="viewer-empty">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <rect x="9" y="2" width="6" height="4" rx="1"/>
                                <rect x="1" y="14" width="6" height="4" rx="1"/>
                                <rect x="17" y="14" width="6" height="4" rx="1"/>
                                <line x1="12" y1="6" x2="12" y2="11"/>
                                <line x1="12" y1="11" x2="4" y2="14"/>
                                <line x1="12" y1="11" x2="20" y2="14"/>
                            </svg>
                            <p>No hay organigrama cargado aún.</p>
                            <?php if ($puedeSubir): ?>
                                <p style="margin-top:.4rem; font-size:.82rem;">Usa el formulario de arriba para cargar el primero.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ── Historial de versiones ──────────────────────────── -->
            <?php if (!empty($historial)): ?>
            <div class="card">
                <div class="card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="12 8 12 12 14 14"/><circle cx="12" cy="12" r="10"/>
                    </svg>
                    <h2>Historial de versiones</h2>
                    <span class="badge-pill"><?= count($historial) ?></span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Versión</th>
                                    <th>Título</th>
                                    <th>Fecha</th>
                                    <th>Subido por</th>
                                    <th>Tipo</th>
                                    <th>Tamaño</th>
                                    <th>Estado</th>
                                    <?php if ($puedeSubir): ?><th>Acciones</th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historial as $fila): ?>
                                <tr class="<?= $fila['es_actual'] ? 'badge-row-current' : '' ?>">
                                    <td><strong><?= htmlspecialchars($fila['version']) ?></strong></td>
                                    <td><?= htmlspecialchars($fila['titulo']) ?></td>
                                    <td style="white-space:nowrap"><?= date('d/m/Y H:i', strtotime($fila['fecha_subida'])) ?></td>
                                    <td><?= htmlspecialchars($fila['subido_por_nombre'] ?? '—') ?></td>
                                    <td>
                                        <span class="badge <?= $fila['tipo_archivo'] === 'pdf' ? 'badge-pdf' : 'badge-img' ?>">
                                            <?= strtoupper($fila['tipo_archivo']) ?>
                                        </span>
                                    </td>
                                    <td style="white-space:nowrap"><?= round($fila['tamano'] / 1024, 1) ?> KB</td>
                                    <td>
                                        <span class="badge badge-<?= $fila['estado'] ?>">
                                            <?= $fila['es_actual'] ? 'Actual' : ucfirst($fila['estado']) ?>
                                        </span>
                                    </td>
                                    <?php if ($puedeSubir): ?>
                                    <td>
                                        <div style="display:flex; gap:.4rem; align-items:center; flex-wrap:wrap;">
                                            <a href="<?= $urlBase ?>uploads/organigrama/<?= urlencode($fila['ruta_archivo']) ?>"
                                               target="_blank" class="btn btn-sm"
                                               style="background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd;">
                                                Ver
                                            </a>
                                            <?php if ($fila['estado'] !== 'inactivo' && !$fila['es_actual']): ?>
                                            <a href="?accion=eliminar&id=<?= (int)$fila['id'] ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('¿Eliminar este registro del historial?')">
                                                Eliminar
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div><!-- /.page-body -->
    </main>
</div>
</div><!-- /.page-wrapper -->

<!-- ── Lightbox para imágenes ──────────────────────────────────── -->
<div id="lightbox" onclick="closeLightbox()">
    <button id="lightbox-close" onclick="closeLightbox()">✕</button>
    <img id="lightbox-img" src="" alt="Organigrama ampliado">
</div>

<script>
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>

</body>
</html>
