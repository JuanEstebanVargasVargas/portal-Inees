<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../img/logo.png">
    <title>Cambiar Contraseña — Portal INEES</title>
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
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: var(--bg-page); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; }
        main { max-width: 680px; width: 100%; margin: 0 auto; padding: 32px 20px 60px; flex: 1; }

        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }
        .breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb-sep { color: var(--border); }

        .hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #1a1040 100%);
            border-radius: var(--radius-lg);
            padding: 30px 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-lg);
        }
        .hero-icon {
            width: 54px; height: 54px;
            background: rgba(13,148,136,.25);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(13,148,136,.4);
            font-size: 26px;
            flex-shrink: 0;
        }
        .hero-title { font-size: 22px; font-weight: 700; color: #fff; }
        .hero-sub { font-size: 13px; color: rgba(255,255,255,.65); margin-top: 4px; }

        .card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 28px 32px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        label { font-size: 13px; font-weight: 600; color: var(--text-main); }
        label .req { color: #ef4444; }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-wrap input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            color: var(--text-main);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-wrap input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,.12);
        }
        .toggle-pwd {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
            font-size: 15px;
        }

        .form-hint { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
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

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border-light);
        }
    </style>
</head>
<body>
<?php
require_once __DIR__ . '/../partials/navbar/navbar.php';
require_once __DIR__ . '/../partials/sidebar/sidebar.php';
?>

<main>
    <nav class="breadcrumb">
        <a href="<?= $urlBase ?>index.php">Inicio</a>
        <span class="breadcrumb-sep">›</span>
        <a href="<?= $urlBase ?>controladores/perfil/perfilControlador.php">Mi Perfil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Cambiar mi Contraseña</span>
    </nav>

    <div class="hero">
        <div class="hero-icon">🔑</div>
        <div>
            <div class="hero-title">Actualizar Contraseña</div>
            <div class="hero-sub">Mantén tu cuenta segura cambiando periódicamente tu clave de acceso.</div>
        </div>
    </div>

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

    <div class="card">
        <form method="POST" action="cambiarPasswordControlador.php">
            <div class="form-group">
                <label for="password_actual">Contraseña Actual <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="password_actual" id="password_actual" required autocomplete="current-password" placeholder="Tu contraseña actual">
                    <button type="button" class="toggle-pwd" onclick="toggleVis('password_actual')">👁️</button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_nueva">Nueva Contraseña <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="password_nueva" id="password_nueva" required autocomplete="new-password" placeholder="Mínimo 6 caracteres">
                    <button type="button" class="toggle-pwd" onclick="toggleVis('password_nueva')">👁️</button>
                </div>
                <div class="form-hint">Se recomienda usar letras mayúsculas, minúsculas, números y símbolos.</div>
            </div>

            <div class="form-group">
                <label for="password_confirmar">Confirmar Nueva Contraseña <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="password_confirmar" id="password_confirmar" required autocomplete="new-password" placeholder="Repite la nueva contraseña">
                    <button type="button" class="toggle-pwd" onclick="toggleVis('password_confirmar')">👁️</button>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= $urlBase ?>index.php" class="btn btn-outline">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Actualizar Contraseña
                </button>
            </div>
        </form>
    </div>
</main>

<script>
function toggleVis(id) {
    const inp = document.getElementById(id);
    if (inp) {
        inp.type = (inp.type === 'password') ? 'text' : 'password';
    }
}
</script>
</body>
</html>
