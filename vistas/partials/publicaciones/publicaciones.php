<?php
/**
 * Partial: Widget de Publicaciones Institucionales con soporte de media
 * - Gestión Humana (nivel_acceso=2): puede publicar (texto + imagen/video opcionales)
 * - SuperUsuario (nivel_acceso=1) y Empleado (nivel_acceso=3): solo ver
 *
 * Variables esperadas del controlador padre:
 *   $publicaciones  → array de publicaciones (PublicacionModelo::obtenerPublicaciones)
 *   $nivelAcceso    → int del usuario actual
 *   $perfil         → array con datos del usuario (nombre, etc.)
 */

if (!defined('PUB_STYLES_LOADED')) {
    define('PUB_STYLES_LOADED', true);
    ?>
    <style>
    /* ===== Widget de Publicaciones ===== */
    .pub-widget {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        margin-bottom: 28px;
        overflow: hidden;
    }

    .pub-widget-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px 14px 24px;
        border-bottom: 1px solid var(--border-light);
        background: linear-gradient(90deg, rgba(13,148,136,0.06) 0%, transparent 100%);
    }

    .pub-widget-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pub-widget-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #0d9488, #0b7a70);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        flex-shrink: 0;
    }

    .pub-widget-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
    }

    .pub-widget-subtitle {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .pub-widget-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        background: #ccfbf1;
        color: #0f766e;
        border: 1px solid #99f6e4;
        white-space: nowrap;
    }

    /* ===== Formulario de creación ===== */
    .pub-compose {
        padding: 18px 24px 20px;
        border-bottom: 1px solid var(--border-light);
        background: #f8fffe;
    }

    .pub-compose-top {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .pub-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488, #0b1728);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
        flex-shrink: 0;
    }

    .pub-compose-fields {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .pub-input-titulo {
        width: 100%;
        padding: 9px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        background: #ffffff;
        transition: border-color .2s;
        outline: none;
        font-family: inherit;
    }

    .pub-input-titulo::placeholder { font-weight: 400; color: #a0aec0; }
    .pub-input-titulo:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,148,136,.12); }

    .pub-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        color: var(--text-main);
        background: #ffffff;
        resize: vertical;
        min-height: 80px;
        max-height: 200px;
        transition: border-color .2s;
        outline: none;
        font-family: inherit;
        line-height: 1.55;
    }

    .pub-textarea::placeholder { color: #a0aec0; }
    .pub-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,148,136,.12); }

    /* ===== Zona de carga de media ===== */
    .pub-media-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        background: #ffffff;
        transition: border-color .2s, background .2s;
        cursor: pointer;
        position: relative;
    }

    .pub-media-zone:hover,
    .pub-media-zone.drag-over {
        border-color: var(--primary);
        background: #f0fdfa;
    }

    .pub-media-zone-inner {
        display: flex;
        align-items: center;
        gap: 12px;
        pointer-events: none;
    }

    .pub-media-zone-icon {
        display: flex;
        gap: 8px;
        align-items: center;
        color: var(--text-muted);
    }

    .pub-media-zone-text {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.45;
    }

    .pub-media-zone-text strong {
        color: var(--primary);
    }

    .pub-media-zone-hint {
        font-size: 11px;
        color: #a0aec0;
        margin-top: 2px;
    }

    .pub-media-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    /* Preview de media seleccionada */
    .pub-preview {
        display: none;
        position: relative;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: #000;
        max-height: 260px;
    }

    .pub-preview.visible { display: block; }

    .pub-preview img,
    .pub-preview video {
        width: 100%;
        max-height: 260px;
        object-fit: contain;
        display: block;
    }

    .pub-preview-remove {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        background: rgba(0,0,0,.65);
        border: none;
        border-radius: 50%;
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: background .2s;
    }

    .pub-preview-remove:hover { background: rgba(220,38,38,.85); }

    .pub-preview-name {
        padding: 6px 10px;
        font-size: 11.5px;
        color: #e2e8f0;
        background: rgba(0,0,0,.5);
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== Barra de acciones del formulario ===== */
    .pub-compose-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 12px;
    }

    .pub-char-counter {
        font-size: 11px;
        color: var(--text-muted);
        margin-right: auto;
    }

    .pub-char-counter.warn   { color: #e67e22; }
    .pub-char-counter.danger { color: #e53e3e; }

    .pub-btn-cancel {
        padding: 8px 18px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        background: transparent;
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
        font-family: inherit;
    }
    .pub-btn-cancel:hover { background: #f1f5f9; border-color: #cbd5e0; }

    .pub-btn-publish {
        padding: 8px 22px;
        background: linear-gradient(135deg, #0d9488, #0b7a70);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: inherit;
    }
    .pub-btn-publish:hover { background: linear-gradient(135deg, #0b7a70, #096056); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,.35); }
    .pub-btn-publish:disabled { opacity: .6; cursor: not-allowed; transform: none; }

    /* ===== Feed de publicaciones ===== */
    .pub-feed { padding: 0; }

    .pub-feed-empty {
        padding: 40px 24px;
        text-align: center;
        color: var(--text-muted);
    }

    .pub-feed-empty svg { opacity: .3; margin-bottom: 10px; }
    .pub-feed-empty p { font-size: 14px; }

    .pub-item {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border-light);
        transition: background .15s;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .pub-item:last-child { border-bottom: none; }
    .pub-item:hover { background: #f8fffe; }

    .pub-item-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488, #0b1728);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: #ffffff;
        flex-shrink: 0;
    }

    .pub-item-body { flex: 1; min-width: 0; }

    .pub-item-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
        flex-wrap: wrap;
    }

    .pub-item-author {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-main);
    }

    .pub-item-role-badge {
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
        background: #ccfbf1;
        color: #0f766e;
        border: 1px solid #99f6e4;
    }

    .pub-item-date {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-left: auto;
        white-space: nowrap;
    }

    .pub-item-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 5px;
    }

    .pub-item-content {
        font-size: 13.5px;
        color: var(--text-muted);
        line-height: 1.6;
        word-break: break-word;
        margin-bottom: 10px;
    }

    /* Media en el feed */
    .pub-item-media {
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: #f1f5f9;
        margin-top: 4px;
        max-height: 380px;
    }

    .pub-item-media img {
        width: 100%;
        max-height: 380px;
        object-fit: cover;
        display: block;
        border-radius: var(--radius-sm);
        cursor: zoom-in;
        transition: opacity .2s;
    }

    .pub-item-media img:hover { opacity: .92; }

    .pub-item-media video {
        width: 100%;
        max-height: 380px;
        display: block;
        border-radius: var(--radius-sm);
        background: #000;
    }

    /* Alertas */
    .pub-alert {
        margin: 14px 24px 0 24px;
        padding: 10px 16px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pub-alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .pub-alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    /* Lightbox simple */
    .pub-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.88);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .pub-lightbox.open { display: flex; }

    .pub-lightbox img {
        max-width: 94vw;
        max-height: 90vh;
        object-fit: contain;
        border-radius: var(--radius-md);
        box-shadow: 0 20px 60px rgba(0,0,0,.5);
    }

    .pub-lightbox-close {
        position: absolute;
        top: 16px;
        right: 20px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
    }

    .pub-lightbox-close:hover { background: rgba(220,38,38,.7); }

    @media (max-width: 600px) {
        .pub-widget-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .pub-item { padding: 14px 16px; }
        .pub-item-date { margin-left: 0; }
        .pub-compose { padding: 14px 16px 16px; }
    }
    </style>
    <?php
}

// ─── Variables locales ────────────────────────────────────────────────────────
$_nivelAcc = (int)($nivelAcceso ?? $_SESSION['nivel_acceso'] ?? 0);
$_esGH     = ($_nivelAcc === 2);
$_esSG     = ($_nivelAcc === 5);
$_puedePublicar = ($_esGH || $_esSG);
$_nombre   = $perfil['nombre'] ?? $_SESSION['nombre'] ?? 'Usuario';
$_inicial  = mb_strtoupper(mb_substr(trim($_nombre), 0, 1));

$_pubOk  = isset($_GET['pub_ok']);
$_pubErr = $_GET['pub_error'] ?? null;

$_errMensajes = [
    'campos_vacios'   => 'Completa el título y el contenido antes de publicar.',
    'titulo_largo'    => 'El título no puede superar 255 caracteres.',
    'tipo_no_permitido' => 'Solo se permiten imágenes (JPG, PNG, GIF, WEBP) y videos (MP4, WEBM, MOV).',
    'archivo_grande'  => 'El archivo supera el límite: 15 MB para imágenes, 100 MB para videos.',
    'subida_parcial'  => 'La subida del archivo fue interrumpida. Intenta de nuevo.',
    'error_servidor'  => 'Error interno al guardar el archivo. Contacta al administrador.',
    'db_fail'         => 'Error al guardar el comunicado. Intenta de nuevo.',
    'upload_error'    => 'Ocurrió un error al subir el archivo.',
];

// Ruta base para mostrar imágenes/videos (relativa al HTML)
$_baseMedia = 'img/publicaciones/';
?>

<!-- Lightbox para imágenes -->
<div class="pub-lightbox" id="pub-lightbox" onclick="this.classList.remove('open')">
    <button class="pub-lightbox-close" onclick="document.getElementById('pub-lightbox').classList.remove('open')">✕</button>
    <img src="" id="pub-lightbox-img" alt="Imagen publicación">
</div>

<div class="pub-widget">
    <!-- Cabecera -->
    <div class="pub-widget-header">
        <div class="pub-widget-header-left">
            <div class="pub-widget-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <div class="pub-widget-title">Tablero de Comunicados</div>
                <div class="pub-widget-subtitle">Noticias y avisos institucionales</div>
            </div>
        </div>
        <div class="pub-widget-badge">
            <?php if ($_esSG): ?>
                ✏️ Sistema de Gestión
            <?php elseif ($_esGH): ?>
                ✏️ Gestión Humana
            <?php else: ?>
                📋 Solo lectura
            <?php endif; ?>
        </div>
    </div>

    <!-- Alertas de feedback -->
    <?php if ($_pubOk): ?>
        <div class="pub-alert pub-alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            ¡Comunicado publicado exitosamente!
        </div>
    <?php elseif ($_pubErr && isset($_errMensajes[$_pubErr])): ?>
        <div class="pub-alert pub-alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?= htmlspecialchars($_errMensajes[$_pubErr]) ?>
        </div>
    <?php endif; ?>

    <!-- Formulario (Gestión Humana y Sistema de Gestión pueden publicar) -->
    <?php if ($_puedePublicar): ?>
    <div class="pub-compose">
        <form method="POST"
              action="controladores/publicaciones/publicacionControlador.php"
              id="pub-form"
              enctype="multipart/form-data"
              autocomplete="off">

            <div class="pub-compose-top">
                <div class="pub-avatar"><?= htmlspecialchars($_inicial) ?></div>
                <div class="pub-compose-fields">
                    <!-- Título -->
                    <input type="text"
                           name="titulo"
                           id="pub-titulo"
                           class="pub-input-titulo"
                           placeholder="Título del comunicado..."
                           maxlength="255"
                           required>

                    <!-- Contenido -->
                    <textarea name="contenido"
                              id="pub-contenido"
                              class="pub-textarea"
                              placeholder="¿Qué deseas comunicar a los colaboradores?"
                              required
                              maxlength="3000"></textarea>

                    <!-- Zona de carga de media -->
                    <div class="pub-media-zone" id="pub-media-zone">
                        <div class="pub-media-zone-inner">
                            <div class="pub-media-zone-icon">
                                <!-- Ícono imagen -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                <!-- Ícono video -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <polygon points="23 7 16 12 23 17 23 7"/>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                                </svg>
                            </div>
                            <div class="pub-media-zone-text">
                                <strong>Agregar imagen o video</strong> — arrastra aquí o haz clic
                                <div class="pub-media-zone-hint">JPG, PNG, GIF, WEBP hasta 15 MB · MP4, WEBM, MOV hasta 100 MB</div>
                            </div>
                        </div>
                        <input type="file"
                               name="media"
                               id="pub-media-input"
                               class="pub-media-input"
                               accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm,video/quicktime,video/x-msvideo">
                    </div>

                    <!-- Preview del archivo seleccionado -->
                    <div class="pub-preview" id="pub-preview">
                        <button type="button" class="pub-preview-remove" id="pub-preview-remove" title="Quitar archivo">✕</button>
                        <div id="pub-preview-content"></div>
                        <div class="pub-preview-name" id="pub-preview-name"></div>
                    </div>
                </div>
            </div>

            <!-- Barra de acciones -->
            <div class="pub-compose-actions">
                <span class="pub-char-counter" id="pub-counter">0 / 3000</span>
                <button type="button" class="pub-btn-cancel" id="pub-btn-cancel">Cancelar</button>
                <button type="submit" class="pub-btn-publish" id="pub-submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Publicar
                </button>
            </div>
        </form>
    </div>

    <script>
    (function() {
        'use strict';

        var ta       = document.getElementById('pub-contenido');
        var counter  = document.getElementById('pub-counter');
        var input    = document.getElementById('pub-media-input');
        var zone     = document.getElementById('pub-media-zone');
        var preview  = document.getElementById('pub-preview');
        var previewC = document.getElementById('pub-preview-content');
        var previewN = document.getElementById('pub-preview-name');
        var btnRem   = document.getElementById('pub-preview-remove');
        var btnCancel= document.getElementById('pub-btn-cancel');
        var form     = document.getElementById('pub-form');
        var btnSub   = document.getElementById('pub-submit');

        // Contador de caracteres
        if (ta && counter) {
            ta.addEventListener('input', function() {
                var l = ta.value.length;
                counter.textContent = l + ' / 3000';
                counter.className   = 'pub-char-counter' +
                    (l > 2700 ? ' danger' : l > 2400 ? ' warn' : '');
            });
        }

        // Preview de archivo
        function mostrarPreview(file) {
            if (!file) return;
            previewC.innerHTML = '';
            var url = URL.createObjectURL(file);
            var el;
            if (file.type.startsWith('video/')) {
                el = document.createElement('video');
                el.src = url;
                el.controls = true;
                el.preload  = 'metadata';
            } else {
                el = document.createElement('img');
                el.src = url;
                el.alt = file.name;
            }
            previewC.appendChild(el);
            previewN.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            preview.classList.add('visible');
            zone.style.display = 'none';
        }

        function limpiarMedia() {
            previewC.innerHTML = '';
            previewN.textContent = '';
            preview.classList.remove('visible');
            zone.style.display = '';
            if (input) {
                // Resetear el input de archivo creando uno nuevo
                var newInput = input.cloneNode(true);
                input.parentNode.replaceChild(newInput, input);
                input = newInput;
                input.addEventListener('change', onFileChange);
            }
        }

        function onFileChange() {
            if (input.files && input.files[0]) {
                mostrarPreview(input.files[0]);
            }
        }

        if (input) {
            input.addEventListener('change', onFileChange);
        }

        // Drag & drop
        if (zone) {
            zone.addEventListener('dragover', function(e) {
                e.preventDefault();
                zone.classList.add('drag-over');
            });
            zone.addEventListener('dragleave', function() {
                zone.classList.remove('drag-over');
            });
            zone.addEventListener('drop', function(e) {
                e.preventDefault();
                zone.classList.remove('drag-over');
                var files = e.dataTransfer.files;
                if (files && files[0]) {
                    // Asignar al input
                    try {
                        var dt = new DataTransfer();
                        dt.items.add(files[0]);
                        input.files = dt.files;
                    } catch(err) {}
                    mostrarPreview(files[0]);
                }
            });
        }

        // Quitar media
        if (btnRem) {
            btnRem.addEventListener('click', limpiarMedia);
        }

        // Cancelar: limpiar todo el formulario
        if (btnCancel) {
            btnCancel.addEventListener('click', function() {
                document.getElementById('pub-titulo').value    = '';
                if (ta) ta.value = '';
                if (counter) { counter.textContent = '0 / 3000'; counter.className = 'pub-char-counter'; }
                limpiarMedia();
            });
        }

        // Deshabilitar botón al enviar
        if (form) {
            form.addEventListener('submit', function() {
                btnSub.disabled     = true;
                btnSub.textContent  = 'Publicando...';
            });
        }
    })();
    </script>
    <?php endif; ?>

    <!-- Feed de publicaciones -->
    <div class="pub-feed">
        <?php if (empty($publicaciones)): ?>
            <div class="pub-feed-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p>Aún no hay comunicados publicados.</p>
            </div>
        <?php else: ?>
            <?php foreach ($publicaciones as $pub):
                $fechaDT    = new DateTime($pub['fecha_publicacion']);
                $fechaLabel = $fechaDT->format('d M Y, H:i');
                $inicialPub = mb_strtoupper(mb_substr(trim($pub['autor_nombre']), 0, 1));
                $tieneMedia = !empty($pub['media_archivo']) && $pub['media_tipo'] !== 'ninguno';
            ?>
            <div class="pub-item">
                <div class="pub-item-avatar"><?= htmlspecialchars($inicialPub) ?></div>
                <div class="pub-item-body">
                    <div class="pub-item-meta">
                        <span class="pub-item-author"><?= htmlspecialchars($pub['autor_nombre']) ?></span>
                        <?php
                            $badgeRol = 'Gestión Humana';
                            $badgeStyle = '';
                            $nivelAutor = (int)($pub['autor_nivel'] ?? 2);
                            if ($nivelAutor === 5) {
                                $badgeRol = 'Sistema de Gestión';
                                $badgeStyle = 'background:#d1fae5;color:#065f46;border-color:#6ee7b7;';
                            }
                        ?>
                        <span class="pub-item-role-badge" style="<?= $badgeStyle ?>"><?= htmlspecialchars($badgeRol) ?></span>
                        <span class="pub-item-date"><?= htmlspecialchars($fechaLabel) ?></span>
                    </div>
                    <div class="pub-item-title"><?= htmlspecialchars($pub['titulo']) ?></div>
                    <div class="pub-item-content"><?= nl2br(htmlspecialchars($pub['contenido'])) ?></div>

                    <?php if ($tieneMedia): ?>
                    <div class="pub-item-media">
                        <?php
                        $archivoUrl = htmlspecialchars($_baseMedia . $pub['media_archivo']);
                        if ($pub['media_tipo'] === 'imagen'): ?>
                            <img src="<?= $archivoUrl ?>"
                                 alt="<?= htmlspecialchars($pub['titulo']) ?>"
                                 loading="lazy"
                                 onclick="
                                     var lb = document.getElementById('pub-lightbox');
                                     document.getElementById('pub-lightbox-img').src = this.src;
                                     lb.classList.add('open');
                                 ">
                        <?php elseif ($pub['media_tipo'] === 'video'): ?>
                            <video controls preload="metadata" playsinline>
                                <source src="<?= $archivoUrl ?>" type="video/mp4">
                                Tu navegador no soporta reproducción de video.
                            </video>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
