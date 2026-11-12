<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - INEES Portal</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            background: #0b1220;
            color: #f1f5f9;
        }

        /* ---------- Panel izquierdo (marca) ---------- */
        .brand-panel {
            flex: 1 1 60%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow: hidden;
            background:
                radial-gradient(circle at 20% 15%, rgba(37, 99, 235, 0.25), transparent 45%),
                radial-gradient(circle at 85% 90%, rgba(14, 165, 233, 0.18), transparent 40%),
                #0b1220;
        }
        .brand-logo {
            position: absolute;
            top: 32px;
            left: 32px;
            width: 56px;
            height: 56px;
            object-fit: contain;
        }
        .brand-headline {
            font-size: clamp(32px, 3.6vw, 52px);
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: -1px;
            text-align: center;
            max-width: 520px;
        }
        .brand-headline span {
            background: linear-gradient(90deg, #60a5fa, #22d3ee);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Ilustración hecha con CSS (tarjetas apiladas) */
        .stack {
            position: relative;
            width: 340px;
            height: 300px;
            margin-top: 56px;
        }
        .stack .card {
            position: absolute;
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: rgba(30, 41, 59, 0.75);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.4);
            padding: 18px;
        }
        .stack .card.back-left {
            width: 170px; height: 230px;
            left: 0; top: 40px;
            transform: rotate(-8deg);
            background: rgba(30, 41, 59, 0.55);
        }
        .stack .card.back-right {
            width: 170px; height: 230px;
            right: 0; top: 40px;
            transform: rotate(8deg);
            background: rgba(30, 41, 59, 0.55);
        }
        .stack .card.front {
            width: 200px; height: 280px;
            left: 70px; top: 0;
            background: linear-gradient(160deg, #1e3a8a 0%, #1e293b 70%);
            z-index: 2;
        }
        .line {
            height: 10px;
            border-radius: 6px;
            background: rgba(226, 232, 240, 0.25);
            margin-bottom: 12px;
        }
        .line.w60 { width: 60%; }
        .line.w80 { width: 80%; }
        .line.accent { background: #3b82f6; width: 40%; }
        .badge {
            position: absolute;
            z-index: 3;
            right: -6px;
            top: 26px;
            background: #22c55e;
            color: #fff;
            font-size: 18px;
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
        }

        /* ---------- Animaciones ---------- */

        /* Luces de fondo que se desplazan lentamente */
        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.55;
            pointer-events: none;
        }
        .brand-panel::before {
            width: 380px; height: 380px;
            background: #2563eb;
            top: -120px; left: -100px;
            animation: drift1 14s ease-in-out infinite alternate;
        }
        .brand-panel::after {
            width: 320px; height: 320px;
            background: #06b6d4;
            bottom: -120px; right: -80px;
            animation: drift2 17s ease-in-out infinite alternate;
        }
        .brand-headline,
        .stack {
            position: relative;
            z-index: 1;
        }
        .brand-logo { z-index: 1; }

        @keyframes drift1 {
            to { transform: translate(160px, 120px) scale(1.15); }
        }
        @keyframes drift2 {
            to { transform: translate(-180px, -100px) scale(1.2); }
        }

        /* Entrada al cargar la página */
        .brand-headline {
            animation: riseIn 0.8s cubic-bezier(0.2, 0.7, 0.2, 1) both;
        }
        .stack {
            animation: riseIn 0.9s cubic-bezier(0.2, 0.7, 0.2, 1) 0.2s both;
        }
        .form-panel > * {
            animation: riseIn 0.7s cubic-bezier(0.2, 0.7, 0.2, 1) both;
        }
        .form-panel > *:nth-child(2) { animation-delay: 0.08s; }
        .form-panel > *:nth-child(3) { animation-delay: 0.16s; }
        .form-panel > *:nth-child(4) { animation-delay: 0.24s; }
        @keyframes riseIn {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Tarjetas flotando */
        .stack .card.front {
            animation: floatFront 5s ease-in-out infinite;
        }
        .stack .card.back-left {
            animation: floatLeft 6s ease-in-out infinite;
        }
        .stack .card.back-right {
            animation: floatRight 7s ease-in-out infinite;
        }
        @keyframes floatFront {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-14px); }
        }
        @keyframes floatLeft {
            0%, 100% { transform: translateY(0) rotate(-8deg); }
            50%      { transform: translateY(-10px) rotate(-12deg); }
        }
        @keyframes floatRight {
            0%, 100% { transform: translateY(0) rotate(8deg); }
            50%      { transform: translateY(-12px) rotate(12deg); }
        }

        /* Líneas con brillo que recorre las tarjetas */
        .stack .card.front .line {
            background: linear-gradient(90deg,
                rgba(226, 232, 240, 0.2) 0%,
                rgba(226, 232, 240, 0.6) 50%,
                rgba(226, 232, 240, 0.2) 100%);
            background-size: 200% 100%;
            animation: shimmer 2.6s linear infinite;
        }
        .stack .card.front .line.accent {
            background: linear-gradient(90deg, #2563eb, #60a5fa, #2563eb);
            background-size: 200% 100%;
        }
        .stack .card.front .line:nth-child(2) { animation-delay: 0.2s; }
        .stack .card.front .line:nth-child(3) { animation-delay: 0.4s; }
        .stack .card.front .line:nth-child(4) { animation-delay: 0.6s; }
        .stack .card.front .line:nth-child(5) { animation-delay: 0.8s; }
        @keyframes shimmer {
            from { background-position: 200% 0; }
            to   { background-position: -200% 0; }
        }

        /* Check que pulsa */
        .badge {
            animation: pulse 2.2s ease-out infinite;
        }
        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.55); transform: scale(1); }
            60%  { box-shadow: 0 0 0 16px rgba(34, 197, 94, 0); transform: scale(1.08); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); transform: scale(1); }
        }

        /* Fondo con color activo: el degradado se mueve y cambia de tono */
        .brand-panel {
            background: linear-gradient(125deg,
                #0b1220 0%, #12306b 25%, #0b4a5a 50%, #2a1f6b 75%, #0b1220 100%);
            background-size: 400% 400%;
            animation: bgShift 18s ease-in-out infinite;
        }
        @keyframes bgShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Las luces de fondo además cambian de color poco a poco */
        .brand-panel::before {
            animation: drift1 14s ease-in-out infinite alternate,
                       hueCycle 20s linear infinite;
        }
        .brand-panel::after {
            animation: drift2 17s ease-in-out infinite alternate,
                       hueCycle 26s linear infinite reverse;
        }
        @keyframes hueCycle {
            to { filter: blur(70px) hue-rotate(360deg); }
        }

        /* Panel del formulario: movimiento de color más sutil para no cansar la vista */
        .form-panel {
            background: linear-gradient(160deg,
                #161b26 0%, #1a2540 35%, #14232f 65%, #161b26 100%);
            background-size: 300% 300%;
            animation: bgShift 24s ease-in-out infinite;
        }

        /* Respeta a quienes desactivan las animaciones en su sistema */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
            }
        }

        /* ---------- Panel derecho (formulario) ---------- */
        .form-panel {
            flex: 1 1 40%;
            max-width: 560px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px clamp(24px, 5vw, 56px);
            background: #161b26;
            border-left: 1px solid #263044;
        }
        .form-panel h1 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Campos con etiqueta flotante */
        .field {
            position: relative;
            margin-bottom: 12px;
        }
        .field input {
            width: 100%;
            height: 58px;
            padding: 22px 48px 6px 16px;
            background: transparent;
            border: 1px solid #3b4558;
            border-radius: 14px;
            color: #f1f5f9;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .field input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        .field label {
            position: absolute;
            left: 16px;
            top: 18px;
            font-size: 15px;
            color: #94a3b8;
            pointer-events: none;
            transition: all 0.15s ease;
        }
        .field input:focus + label,
        .field input:not(:placeholder-shown) + label {
            top: 9px;
            font-size: 12px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            color: #94a3b8;
        }
        .toggle-password:hover,
        .toggle-password:focus-visible {
            color: #60a5fa;
            outline: none;
        }
        .toggle-password svg { width: 22px; height: 22px; }
        .toggle-password .icon-eye-off { display: none; }
        .toggle-password.active .icon-eye { display: none; }
        .toggle-password.active .icon-eye-off { display: block; }

        button.btn-login {
            width: 100%;
            height: 48px;
            margin-top: 12px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 24px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        button.btn-login:hover { background: #1d4ed8; }
        button.btn-login:active { transform: scale(0.99); }
        button.btn-login:focus-visible {
            outline: 3px solid rgba(96, 165, 250, 0.6);
            outline-offset: 2px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-left: 4px solid #ef4444;
            color: #fecaca;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .footer-text {
            margin-top: 40px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        /* ---------- Móvil ---------- */
        @media (max-width: 860px) {
            .brand-panel { display: none; }
            .form-panel {
                max-width: none;
                border-left: none;
                background: linear-gradient(125deg,
                    #0b1220 0%, #12306b 25%, #0b4a5a 50%, #2a1f6b 75%, #0b1220 100%);
                background-size: 400% 400%;
                animation: bgShift 18s ease-in-out infinite;
            }
            .mobile-logo { display: block; }
        }
        .mobile-logo {
            display: none;
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <!-- Panel de marca -->
    <section class="brand-panel" aria-hidden="true">
        <img src="img/logo.png" alt="" class="brand-logo">
        <h2 class="brand-headline">Todo tu trabajo en <span>INEES Portal</span>.</h2>

        <div class="stack">
            <div class="card back-left">
                <div class="line w60"></div>
                <div class="line w80"></div>
                <div class="line w60"></div>
            </div>
            <div class="card back-right">
                <div class="line w80"></div>
                <div class="line w60"></div>
                <div class="line w80"></div>
            </div>
            <div class="card front">
                <div class="line accent"></div>
                <div class="line w80"></div>
                <div class="line w60"></div>
                <div class="line w80"></div>
                <div class="line w60"></div>
            </div>
            <div class="badge">✓</div>
        </div>
    </section>

    <!-- Panel de formulario -->
    <main class="form-panel">
        <img src="img/logo.png" alt="Logo INEES" class="mobile-logo">
        <h1>Iniciar sesión en INEES Portal</h1>

        <?php if (!empty($error)): ?>
            <div class="alert-error" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" autocomplete="off">
            <div class="field">
                <input type="text" id="usuario" name="usuario" required autofocus placeholder=" " value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                <label for="usuario">Usuario o correo electrónico</label>
            </div>

            <div class="field">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Contraseña</label>
                <button type="button" class="toggle-password" id="togglePassword" aria-label="Mostrar u ocultar contraseña">
                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn-login">Iniciar sesión</button>
        </form>

        <div class="footer-text">
            © <?= date('Y') ?> INEES S.A.S. - Todos los derechos reservados.
        </div>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');

        toggleBtn.addEventListener('click', function () {
            const showing = passwordInput.type === 'text';
            passwordInput.type = showing ? 'password' : 'text';
            toggleBtn.classList.toggle('active', !showing);
        });
    </script>
</body>
</html>