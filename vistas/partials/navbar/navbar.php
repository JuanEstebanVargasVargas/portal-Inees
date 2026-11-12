<?php
// vistas/partials/navbar/navbar.php
// Componente modular y reutilizable de la Barra de Navegación Superior (Header)
// Puede ser incluido en cualquier vista del Portal INEES

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Detección dinámica de la URL base del portal para enlaces absolutos confiables
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(/[^/]+)#', $scriptName, $matches) && strpos($matches[1], '.php') === false) {
    $urlBase = rtrim($matches[1], '/') . '/';
} else {
    $urlBase = '/';
}

// 2. Si la vista no ha cargado los datos del usuario, cargarlos de forma segura
if (!isset($perfil) && isset($_SESSION['usuario_id'])) {
    $navConexionPath = __DIR__ . '/../../../config/conexion.php';
    $navModeloPath   = __DIR__ . '/../../../modelos/dashboardModelo.php';

    if (file_exists($navConexionPath) && file_exists($navModeloPath)) {
        require_once $navConexionPath;
        require_once $navModeloPath;

        if (isset($conexion) && $conexion) {
            $dashboardModeloAux = new DashboardModelo($conexion);
            $perfil             = $dashboardModeloAux->obtenerUsuarioPorId((int)$_SESSION['usuario_id']);
        }
    }
}

// Variables del usuario desde sesión / $perfil ya inyectado por el controlador
$navNombre   = $perfil['nombre']       ?? ($_SESSION['nombre']       ?? 'Usuario');
$navRol      = $perfil['rol_nombre']   ?? ($_SESSION['rol_nombre']   ?? 'Usuario');
$navRolId    = (int)($perfil['nivel_acceso'] ?? ($_SESSION['nivel_acceso'] ?? 3));
$navFoto     = $perfil['foto_perfil']  ?? ($_SESSION['foto_perfil']  ?? null);

$navEsSuper = ($navRolId === 1);
$navEsGH    = ($navRolId === 2);
$navEsSG    = ($navRolId === 5);

$navBadgeClass = 'badge-empleado';
if ($navEsSuper) {
    $navBadgeClass = 'badge-superusuario';
} elseif ($navEsGH) {
    $navBadgeClass = 'badge-gestionhumana';
} elseif ($navEsSG) {
    $navBadgeClass = 'badge-sistemagestion';
}
?>

<!-- Estilos CSS de la Navbar (se inyectan solo una vez) -->
<?php if (!defined('NAVBAR_STYLES_LOADED')): define('NAVBAR_STYLES_LOADED', true); ?>
<style id="navbar-partial-styles">
    /* ---------- Header Principal ---------- */
    header.main-navbar {
        background: #0b1728;
        border-bottom: 2px solid #0d9488;
        padding: 12px 24px;
        position: sticky;
        top: 0;
        z-index: 50;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(11, 23, 40, 0.25);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    .navbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* Botón Hamburguesa */
    .btn-hamburger {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 8px;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #ffffff;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .btn-hamburger:hover {
        background: rgba(13, 148, 136, 0.25);
        border-color: #0d9488;
        color: #2dd4bf;
        box-shadow: 0 0 12px rgba(13, 148, 136, 0.3);
    }

    /* Marca / Logo */
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .navbar-logo {
        width: 36px;
        height: 36px;
        object-fit: contain;
        border-radius: 8px;
    }

    .navbar-brand-text {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff;
    }

    .navbar-brand-text span {
        color: #2dd4bf;
        font-weight: 600;
    }

    /* Zona derecha */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .navbar-user-chip {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.07);
        padding: 5px 12px 5px 8px;
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, border-color .2s, box-shadow .2s;
    }

    .navbar-user-chip:hover {
        background: rgba(13, 148, 136, 0.2);
        border-color: rgba(13, 148, 136, 0.5);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }

    .navbar-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488, #0284c7);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        flex-shrink: 0;
        overflow: hidden;
        border: 1.5px solid rgba(255, 255, 255, 0.25);
    }

    .navbar-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        display: block;
    }

    .navbar-user-info {
        line-height: 1.2;
        text-align: left;
    }

    .navbar-user-name {
        font-size: 13px;
        font-weight: 600;
        color: #f8fafc;
        white-space: nowrap;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .navbar-role-badge {
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        padding: 2px 7px;
        border-radius: 4px;
        margin-top: 2px;
    }

    /* Badges de rol compartidos */
    .badge-superusuario {
        background: #f3e8ff;
        color: #7e22ce;
        border: 1px solid #e9d5ff;
    }

    .badge-gestionhumana {
        background: rgba(13, 148, 136, 0.2);
        color: #2dd4bf;
        border: 1px solid rgba(45, 212, 191, 0.35);
    }

    .badge-empleado {
        background: rgba(2, 132, 199, 0.2);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.35);
    }
    .badge-sistemagestion {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    /* Botón Salir */
    .navbar-btn-logout {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.3);
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
        font-family: inherit;
    }

    .navbar-btn-logout:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
    }

    /* Responsive: en pantallas pequeñas ocultar nombre */
    @media (max-width: 540px) {
        .navbar-user-name,
        .navbar-role-badge {
            display: none;
        }

        .navbar-user-chip {
            padding: 5px 8px;
        }

        .navbar-btn-logout span {
            display: none;
        }

        .navbar-brand-text {
            font-size: 17px;
        }
    }
</style>
<?php endif; ?>

<!-- Barra de Navegación Superior -->
<header class="main-navbar">
    <div class="navbar-left">
        <!-- Botón Hamburguesa → activa el menú lateral -->
        <button class="btn-hamburger" onclick="openSidebar()" aria-label="Abrir menú de navegación" title="Menú lateral">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6"  x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <!-- Logo y Marca -->
        <a href="<?= $urlBase ?>index.php" class="navbar-brand">
            <img src="<?= $urlBase ?>img/logo.png" alt="Logo INEES" class="navbar-logo" onerror="this.style.display='none'">
            <div class="navbar-brand-text">INEES <span>Portal</span></div>
        </a>
    </div>

    <!-- Zona Derecha: Chip de usuario y botón Salir -->
    <div class="navbar-right">
        <a href="<?= $urlBase ?>controladores/perfil/perfilControlador.php"
           class="navbar-user-chip"
           title="Ver mi perfil">
            <div class="navbar-avatar" id="navbarAvatarContainer">
                <?php if (!empty($navFoto)): ?>
                    <img src="<?= $urlBase . htmlspecialchars($navFoto) ?>?v=<?= time() ?>" alt="Foto" class="navbar-avatar-img" id="navbarAvatarImg">
                <?php else: ?>
                    <span id="navbarAvatarInitial"><?= htmlspecialchars(mb_substr($navNombre, 0, 1, 'UTF-8')) ?></span>
                <?php endif; ?>
            </div>
            <div class="navbar-user-info">
                <div class="navbar-user-name"><?= htmlspecialchars($navNombre) ?></div>
                <div class="navbar-role-badge <?= $navBadgeClass ?>">
                    <?= htmlspecialchars($navRol) ?>
                </div>
            </div>
        </a>

        <a href="<?= $urlBase ?>logout.php" class="navbar-btn-logout" title="Cerrar Sesión">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span>Salir</span>
        </a>
    </div>
</header>
