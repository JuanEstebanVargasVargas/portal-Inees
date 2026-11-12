<?php
// vistas/partials/sidebar/sidebar.php
// Partial reutilizable — Menú Lateral Off-Canvas (Hamburger)
// Incluir en cualquier vista del Portal INEES

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detección dinámica de la URL base para que funcione desde cualquier profundidad de carpeta
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(/[^/]+)#', $scriptName, $matches) && strpos($matches[1], '.php') === false) {
    $urlBase = rtrim($matches[1], '/') . '/';
} else {
    $urlBase = '/';
}

// Si la vista que lo invoca aún no cargó datos del usuario, los cargamos de forma segura
if (!isset($perfil) && isset($_SESSION['usuario_id'])) {
    $sidebarConexionPath  = __DIR__ . '/../../../config/conexion.php';
    $sidebarModeloPath    = __DIR__ . '/../../../modelos/dashboardModelo.php';

    if (file_exists($sidebarConexionPath) && file_exists($sidebarModeloPath)) {
        require_once $sidebarConexionPath;
        require_once $sidebarModeloPath;

        if (isset($conexion) && $conexion) {
            $dashboardModeloAux  = new DashboardModelo($conexion);
            $perfil              = $dashboardModeloAux->obtenerUsuarioPorId((int)$_SESSION['usuario_id']);
            $rol_id              = (int)($perfil['nivel_acceso'] ?? 3);
            $rol_nombre          = $perfil['rol_nombre'] ?? 'Usuario';
            $esSuperUsuario      = ($rol_id === 1);
            $esGestionHumana     = ($rol_id === 2);
            $esEmpleado          = ($rol_id === 3);
            $modulosPorCategoria = $dashboardModeloAux->obtenerModulosPorRol($rol_id);
        }
    }
}

// Variables por defecto si no existen
$nombreUsuario = $perfil['nombre']       ?? ($_SESSION['nombre']       ?? 'Usuario');
$rolNombreUser = $perfil['rol_nombre']   ?? ($_SESSION['rol_nombre']   ?? 'Usuario');
$rolIdUser     = (int)($perfil['nivel_acceso'] ?? ($_SESSION['nivel_acceso'] ?? 3));
$fotoUsuario   = $perfil['foto_perfil']  ?? ($_SESSION['foto_perfil']  ?? null);

$esSuper       = ($rolIdUser === 1);
$esGH          = ($rolIdUser === 2);
$esEmp         = ($rolIdUser === 3);
$esSG          = ($rolIdUser === 5);

$badgeClass = 'badge-empleado';
if ($esSuper) {
    $badgeClass = 'badge-superusuario';
} elseif ($esGH) {
    $badgeClass = 'badge-gestionhumana';
} elseif ($esSG) {
    $badgeClass = 'badge-sistemagestion';
}
?>

<!-- ═══════════════════════════════════════════════════════
     PARTIAL: Menú Lateral Off-Canvas — Portal INEES
     Archivo: vistas/partials/sidebar/sidebar.php
     ═══════════════════════════════════════════════════════ -->

<!-- Estilos del Sidebar (se inyectan una sola vez) -->
<?php if (!defined('SIDEBAR_STYLES_LOADED')): define('SIDEBAR_STYLES_LOADED', true); ?>
<style id="sidebar-partial-styles">
    /* ── Botón Hamburguesa ─────────────────────────────── */
    .btn-hamburger {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #0f172a;
        transition: all 0.2s ease;
    }
    .btn-hamburger:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #2563eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }

    /* ── Overlay de fondo ──────────────────────────────── */
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(2px);
        z-index: 998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ── Drawer lateral ────────────────────────────────── */
    .sidebar-drawer {
        position: fixed;
        top: 0; left: 0; bottom: 0;
        width: 320px;
        max-width: 86vw;
        background: #ffffff;
        z-index: 999;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 4px 0 25px rgba(0,0,0,0.15);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }
    .sidebar-drawer.open {
        transform: translateX(0);
    }

    /* ── Cabecera del Sidebar ──────────────────────────── */
    .sidebar-header {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #0d9488;
        background: #0b1728;
    }
    .sidebar-brand-container {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    .sidebar-brand-logo {
        width: 32px;
        height: 32px;
        object-fit: contain;
        border-radius: 6px;
    }
    .sidebar-brand-text {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff;
    }
    .sidebar-brand-text span {
        color: #2dd4bf;
        font-weight: 600;
    }
    .sidebar-btn-close {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #cbd5e1;
        transition: all 0.2s ease;
    }
    .sidebar-btn-close:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: #ef4444;
        color: #fca5a5;
    }

    /* ── Ficha del usuario ─────────────────────────────── */
    .sidebar-user-box {
        padding: 16px 20px;
        background: #0f223d;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sidebar-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488, #0284c7);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 700;
        text-transform: uppercase;
        flex-shrink: 0;
        overflow: hidden;
        border: 1.5px solid rgba(255, 255, 255, 0.25);
    }
    .sidebar-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        display: block;
    }
    .sidebar-user-info {
        line-height: 1.25;
        overflow: hidden;
    }
    .sidebar-user-name {
        font-size: 14px;
        font-weight: 600;
        color: #f8fafc;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sidebar-role-badge {
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
        padding: 2px 7px;
        border-radius: 4px;
        margin-top: 3px;
    }

    /* ── Badges de rol ─────────────────────────────────── */
    .badge-superusuario   { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
    .badge-gestionhumana  { background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(45, 212, 191, 0.35); }
    .badge-empleado       { background: rgba(2, 132, 199, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); }
    .badge-sistemagestion { background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35); }

    /* ── Contenido scrollable ──────────────────────────── */
    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 16px 12px;
    }
    .sidebar-content::-webkit-scrollbar { width: 6px; }
    .sidebar-content::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    /* ── Secciones y links ─────────────────────────────── */
    .sidebar-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        padding: 10px 12px 4px 12px;
        margin-top: 6px;
    }
    .sidebar-nav-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 0;
        margin: 0;
    }
    .sidebar-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 12px;
        border-radius: 8px;
        color: #0f172a;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.15s ease;
    }
    .sidebar-nav-link:hover {
        background: #f0fdfa;
        color: #0d9488;
        transform: translateX(2px);
    }
    .sidebar-nav-link.active {
        background: #f0fdfa;
        color: #0f766e;
        font-weight: 600;
        border-left: 3px solid #0d9488;
    }
    .sidebar-nav-link svg { color: #64748b; flex-shrink: 0; transition: color 0.15s ease; }
    .sidebar-nav-link:hover svg,
    .sidebar-nav-link.active svg { color: #0d9488; }

    .sidebar-badge {
        margin-left: auto;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        background: #e2e8f0;
        color: #475569;
    }

    /* ── Pie del Sidebar ───────────────────────────────── */
    .sidebar-footer {
        padding: 14px 16px;
        border-top: 1px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .sidebar-btn-logout {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
        text-decoration: none;
        padding: 9px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }
    .sidebar-btn-logout:hover {
        background: #fee2e2;
        color: #b91c1c;
    }
</style>
<?php endif; ?>

<!-- Overlay de fondo oscuro -->
<div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- Drawer del Menú Lateral -->
<aside id="sidebarDrawer" class="sidebar-drawer" aria-label="Menú de Navegación Lateral">

    <!-- Cabecera del drawer -->
    <div class="sidebar-header">
        <a href="<?= $urlBase ?>index.php" class="sidebar-brand-container">
            <img src="<?= $urlBase ?>img/logo.png" alt="Logo INEES" class="sidebar-brand-logo" onerror="this.style.display='none'">
            <div class="sidebar-brand-text">INEES <span>Portal</span></div>
        </a>
        <button class="sidebar-btn-close" onclick="closeSidebar()" aria-label="Cerrar menú lateral" title="Cerrar menú">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Ficha del usuario autenticado -->
    <div class="sidebar-user-box">
        <div class="sidebar-avatar" id="sidebarAvatarContainer">
            <?php if (!empty($fotoUsuario)): ?>
                <img src="<?= $urlBase . htmlspecialchars($fotoUsuario) ?>?v=<?= time() ?>" alt="Foto" class="sidebar-avatar-img" id="sidebarAvatarImg">
            <?php else: ?>
                <span id="sidebarAvatarInitial"><?= htmlspecialchars(mb_substr($nombreUsuario, 0, 1, 'UTF-8')) ?></span>
            <?php endif; ?>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name"><?= htmlspecialchars($nombreUsuario) ?></div>
            <div class="sidebar-role-badge <?= $badgeClass ?>"><?= htmlspecialchars($rolNombreUser) ?></div>
        </div>
    </div>

    <!-- Contenido de navegación -->
    <div class="sidebar-content">

        <!-- Inicio -->
        <div class="sidebar-section-title">Navegación</div>
        <ul class="sidebar-nav-list">
            <li>
                <a href="<?= $urlBase ?>controladores/perfil/perfilControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'perfilControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Mi Perfil</span>
                </a>
            </li>
        </ul>

                <!-- ── SuperUsuario ──────────────────────────── -->
        <?php if ($esSuper): ?>
            <div class="sidebar-section-title">Administración Global</div>
            <ul class="sidebar-nav-list">
                <li>
                    <a href="<?= $urlBase ?>controladores/admin/usuarioVerControlador.php" class="sidebar-nav-link">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        <span>Gestión de Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $urlBase ?>controladores/admin/usuarioCrearControlador.php" class="sidebar-nav-link">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Crear Usuario</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $urlBase ?>controladores/talentoHumano/directorioControlador.php"
                       class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'directorioControlador.php') ? 'active' : '' ?>">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Directorio de Empleados</span>
                    </a>
                </li>
            </ul>

        <!-- ── Gestión Humana ────────────────────────── -->
        <?php elseif ($esGH): ?>
            <div class="sidebar-section-title">Talento Humano</div>
            <ul class="sidebar-nav-list">
                <li>
                    <a href="<?= $urlBase ?>controladores/talentoHumano/directorioControlador.php"
                       class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'directorioControlador.php') ? 'active' : '' ?>">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Directorio de Empleados</span>
                    </a>
                </li>
            </ul>

        <!-- ── Sistema de Gestión ───────────────────── -->
        <?php elseif ($esSG): ?>
            <div class="sidebar-section-title">Sistema de Gestión</div>
            <ul class="sidebar-nav-list">
                <li>
                    <a href="<?= $urlBase ?>controladores/flujos/flujosControlador.php"
                       class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'flujosControlador.php') ? 'active' : '' ?>">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 3 21 3 21 8"></polyline>
                            <line x1="4" y1="20" x2="21" y2="3"></line>
                            <polyline points="21 16 21 21 16 21"></polyline>
                            <line x1="15" y1="15" x2="21" y2="21"></line>
                            <line x1="4" y1="4" x2="9" y2="9"></line>
                        </svg>
                        <span>Flujos de Procesos</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>

        <!-- ── Mi Espacio de Trabajo (Para todos los roles) ───────────────── -->
        <div class="sidebar-section-title">Mi Espacio de Trabajo</div>
        <ul class="sidebar-nav-list">
            <li>
                <a href="<?= $urlBase ?>controladores/talentoHumano/incapacidadesControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'incapacidadesControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                    <span>Incapacidades</span>
                </a>
            </li>
            <li>
                <a href="<?= $urlBase ?>controladores/talentoHumano/vacacionesControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'vacacionesControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="4"/>
                        <line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <span>Solicitud de Vacaciones</span>
                </a>
            </li>
            <li>
                <a href="<?= $urlBase ?>controladores/permisos/formatoPermisosControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'formatoPermisosControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Formato de permisos</span>
                </a>
            </li>
            <li>
                <a href="<?= $urlBase ?>controladores/talentoHumano/ingresoControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'ingresoControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    <span>Solicitud de Ingreso</span>
                </a>
            </li>
            <li>
                <a href="<?= $urlBase ?>controladores/talentoHumano/contratosControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'contratosControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    <span>Contratos y Hoja de Vida</span>
                </a>
            </li>
            <li>
                <a href="<?= $urlBase ?>controladores/talentoHumano/librosControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'librosControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    <span>Libros</span>
                </a>
            </li>
            <li>
                <a href="<?= $urlBase ?>controladores/organigrama/subirOrganigramaControlador.php"
                   class="sidebar-nav-link <?= (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'subirOrganigramaControlador.php') ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="2" width="6" height="4" rx="1"/>
                        <rect x="1" y="14" width="6" height="4" rx="1"/>
                        <rect x="17" y="14" width="6" height="4" rx="1"/>
                        <line x1="12" y1="6" x2="12" y2="11"/>
                        <line x1="12" y1="11" x2="4" y2="14"/>
                        <line x1="12" y1="11" x2="20" y2="14"/>
                    </svg>
                    <span>Organigrama</span>
                </a>
            </li>
        </ul>

        <!-- Módulos habilitados agrupados por categoría -->
        <?php if (!empty($modulosPorCategoria)): ?>
            <div class="sidebar-section-title">Módulos Habilitados</div>
            <ul class="sidebar-nav-list">
                <?php foreach ($modulosPorCategoria as $categoria => $mods): ?>
                    <?php $catAnchor = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $categoria)); ?>
                    <li>
                        <a href="<?= $urlBase ?>index.php#cat-<?= $catAnchor ?>" class="sidebar-nav-link" onclick="closeSidebar()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                            <span><?= htmlspecialchars($categoria) ?></span>
                            <span class="sidebar-badge"><?= count($mods) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        
        <!-- Cuenta y seguridad -->
        <div class="sidebar-section-title">Cuenta</div>
        <ul class="sidebar-nav-list">
            <li>
                <a href="<?= $urlBase ?>controladores/login/cambiarPasswordControlador.php" class="sidebar-nav-link">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>Cambiar mi Contraseña</span>
                </a>
            </li>
        </ul>

    </div><!-- /.sidebar-content -->

    <!-- Pie del sidebar -->
    <div class="sidebar-footer">
        <a href="<?= $urlBase ?>logout.php" class="sidebar-btn-logout">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Cerrar Sesión
        </a>
        <div style="font-size:11px; text-align:center; color:#64748b;">
            INEES Portal &bull; <?= date('Y') ?>
        </div>
    </div>

</aside><!-- /#sidebarDrawer -->

<!-- JavaScript del sidebar (se registra una sola vez) -->
<?php if (!defined('SIDEBAR_SCRIPTS_LOADED')): define('SIDEBAR_SCRIPTS_LOADED', true); ?>
<script id="sidebar-partial-scripts">
    function openSidebar() {
        var drawer  = document.getElementById('sidebarDrawer');
        var overlay = document.getElementById('sidebarOverlay');
        if (drawer)  drawer.classList.add('open');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        var drawer  = document.getElementById('sidebarDrawer');
        var overlay = document.getElementById('sidebarOverlay');
        if (drawer)  drawer.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Cerrar con la tecla Escape (evitar registro duplicado)
    if (!window._sidebarEscRegistered) {
        window._sidebarEscRegistered = true;
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });
    }
</script>
<?php endif; ?>
