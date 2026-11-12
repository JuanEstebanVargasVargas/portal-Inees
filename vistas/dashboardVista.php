<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>Panel de Control - Portal INEES</title>
    <style>
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #f0fdfa;
            --primary-glow: rgba(13, 148, 136, 0.2);
            --bg-page: #edf2f7;
            --bg-card: #ffffff;
            --text-main: #0f223d;
            --text-muted: #52637a;
            --border: #dbe3eb;
            --border-light: #e6edf4;
            --superusuario-color: #7c3aed;
            --gh-color: #0d9488;
            --empleado-color: #0284c7;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(15, 34, 61, 0.06);
            --shadow-md: 0 4px 14px rgba(15, 34, 61, 0.08), 0 2px 4px -2px rgba(15, 34, 61, 0.04);
            --shadow-lg: 0 12px 24px -4px rgba(15, 34, 61, 0.12), 0 4px 8px -2px rgba(15, 34, 61, 0.06);
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

        /* ---------- Contenedor Principal ---------- */
        main {
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 20px 60px 20px;
            flex: 1;
        }

        /* ---------- Banner Hero Unificado con KPIs Integrados ---------- */
        .hero-banner {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #083344 100%);
            color: #ffffff;
            border-radius: var(--radius-lg);
            padding: 32px 32px 28px 32px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 28px -5px rgba(11, 23, 40, 0.4);
            border: 1px solid rgba(13, 148, 136, 0.35);
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(13, 148, 136, 0.35) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-greeting {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .hero-subtext {
            color: #cbd5e1;
            font-size: 14.5px;
            max-width: 820px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .hero-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .hero-tag-item {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            color: #cbd5e1;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .hero-tag-item strong {
            color: #ffffff;
            font-weight: 600;
        }

        /* Divisor interno dentro del Hero */
        .hero-divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, rgba(13, 148, 136, 0.4) 50%, rgba(255, 255, 255, 0.08) 100%);
            margin: 24px 0 20px 0;
            position: relative;
            z-index: 2;
        }

        /* Tarjetas KPI Integradas dentro del Hero (Glassmorphism) */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            position: relative;
            z-index: 2;
        }

        .kpi-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(8px);
            border-radius: var(--radius-md);
            padding: 16px 18px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.25s ease;
        }

        .kpi-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(13, 148, 136, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        .kpi-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kpi-details {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .kpi-value {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.15;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .kpi-label {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 3px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ---------- Paneles Especiales por Rol ---------- */
        .role-spotlight {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-sm);
        }

        .role-spotlight-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .role-spotlight-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
        }

        .quick-action-btn {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .quick-action-btn:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* ---------- Secciones de Módulos Dinámicos ---------- */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-modules-input {
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13px;
            width: 250px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background: #ffffff;
        }

        .search-modules-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .category-group {
            margin-bottom: 32px;
        }

        .category-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--border);
        }

        .category-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .category-badge-count {
            background: #e2e8f0;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .module-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
            position: relative;
        }

        .module-card:hover {
            border-color: #cbd5e1;
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .module-card-top {
            margin-bottom: 14px;
        }

        .module-badge-tag {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .module-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .module-description {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.45;
        }

        .module-card-action {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--border-light);
        }

        .btn-module-link {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            border-radius: var(--radius-sm);
            background: var(--primary-light);
            transition: all 0.2s ease;
        }

        .btn-module-link:hover {
            background: var(--primary);
            color: #ffffff;
        }

        /* ---------- Perfil y Auditoría ---------- */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 10px;
        }

        @media (max-width: 860px) {
            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-panel {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 22px;
            box-shadow: var(--shadow-sm);
        }

        .info-panel-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .profile-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--border);
            font-size: 13px;
        }

        .profile-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .profile-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .profile-value {
            font-weight: 600;
            color: var(--text-main);
        }

        .access-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .access-table th {
            text-align: left;
            padding: 8px 10px;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            background: var(--bg-page);
        }

        .access-table td {
            padding: 8px 10px;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-main);
        }

        .access-table tr:last-child td {
            border-bottom: none;
        }

        .ip-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 11px;
        }

        /* ---------- Badges de Rol ---------- */
        .badge-superusuario {
            background: #f3e8ff;
            color: #7e22ce;
            border: 1px solid #e9d5ff;
        }

        .badge-gestionhumana {
            background: #ccfbf1;
            color: #0f766e;
            border: 1px solid #99f6e4;
        }

        .badge-empleado {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .badge-sistemagestion {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        /* ---------- Apartado Especial: Carpeta MI ÁREA ---------- */
        .myarea-folder-spotlight {
            background: linear-gradient(135deg, #ffffff 0%, #f0fdfa 100%);
            border-radius: var(--radius-lg);
            border: 2px solid #0d9488;
            padding: 22px 28px;
            margin-bottom: 28px;
            box-shadow: 0 8px 22px -4px rgba(13, 148, 136, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .myarea-folder-spotlight:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px -4px rgba(13, 148, 136, 0.25);
            border-color: #0f766e;
        }
        .myarea-folder-spotlight::before {
            content: '';
            position: absolute;
            top: 0;
            left: 28px;
            width: 140px;
            height: 7px;
            background: #0d9488;
            border-radius: 0 0 8px 8px;
        }
        .myarea-folder-left {
            display: flex;
            align-items: center;
            gap: 18px;
            max-width: 800px;
        }
        .myarea-folder-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #f59e0b;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #d97706;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
            transition: transform 0.2s ease;
        }
        .myarea-folder-spotlight:hover .myarea-folder-icon {
            transform: scale(1.08) rotate(-3deg);
        }
        .myarea-folder-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ccfbf1;
            color: #0f766e;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 6px;
            border: 1px solid #99f6e4;
        }
        .myarea-folder-title {
            font-size: 20px;
            font-weight: 800;
            color: #0f223d;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .myarea-folder-desc {
            font-size: 13.5px;
            color: #475569;
            line-height: 1.45;
        }
        .myarea-folder-btn {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            padding: 11px 20px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
            white-space: nowrap;
            border: none;
            pointer-events: none;
        }

        .badge-general {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        footer {
            background: #0b1728;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 18px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- Partial: Menú Lateral (Off-Canvas) -->
    <?php require_once __DIR__ . '/partials/sidebar/sidebar.php'; ?>

    <!-- Partial: Barra de Navegación Superior -->
    <?php require_once __DIR__ . '/partials/navbar/navbar.php'; ?>

    <main>
        <!-- Banner de Bienvenida Personalizado -->
        <div class="hero-banner">
            <div class="hero-content">
                <?php
                    if (date_default_timezone_get() !== 'America/Bogota') {
                        date_default_timezone_set('America/Bogota');
                    }
                    $horaActual = (int)date('G'); // Hora en formato 24h (0 - 23)
                    if ($horaActual >= 5 && $horaActual < 12) {
                        $saludo = "Buenos días";
                    } elseif ($horaActual >= 12 && $horaActual < 19) {
                        $saludo = "Buenas tardes";
                    } else {
                        $saludo = "Buenas noches";
                    }
                ?>
                <h1 class="hero-greeting">
                    <?= $saludo ?>, <?= htmlspecialchars($perfil['nombre']) ?>!
                </h1>
                
                <p class="hero-subtext">
                    <?php if ($esSuperUsuario): ?>
                        Tienes privilegios de <strong>SuperUsuario</strong>. Dispones de administración de usuarios, gestión de rutas del sistema, reportes y configuración general de la plataforma.
                    <?php elseif ($esGestionHumana): ?>
                        Bienvenida al <strong>Panel de Gestión Humana y Talento</strong>. Gestiona la información de colaboradores, supervisa el registro de labores diarias y consulta reportes de productividad.
                    <?php elseif (!empty($esSistemaGestion)): ?>
                        Bienvenido al <strong>Portal de Sistema de Gestión</strong>. Tienes facultades exclusivas para publicar, organizar y administrar los documentos oficiales y normativos en la carpeta <strong>Mi Área</strong>.
                    <?php else: ?>
                        Bienvenido a tu <strong>Portal del Colaborador</strong>. Registra tus labores diarias, consulta tus tareas asignadas y mantén actualizada la información de tu perfil.
                    <?php endif; ?>
                </p>

                <div class="hero-tags">
                    <div class="hero-tag-item">
                        <span>Cargo:</span> <strong><?= htmlspecialchars($perfil['cargo'] ?? 'No asignado') ?></strong>
                    </div>
                    <div class="hero-tag-item">
                        <span>Área:</span> <strong><?= htmlspecialchars($perfil['area'] ?? 'General') ?></strong>
                    </div>
                </div>

                <!-- Línea Divisoria Sutil Interna -->
                <div class="hero-divider"></div>

                <!-- Indicadores Métricos Clave (KPIs) Integrados en el Mismo Bloque -->
                <div class="kpi-grid">
                    <?php if ($esSuperUsuario): ?>
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background: rgba(124, 58, 237, 0.25); color: #c084fc;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div class="kpi-details">
                                <div class="kpi-value"><?= number_format($estadisticas['total_usuarios']) ?></div>
                                <div class="kpi-label">Usuarios Activos en Sistema</div>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-icon" style="background: rgba(2, 132, 199, 0.25); color: #38bdf8;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                            </div>
                            <div class="kpi-details">
                                <div class="kpi-value"><?= number_format($estadisticas['total_rutas']) ?></div>
                                <div class="kpi-label">Rutas y Módulos del Sistema</div>
                            </div>
                        </div>
                    <?php elseif ($esGestionHumana): ?>
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background: rgba(13, 148, 136, 0.25); color: #2dd4bf;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div class="kpi-details">
                                <div class="kpi-value"><?= number_format($estadisticas['total_colaboradores']) ?></div>
                                <div class="kpi-label">Colaboradores en la Empresa</div>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-icon" style="background: rgba(2, 132, 199, 0.25); color: #38bdf8;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <div class="kpi-details">
                                <div class="kpi-value"><?= number_format($estadisticas['modulos_rol']) ?></div>
                                <div class="kpi-label">Módulos de Gestión Humana</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background: rgba(2, 132, 199, 0.25); color: #38bdf8;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <div class="kpi-details">
                                <div class="kpi-value"><?= number_format($estadisticas['modulos_rol']) ?></div>
                                <div class="kpi-label">Módulos Habilitados para Ti</div>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-icon" style="background: rgba(16, 185, 129, 0.25); color: #34d399;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="kpi-details">
                                <div class="kpi-value" style="font-size: 17px; font-weight: 700; color: #34d399;">Activo</div>
                                <div class="kpi-label">Estado de la Cuenta</div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Tarjeta KPI: Fecha y Hora del Último Acceso -->
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(245, 158, 11, 0.25); color: #fbbf24;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <div class="kpi-details">
                            <div class="kpi-value" style="font-size: 15px; font-weight: 700; color: #ffffff;">
                                <?php 
                                    if (!empty($perfil['ultimo_acceso'])) {
                                        echo htmlspecialchars(date('d/m/Y H:i', strtotime($perfil['ultimo_acceso'])));
                                    } elseif (!empty($ultimosAccesos[0]['fecha'])) {
                                        echo htmlspecialchars($ultimosAccesos[0]['fecha'] . ' ' . substr($ultimosAccesos[0]['hora'] ?? '', 0, 5));
                                    } else {
                                        echo 'Hoy';
                                    }
                                ?>
                            </div>
                            <div class="kpi-label">Último Acceso Registrado</div>
                        </div>
                    </div>
                </div><!-- /.kpi-grid -->

            </div><!-- /.hero-content -->
        </div><!-- /.hero-banner -->

        <!-- ======================================================= -->
        <!-- CARRUSEL INSTITUCIONAL MULTI-ROL                        -->
        <!-- ======================================================= -->
        <?php require __DIR__ . '/partials/carrusel/carrusel.php'; ?>

        <!-- ======================================================= -->
        <!-- PANELES DE ACCIÓN RÁPIDA SEGÚN EL ROL                   -->
        <!-- ======================================================= -->

        <!-- ======================================================= -->
        <!-- TABLERO DE COMUNICADOS INSTITUCIONALES (todos los roles) -->
        <!-- Solo Gestión Humana puede publicar; todos pueden leer   -->
        <!-- ======================================================= -->
        <?php require __DIR__ . '/partials/publicaciones/publicaciones.php'; ?>

        <!-- ======================================================= -->
        <!-- APARTADO CORPORATIVO: MI ÁREA (Visible para todos)      -->
        <!-- ======================================================= -->
        <a href="controladores/miArea/miAreaControlador.php" class="myarea-folder-spotlight" title="Abrir carpeta Mi Área">
            <div class="myarea-folder-left">
                <div class="myarea-folder-icon">📂</div>
                <div>
                    <span class="myarea-folder-tag">📁 Carpeta Institucional</span>
                    <h2 class="myarea-folder-title">
                        MI ÁREA <span>&bull; Documentación Oficial</span>
                    </h2>
                    <p class="myarea-folder-desc">
                        Repositorio oficial de normativas, formatos, procedimientos y políticas institucionales. Haz clic para abrir la carpeta <strong>Mi Área</strong> y acceder a los archivos disponibles.
                    </p>
                </div>
            </div>
            <div>
                <div class="myarea-folder-btn">
                    <span>Abrir Carpeta Mi Área</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
            </div>
        </a>

        <!-- 2. Panel de Gestión Humana -->
        <?php if ($esGestionHumana): ?>
        <div class="role-spotlight" style="border-top: 4px solid var(--gh-color);">
            <div class="role-spotlight-header">
                <div class="role-spotlight-title">
                    <span style="color: var(--gh-color);">💼</span> Centro de Gestión Humana y Talento
                </div>
                <span class="user-role-badge badge-gestionhumana">Gestión Humana</span>
            </div>
            <div class="role-quick-actions">
                <a href="controladores/miArea/miAreaControlador.php" class="quick-action-btn">
                    <span>📁</span> Mi Área
                </a>
                <a href="controladores/flujos/flujosControlador.php" class="quick-action-btn">
                    <span>🔀</span> Flujos de Procesos
                </a>
                <a href="controladores/talentoHumano/contratosControlador.php" class="quick-action-btn">
                    <span>📄</span> Contratos y Hoja de Vida
                </a>
                <a href="controladores/talentoHumano/ingresoControlador.php" class="quick-action-btn">
                    <span>👥</span> Solicitud de Ingreso
                </a>
                <a href="controladores/talentoHumano/directorioControlador.php" class="quick-action-btn">
                    <span>📞</span> Directorio de Empleados
                </a>
                <a href="controladores/permisos/formatoPermisosControlador.php" class="quick-action-btn">
                    <span>⏱️</span> Formato de Permisos
                </a>
                <a href="controladores/talentoHumano/vacacionesControlador.php" class="quick-action-btn">
                    <span>🏖️</span> Solicitud de Vacaciones
                </a>
                <a href="controladores/talentoHumano/incapacidadesControlador.php" class="quick-action-btn">
                    <span>📅</span> Incapacidades
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- 3. Panel de Empleado -->
        <?php if ($esEmpleado): ?>
        <div class="role-spotlight" style="border-top: 4px solid var(--empleado-color);">
            <div class="role-spotlight-header">
                <div class="role-spotlight-title">
                    <span style="color: var(--empleado-color);">👤</span> Portal del Colaborador
                </div>
                <span class="user-role-badge badge-empleado">Empleado</span>
            </div>
            <div class="role-quick-actions">
                <a href="controladores/miArea/miAreaControlador.php" class="quick-action-btn">
                    <span>📁</span> Mi Área
                </a>
                <a href="controladores/flujos/flujosControlador.php" class="quick-action-btn">
                    <span>🔀</span> Flujos de Procesos
                </a>
                <a href="controladores/perfil/perfilControlador.php" class="quick-action-btn">
                    <span>👤</span> Mi Perfil
                </a>
                <a href="controladores/talentoHumano/incapacidadesControlador.php" class="quick-action-btn">
                    <span>📅</span> Incapacidades
                </a>
                <a href="controladores/talentoHumano/vacacionesControlador.php" class="quick-action-btn">
                    <span>🏖️</span> Solicitud de Vacaciones
                </a>
                <a href="controladores/talentoHumano/ingresoControlador.php" class="quick-action-btn">
                    <span>👥</span> Solicitud de Ingreso
                </a>
                <a href="controladores/permisos/formatoPermisosControlador.php" class="quick-action-btn">
                    <span>⏱️</span> Formato de permisos 
                </a>
                <a href="controladores/talentoHumano/librosControlador.php" class="quick-action-btn">
                    <span>📚</span> Libros 
                </a>
                <a href="controladores/talentoHumano/desprendibleNominaControlador.php" class="quick-action-btn">
                    <span>💵</span> Desprendible de Nómina
                </a>
                <a href="controladores/talentoHumano/contratosControlador.php" class="quick-action-btn">
                    <span>📄</span> Mi Hoja de Vida
                </a>
                <a href="controladores/login/cambiarPasswordControlador.php" class="quick-action-btn">
                    <span>🔑</span> Actualizar mi Contraseña
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- 4. Panel de Sistema de Gestión -->
        <?php if (!empty($esSistemaGestion)): ?>
        <div class="role-spotlight" style="border-top: 4px solid #10b981;">
            <div class="role-spotlight-header">
                <div class="role-spotlight-title">
                    <span style="color: #10b981;">📋</span> Centro de Sistema de Gestión
                </div>
                <span class="user-role-badge badge-sistemagestion">Sistema de Gestión</span>
            </div>
            <div class="role-quick-actions">
                <a href="controladores/miArea/miAreaControlador.php" class="quick-action-btn" style="border-color: #10b981; background: #ecfdf5;">
                    <span>📁</span> <strong>Mi Área (Publicar)</strong>
                </a>
                <a href="controladores/flujos/flujosControlador.php" class="quick-action-btn" style="border-color: #6366f1; background: #f5f3ff;">
                    <span>🔀</span> <strong>Flujos para Cargar</strong>
                </a>
                <a href="controladores/perfil/perfilControlador.php" class="quick-action-btn">
                    <span>👤</span> Mi Perfil
                </a>
                <a href="controladores/login/cambiarPasswordControlador.php" class="quick-action-btn">
                    <span>🔑</span> Actualizar mi Contraseña
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- ======================================================= -->
        <!-- MÓDULOS HABILITADOS SEGÚN EL ROL                        -->
        <!-- ======================================================= -->
        <div class="section-header">
            <div class="section-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Módulos Habilitados para tu Perfil
            </div>

            <input type="text" id="filtroModulos" class="search-modules-input" placeholder=" Buscar módulo..." onkeyup="filtrarModulos()">
        </div>

        <?php if (empty($modulosPorCategoria)): ?>
            <div style="background: #ffffff; padding: 32px; border-radius: var(--radius-md); text-align: center; border: 1px dashed var(--border);">
                <p style="color: var(--text-muted); font-size: 15px;">No tienes módulos asignados directamente a tu rol. Contacta al área de Gestión Humana o a un SuperUsuario.</p>
            </div>
       
        <?php else: ?>
            <?php foreach ($modulosPorCategoria as $categoria => $modulos): ?>
                <?php
                    $catClase = 'badge-general';
                    $catColor = '#64748b';
                    $catLower = strtolower($categoria);
                    $catId = 'cat-' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $categoria));
            
                    if (strpos($catLower, 'admin') !== false) {
                        $catClase = 'badge-superusuario';
                        $catColor = 'var(--superusuario-color)';
                    } elseif (strpos($catLower, 'téc') !== false || strpos($catLower, 'tec') !== false) {
                        $catClase = 'badge-empleado';
                        $catColor = 'var(--empleado-color)';
                    } elseif (strpos($catLower, 'calidad') !== false || strpos($catLower, 'report') !== false) {
                        $catClase = 'badge-gestionhumana';
                        $catColor = 'var(--gh-color)';
                    }
                ?>

                <div class="category-group"
                     id="<?= htmlspecialchars($catId) ?>"
                     data-categoria-nombre="<?= htmlspecialchars($categoria) ?>">
            
                    <div class="category-header">
                        <span class="category-title" style="color: <?= $catColor ?>;">
                            <?= htmlspecialchars($categoria) ?>
                        </span>
            
                        <span class="category-badge-count">
                            <?= count($modulos) ?>
                        </span>
                    </div>
            
                    <div class="modules-grid">
            
                        <?php foreach ($modulos as $mod): ?>
                        
                            <?php
                                // Nombre personalizado para mostrar en pantalla
                                $nombreMostrar = !empty($mod['nombre_mostrar'])
                                    ? trim($mod['nombre_mostrar'])
                                    : $mod['nombre_ruta'];
                        
                                // Descripción del módulo
                                $descripcion = !empty($mod['descripcion'])
                                    ? $mod['descripcion']
                                    : 'Módulo del sistema INEES Portal.';
                        
                                // Texto utilizado para búsquedas
                                $textoBusqueda = strtolower(
                                    $nombreMostrar . ' ' .
                                    $mod['nombre_ruta'] . ' ' .
                                    $descripcion
                                );
                            ?>

                            <div class="module-card"
                                 data-nombre="<?= htmlspecialchars($textoBusqueda, ENT_QUOTES, 'UTF-8') ?>">
                        
                                <div class="module-card-top">
                        
                                    <span class="module-badge-tag <?= $catClase ?>">
                                        <?= htmlspecialchars($categoria) ?>
                                    </span>
                        
                                    <h3 class="module-title">
                                        <?= htmlspecialchars($nombreMostrar, ENT_QUOTES, 'UTF-8') ?>
                                    </h3>
                        
                                    <p class="module-description">
                                        <?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                        
                                </div>
                        
                                <div class="module-card-action">
                        
                                    <a href="<?= htmlspecialchars($mod['controlador_ruta'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn-module-link">
                        
                                        Abrir módulo
                        
                                        <svg width="12" height="12"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2.5">
                        
                                            <polyline points="9 18 15 12 9 6"></polyline>
                        
                                        </svg>
                        
                                    </a>
                        
                                </div>
                        
                            </div>
                        
                        <?php endforeach; ?>
                        
                    </div>
                </div>
                        
            <?php endforeach; ?>
        <?php endif; ?>


        <!-- ======================================================= -->
        <!-- FICHA DE USUARIO Y AUDITORÍA DE ACCESOS                -->
        <!-- ======================================================= -->
        <div class="bottom-grid">
            <div class="info-panel">
                <div class="info-panel-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Ficha de Usuario y Seguridad
                </div>

                <div class="profile-list">
                    <div class="profile-item">
                        <span class="profile-label">Nombre Completo:</span>
                        <span class="profile-value"><?= htmlspecialchars($perfil['nombre']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Usuario:</span>
                        <span class="profile-value">@<?= htmlspecialchars($perfil['usuario']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Cargo:</span>
                        <span class="profile-value"><?= htmlspecialchars($perfil['cargo'] ?? 'No especificado') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Correo Electrónico:</span>
                        <span class="profile-value"><?= htmlspecialchars($perfil['email'] ?? 'No registrado') ?></span>
                    </div>
                </div>

                <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                    <a href="controladores/login/cambiarPasswordControlador.php" class="quick-action-btn" style="display: inline-flex; width: auto; font-size: 12px; padding: 8px 12px;">
                         Cambiar mi Contraseña
                    </a>
                </div>
            </div>

            <div class="info-panel">
                <div class="info-panel-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Historial Reciente de Inicios de Sesión
                </div>

                <?php if (empty($ultimosAccesos)): ?>
                    <p style="color: var(--text-muted); font-size: 13px;">No hay registros de auditoría disponibles.</p>
                <?php else: ?>
                    <table class="access-table">
                        <thead>
                            <tr>
                                <th>Usuarios</th>    
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultimosAccesos as $acc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($acc['usuario']) ?></td>
                                    <td><?= htmlspecialchars($acc['fecha']) ?></td>
                                    <td><?= htmlspecialchars($acc['hora']) ?></td>     
                                    <td><span style="color: #059669; font-weight: 600;">✓ Correcto</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        Portal INEES &copy; <?= date('Y') ?> &mdash; Sistema Integrado de Gestión y Control Operativo
    </footer>

    <!-- Script de Búsqueda de Módulos en Tiempo Real -->
    <script>
        function filtrarModulos() {
            const input = document.getElementById('filtroModulos').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.module-card');
            const grupos = document.querySelectorAll('.category-group');

            cards.forEach(card => {
                const texto = card.getAttribute('data-nombre') || '';
                if (texto.includes(input)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            grupos.forEach(grupo => {
                const tarjetasVisibles = grupo.querySelectorAll('.module-card[style*="display: flex"]');
                if (input === '' || tarjetasVisibles.length > 0) {
                    grupo.style.display = 'block';
                } else {
                    grupo.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
