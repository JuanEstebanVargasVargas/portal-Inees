<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">
    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title>Mi Perfil — Portal INEES</title>
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
            max-width: 1100px;
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

        /* ── Cabecera de perfil ── */
        .profile-hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #083344 100%);
            border-radius: var(--radius-lg);
            padding: 32px 36px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 28px -5px rgba(11,23,40,.4);
            border: 1px solid rgba(13,148,136,.35);
        }

        .profile-hero::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(13,148,136,.3) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ── Avatar con foto ── */
        .profile-hero-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #0284c7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            flex-shrink: 0;
            border: 3px solid rgba(13,148,136,.6);
            box-shadow: 0 0 0 6px rgba(13,148,136,.15);
            position: relative;
            z-index: 1;
            overflow: hidden;
            cursor: default;
        }

        .profile-hero-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
            display: block;
        }

        /* ── Overlay de subida (solo superusuario) ── */
        .avatar-wrapper {
            position: relative;
            flex-shrink: 0;
            z-index: 1;
        }

        .avatar-upload-overlay {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: rgba(0,0,0,.55);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .22s ease;
            cursor: pointer;
            z-index: 2;
        }

        .avatar-wrapper:hover .avatar-upload-overlay { opacity: 1; }

        .avatar-upload-overlay svg { color: #fff; pointer-events: none; }

        .avatar-upload-hint {
            font-size: 10.5px;
            color: rgba(203,213,225,.75);
            margin-top: 6px;
            text-align: center;
            line-height: 1.3;
        }

        /* ── Toast de confirmación ── */
        #foto-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f172a;
            color: #fff;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,.35);
            z-index: 9999;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity .3s, transform .3s;
            pointer-events: none;
        }
        #foto-toast.show { opacity: 1; transform: translateY(0); }

        .profile-hero-info { position: relative; z-index: 1; }

        .profile-hero-name {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .profile-hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .profile-hero-tag {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid;
        }

        .tag-rol-1 { background: rgba(124,58,237,.2); color: #c084fc; border-color: rgba(192,132,252,.3); }
        .tag-rol-2 { background: rgba(13,148,136,.2); color: #2dd4bf; border-color: rgba(45,212,191,.3); }
        .tag-rol-3 { background: rgba(2,132,199,.2);  color: #38bdf8; border-color: rgba(56,189,248,.3); }

        .tag-cargo {
            background: rgba(255,255,255,.1);
            color: #cbd5e1;
            border-color: rgba(255,255,255,.2);
        }

        .tag-area {
            background: rgba(255,255,255,.07);
            color: #94a3b8;
            border-color: rgba(255,255,255,.15);
        }

        @media (max-width: 720px) {
            .profile-hero { flex-direction: column; text-align: center; padding: 24px 20px; }
            .profile-hero-meta { justify-content: center; }
        }

        /* ── Card de contenido ── */
        .pcard {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .pcard-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 24px 14px;
            border-bottom: 1px solid var(--border-light);
            background: linear-gradient(90deg, rgba(13,148,136,.05) 0%, transparent 100%);
        }

        .pcard-header-icon {
            width: 34px; height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, #0d9488, #0b7a70);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .pcard-header-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-main);
        }

        .pcard-body { padding: 22px 24px; }

        /* ── Subtítulo de sección dentro de la card ── */
        .pcard-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--primary-dark);
            margin-bottom: 14px;
        }

        .pcard-section-title.spaced { margin-top: 28px; }

        /* ── Lista de datos del perfil (2 columnas) ── */
        .data-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 48px;
            row-gap: 14px;
        }

        .data-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-light);
        }

        .data-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-muted);
            min-width: 120px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .data-value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-main);
            text-align: right;
            word-break: break-all;
        }

        .data-value.highlight { color: var(--primary); }

        /* ── Campos confidenciales (ojito) ── */
        .secret-wrap {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-end;
        }

        .secret-value { letter-spacing: .5px; font-variant-numeric: tabular-nums; }

        .eye-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            width: 28px; height: 28px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .2s, color .2s;
        }
        .eye-btn:hover { background: var(--primary-light); color: var(--primary); }
        .eye-btn:focus-visible { outline: 2px solid var(--primary); outline-offset: 1px; }
        .eye-btn .eye-off { display: none; }
        .eye-btn.revealed .eye-on  { display: none; }
        .eye-btn.revealed .eye-off { display: block; }

        /* ── Sección de Seguridad (2 columnas) ── */
        .security-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-light);
            background: #fafcff;
            transition: border-color .2s, background .2s;
        }

        .security-item:hover { border-color: var(--primary); background: #f0fdfa; }

        .security-item-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .icon-pwd  { background: #fef3c7; }
        .icon-lock { background: #dbeafe; }

        .security-item-text { flex: 1; }
        .security-item-title { font-size: 14px; font-weight: 700; color: var(--text-main); }
        .security-item-desc  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        .security-item-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #0d9488, #0b7a70);
            color: #ffffff;
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 600;
            white-space: nowrap;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .security-item-btn:hover { background: linear-gradient(135deg, #0b7a70, #096056); transform: translateY(-1px); box-shadow: 0 4px 10px rgba(13,148,136,.3); }

        .status-badge {
            font-size: 12px;
            font-weight: 700;
            color: #059669;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 6px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        @media (max-width: 720px) {
            .data-list,
            .security-section { grid-template-columns: 1fr; }
        }

        /* ── Última sesión ── */
        .last-session-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
        }

        /* ── Footer ── */
        footer {
            background: #0b1728;
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 18px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: auto;
        }
    </style>
</head>
<body>

<?php
// Navbar y sidebar (perfilVista.php está en vistas/, los partials en vistas/partials/)
require_once __DIR__ . '/partials/navbar/navbar.php';
require_once __DIR__ . '/partials/sidebar/sidebar.php';
?>

<main>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="../../index.php">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Inicio
        </a>
        <span class="breadcrumb-sep">›</span>
        <span>Mi Perfil</span>
    </nav>

    <?php
    // Variables auxiliares
    $inicial = mb_strtoupper(mb_substr(trim($perfil['nombre']), 0, 1));

    $tagRolClass = match($rol_id) {
        1 => 'tag-rol-1',
        2 => 'tag-rol-2',
        default => 'tag-rol-3',
    };

    // Enmascara un valor confidencial: ••••••1234 (muestra solo los últimos 3 si es largo)
    function enmascarar(string $valor): string {
        $len = mb_strlen($valor);
        return str_repeat('•', max($len, 4));
    }

    // Campo confidencial con botón "ojito"
    function campoSecreto(string $valor): string {
        $real = htmlspecialchars($valor, ENT_QUOTES);
        $mask = enmascarar($valor);
        return '<span class="secret-wrap">'
             . '<span class="secret-value" data-real="' . $real . '" data-mask="' . $mask . '">' . $mask . '</span>'
             . '<button type="button" class="eye-btn" aria-label="Mostrar dato" aria-pressed="false">'
             . '<svg class="eye-on" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>'
             . '<svg class="eye-off" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'
             . '</button></span>';
    }

    $ultimoAccesoFmt = '—';
    if (!empty($perfil['ultimo_acceso'])) {
        $dt = new DateTime($perfil['ultimo_acceso']);
        $ultimoAccesoFmt = $dt->format('d M Y, H:i');
    }
    ?>

    <!-- Hero de perfil -->
    <div class="profile-hero">

        <?php
        $fotoSrc = !empty($perfil['foto_perfil'])
            ? '../../' . htmlspecialchars($perfil['foto_perfil'], ENT_QUOTES) . '?v=' . time()
            : null;
        ?>

        <?php if ($esSuperUsuario): ?>
        <!-- Avatar con overlay de subida (solo SuperUsuario) -->
        <div style="display:flex;flex-direction:column;align-items:center;gap:4px;z-index:1;flex-shrink:0;">
            <div class="avatar-wrapper" id="avatarWrapper" title="Cambiar foto de perfil">
                <div class="profile-hero-avatar" id="avatarCircle">
                    <?php if ($fotoSrc): ?>
                        <img id="avatarImg" src="<?= $fotoSrc ?>" alt="Foto de <?= htmlspecialchars($perfil['nombre']) ?>">
                    <?php else: ?>
                        <span id="avatarInitial"><?= htmlspecialchars($inicial) ?></span>
                    <?php endif; ?>
                </div>
                <div class="avatar-upload-overlay" onclick="document.getElementById('inputFoto').click()">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                </div>
                <input type="file" id="inputFoto" accept="image/jpeg,image/png,image/webp"
                       style="display:none;" onchange="subirFoto(this)">
            </div>
            <span class="avatar-upload-hint">Cambiar foto</span>
        </div>

        <?php else: ?>
        <!-- Avatar estático (otros roles) -->
        <div class="profile-hero-avatar" style="flex-shrink:0;">
            <?php if ($fotoSrc): ?>
                <img src="<?= $fotoSrc ?>" alt="Foto de <?= htmlspecialchars($perfil['nombre']) ?>"
                     style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <?php else: ?>
                <?= htmlspecialchars($inicial) ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="profile-hero-info">
            <div class="profile-hero-name"><?= htmlspecialchars($perfil['nombre']) ?></div>
            <div class="profile-hero-meta">
                <span class="profile-hero-tag <?= $tagRolClass ?>">
                    <?php
                    $iconoRol = match($rol_id) { 1 => '👑', 2 => '💼', default => '👤' };
                    echo $iconoRol . ' ' . htmlspecialchars($rol_nombre);
                    ?>
                </span>
                <?php if (!empty($perfil['cargo'])): ?>
                <span class="profile-hero-tag tag-cargo">
                    <?= htmlspecialchars($perfil['cargo']) ?>
                </span>
                <?php endif; ?>
                <?php if (!empty($perfil['area']) && $perfil['area'] !== 'ninguno'): ?>
                <span class="profile-hero-tag tag-area">
                    📍 <?= htmlspecialchars($perfil['area']) ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if ($ultimoAccesoFmt !== '—'): ?>
            <div style="margin-top: 12px;">
                <span class="last-session-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Último acceso: <?= $ultimoAccesoFmt ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Toast feedback -->
    <div id="foto-toast">
        <span id="foto-toast-icon">✓</span>
        <span id="foto-toast-msg">Foto actualizada correctamente.</span>
    </div>

    <!-- Card única: Perfil y Seguridad -->
    <div class="pcard">
        <div class="pcard-header">
            <div class="pcard-header-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span class="pcard-header-title">Perfil y Seguridad</span>
        </div>

        <div class="pcard-body">

            <!-- Datos personales -->
            <div class="pcard-section-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Datos Personales
            </div>

            <div class="data-list">
                <div class="data-row">
                    <span class="data-label">Nombre Completo</span>
                    <span class="data-value"><?= htmlspecialchars($perfil['nombre']) ?></span>
                </div>
                <div class="data-row">
                    <span class="data-label">Cédula</span>
                    <span class="data-value highlight">
                        <?php if (!empty($perfil['cedula'])): ?>
                            <?= campoSecreto((string)$perfil['cedula']) ?>
                        <?php else: ?>
                            No registrada
                        <?php endif; ?>
                    </span>
                </div>
                <div class="data-row">
                    <span class="data-label">Usuario</span>
                    <span class="data-value">@<?= htmlspecialchars($perfil['usuario']) ?></span>
                </div>
                <div class="data-row">
                    <span class="data-label">Cargo</span>
                    <span class="data-value"><?= htmlspecialchars($perfil['cargo'] ?? 'No especificado') ?></span>
                </div>
                <div class="data-row">
                    <span class="data-label">Área / Depto.</span>
                    <span class="data-value"><?= htmlspecialchars($perfil['area'] ?? 'General') ?></span>
                </div>
                <div class="data-row">
                    <span class="data-label">Correo</span>
                    <span class="data-value highlight" style="font-size:12.5px;"><?= htmlspecialchars($perfil['email'] ?? 'No registrado') ?></span>
                </div>
                <div class="data-row">
                    <span class="data-label">Teléfono</span>
                    <span class="data-value">
                        <?php if (!empty($perfil['celular'])): ?>
                            <?= campoSecreto((string)$perfil['celular']) ?>
                        <?php else: ?>
                            No registrado
                        <?php endif; ?>
                    </span>
                </div>
                <div class="data-row">
                    <span class="data-label">Teléfono Corporativo</span>
                    <span class="data-value">
                        <?php if (!empty($perfil['telefono_corporativo'])): ?>
                            <?= htmlspecialchars($perfil['telefono_corporativo']) ?>
                        <?php else: ?>
                            No registrado
                        <?php endif; ?>
                    </span>
                </div>
                <div class="data-row">
                    <span class="data-label">Rol del Sistema</span>
                    <span class="data-value"><?= htmlspecialchars($rol_nombre) ?></span>
                </div>
            </div>

            <!-- Seguridad de la cuenta -->
            <div class="pcard-section-title spaced">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Seguridad de la Cuenta
            </div>

            <div class="security-section">

                <!-- Contraseña -->
                <div class="security-item">
                    <div class="security-item-icon icon-pwd">🔑</div>
                    <div class="security-item-text">
                        <div class="security-item-title">Contraseña</div>
                        <div class="security-item-desc">
                            <?php if (!empty($perfil['pwd_ultimo_cambio'])): ?>
                                Último cambio: <?= (new DateTime($perfil['pwd_ultimo_cambio']))->format('d M Y') ?>
                            <?php else: ?>
                                Sin registros de cambio
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="../../controladores/login/cambiarPasswordControlador.php" class="security-item-btn">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Cambiar
                    </a>
                </div>

                <!-- Estado de la cuenta -->
                <div class="security-item">
                    <div class="security-item-icon icon-lock">🛡️</div>
                    <div class="security-item-text">
                        <div class="security-item-title">Estado de la Cuenta</div>
                        <div class="security-item-desc">
                            Cuenta <?= $perfil['estado'] === 'activo' ? 'activa y verificada' : 'inactiva' ?>
                        </div>
                    </div>
                    <span class="status-badge">
                        ✓ <?= ucfirst($perfil['estado']) ?>
                    </span>
                </div>

            </div>
        </div>
    </div>

</main>

<script>
/* ── Revelar campos confidenciales ── */
document.querySelectorAll('.eye-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var valor = btn.parentElement.querySelector('.secret-value');
        var visible = btn.classList.toggle('revealed');
        valor.textContent = visible ? valor.dataset.real : valor.dataset.mask;
        btn.setAttribute('aria-pressed', visible);
        btn.setAttribute('aria-label', visible ? 'Ocultar dato' : 'Mostrar dato');
    });
});

/* ── Toast helper ── */
function mostrarToast(msg, ok) {
    var t   = document.getElementById('foto-toast');
    var ico = document.getElementById('foto-toast-icon');
    var txt = document.getElementById('foto-toast-msg');
    if (!t) return;
    ico.textContent = ok ? '✓' : '✕';
    txt.textContent = msg;
    t.style.borderLeft = ok ? '4px solid #10b981' : '4px solid #ef4444';
    t.classList.add('show');
    clearTimeout(t._timer);
    t._timer = setTimeout(function () { t.classList.remove('show'); }, 3500);
}

/* ── Subir foto (solo SuperUsuario) ── */
function subirFoto(input) {
    if (!input.files || !input.files[0]) return;

    var file     = input.files[0];
    var maxBytes = 3 * 1024 * 1024;

    if (file.size > maxBytes) {
        mostrarToast('El archivo pesa más de 3 MB.', false);
        input.value = '';
        return;
    }

    var tipos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!tipos.includes(file.type)) {
        mostrarToast('Solo se permiten imágenes JPG, PNG o WEBP.', false);
        input.value = '';
        return;
    }

    /* Vista previa inmediata */
    var reader = new FileReader();
    reader.onload = function (e) {
        var circle = document.getElementById('avatarCircle');
        var init   = document.getElementById('avatarInitial');
        var img    = document.getElementById('avatarImg');

        if (!img) {
            img = document.createElement('img');
            img.id = 'avatarImg';
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:50%;';
            circle.innerHTML = '';
            circle.appendChild(img);
        }
        img.src = e.target.result;
        if (init) init.remove();
    };
    reader.readAsDataURL(file);

    /* Subida al servidor */
    var fd = new FormData();
    fd.append('foto', file);
    fd.append('target_usuario_id', <?= (int)$usuario_id ?>);

    fetch('../../controladores/perfil/subirFotoControlador.php', {
        method : 'POST',
        body   : fd,
        credentials: 'same-origin'
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.ok) {
            mostrarToast(data.msg, true);
            /* Actualizar avatar principal de la vista con cache-buster */
            var img = document.getElementById('avatarImg');
            if (img && data.src) img.src = data.src;

            /* Actualizar en tiempo real el avatar de la Navbar */
            var navContainer = document.getElementById('navbarAvatarContainer');
            if (navContainer && data.src) {
                navContainer.innerHTML = '<img src="' + data.src + '" alt="Foto" class="navbar-avatar-img" id="navbarAvatarImg">';
            }

            /* Actualizar en tiempo real el avatar del Menú Lateral (Sidebar) */
            var sideContainer = document.getElementById('sidebarAvatarContainer');
            if (sideContainer && data.src) {
                sideContainer.innerHTML = '<img src="' + data.src + '" alt="Foto" class="sidebar-avatar-img" id="sidebarAvatarImg">';
            }
        } else {
            mostrarToast(data.msg || 'Error al subir la foto.', false);
        }
    })
    .catch(function () {
        mostrarToast('Error de red al subir la foto.', false);
    })
    .finally(function () {
        input.value = '';
    });
}
</script>

<footer>
    Portal INEES &copy; <?= date('Y') ?> &mdash; Sistema Integrado de Gestión y Control Operativo
</footer>

</body>
</html>