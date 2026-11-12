<?php
// vistas/partials/carrusel/carrusel.php
// Componente de Carrusel Interactivo Multi-Rol para el Portal INEES
// Se adapta dinámicamente según el rol autenticado (SuperUsuario, Gestión Humana, Empleado)

if (!isset($urlBase)) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    if (preg_match('#^(/[^/]+)#', $scriptName, $matches) && strpos($matches[1], '.php') === false) {
        $urlBase = rtrim($matches[1], '/') . '/';
    } else {
        $urlBase = '/';
    }
}

// Detección del rol del usuario
$carruselRolId = (int)($perfil['nivel_acceso'] ?? ($_SESSION['nivel_acceso'] ?? 3));
$carruselEsSuper = ($carruselRolId === 1);
$carruselEsGH    = ($carruselRolId === 2);
$carruselEsEmp   = ($carruselRolId === 3);

// Configuración de los 3 slides adaptada al rol
if ($carruselEsSuper) {
    $slide1 = [
        'badge'     => 'Administración Global',
        'badge_bg'  => 'rgba(124, 58, 237, 0.85)',
        'title'     => 'Innovación, Calidad y Control Operativo',
        'desc'      => 'Supervisa usuarios, administra rutas del sistema y optimiza los flujos de trabajo en toda la plataforma INEES.',
        'btn_text'  => '👥 Gestión de Usuarios',
        'btn_link'  => $urlBase . 'controladores/admin/usuarioVerControlador.php',
    ];
    $slide2 = [
        'badge'     => 'Productividad y Analítica',
        'badge_bg'  => 'rgba(37, 99, 235, 0.85)',
        'title'     => 'Monitoreo Integral del Rendimiento',
        'desc'      => 'Consulta reportes consolidados de productividad, registro de actividades y auditoría de incidencias.',
        'btn_text'  => '📊 Productividad General',
        'btn_link'  => $urlBase . 'controladores/reportes/reporteProductividadControlador.php',
    ];
    $slide3 = [
        'badge'     => 'Seguridad y Permisos',
        'badge_bg'  => 'rgba(15, 23, 42, 0.85)',
        'title'     => 'Gobernanza y Rutas del Sistema',
        'desc'      => 'Administra permisos por roles, habilita nuevos módulos y garantiza la seguridad de la infraestructura.',
        'btn_text'  => '🔗 Administrar Rutas',
        'btn_link'  => $urlBase . 'controladores/admin/rutaVerControlador.php',
    ];
} elseif ($carruselEsGH) {
    $slide1 = [
        'badge'     => 'Talento Humano',
        'badge_bg'  => 'rgba(13, 148, 136, 0.85)',
        'title'     => 'Gestión de Talento y Equipo Humano',
        'desc'      => 'Administra el directorio de colaboradores, supervisa el cumplimiento de labores y acompaña al personal.',
        'btn_text'  => '👥 Directorio de Empleados',
        'btn_link'  => $urlBase . 'controladores/talentoHumano/directorioControlador.php',
    ];
    $slide2 = [
        'badge'     => 'Supervisión y Productividad',
        'badge_bg'  => 'rgba(37, 99, 235, 0.85)',
        'title'     => 'Productividad y Cumplimiento de Labores',
        'desc'      => 'Monitorea las actividades diarias registradas por los colaboradores y emite reportes de desempeño.',
        'btn_text'  => '📊 Reporte de Productividad',
        'btn_link'  => $urlBase . 'controladores/reportes/reporteProductividadControlador.php',
    ];
    $slide3 = [
        'badge'     => 'Historial y Labores',
        'badge_bg'  => 'rgba(124, 58, 237, 0.85)',
        'title'     => 'Seguimiento de Labores del Equipo',
        'desc'      => 'Revisa y audita el historial de labores y actividades reportadas por el personal operativo.',
        'btn_text'  => '📅 Historial de Labores',
        'btn_link'  => $urlBase . 'controladores/labores/historialLaboresControlador.php',
    ];
} else {
    // Rol Empleado / Colaborador
    $slide1 = [
        'badge'     => 'Portal del Colaborador',
        'badge_bg'  => 'rgba(37, 99, 235, 0.85)',
        'title'     => 'Innovación, Calidad y Precisión Técnica',
        'desc'      => 'Registra tus actividades del día a día, mantén actualizados tus reportes y colabora con excelencia.',
        'btn_text'  => '⏱️ Registrar Labor Diaria',
        'btn_link'  => $urlBase . 'controladores/labores/laboresDiariasControlador.php',
    ];
    $slide2 = [
        'badge'     => 'Trabajo en Equipo',
        'badge_bg'  => 'rgba(13, 148, 136, 0.85)',
        'title'     => 'Excelencia en Cada Entrega Operativa',
        'desc'      => 'Revisa tus tareas asignadas y coordina con tu equipo para asegurar la entrega oportuna en cada servicio.',
        'btn_text'  => '📋 Ver Mis Tareas',
        'btn_link'  => $urlBase . 'controladores/tareas/misTareasControlador.php',
    ];
    $slide3 = [
        'badge'     => 'Historial y Control',
        'badge_bg'  => 'rgba(124, 58, 237, 0.85)',
        'title'     => 'Seguimiento Integral de tus Actividades',
        'desc'      => 'Consulta tu historial completo de labores realizadas, salidas de laboratorio y seguridad de tu cuenta.',
        'btn_text'  => '📅 Historial de Labores',
        'btn_link'  => $urlBase . 'controladores/labores/historialLaboresControlador.php',
    ];
}
?>

<?php if (!defined('CARRUSEL_STYLES_LOADED')): define('CARRUSEL_STYLES_LOADED', true); ?>
<style id="carrusel-partial-styles">
    /* ---------- Contenedor Principal del Carrusel ---------- */
    .carrusel-wrapper {
        position: relative;
        width: 100%;
        margin-bottom: 28px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
        background: #0f172a;
    }

    .carrusel-container {
        position: relative;
        width: 100%;
        height: 340px;
        overflow: hidden;
    }

    .carrusel-track {
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        will-change: transform;
    }

    /* ---------- Cada Slide ---------- */
    .carrusel-slide {
        min-width: 100%;
        height: 100%;
        position: relative;
        flex-shrink: 0;
        display: flex;
        align-items: flex-end;
    }

    .carrusel-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        filter: brightness(0.85);
        transition: transform 6s ease;
    }

    .carrusel-slide.active .carrusel-image {
        transform: scale(1.04);
    }

    /* Gradiente oscuro sobre la imagen para legibilidad */
    .carrusel-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(15, 23, 42, 0.1) 0%,
            rgba(15, 23, 42, 0.45) 50%,
            rgba(15, 23, 42, 0.92) 100%
        );
        z-index: 1;
    }

    /* Contenido textual del Slide */
    .carrusel-caption {
        position: relative;
        z-index: 2;
        padding: 32px 36px;
        color: #ffffff;
        max-width: 720px;
        animation: fadeInUp 0.7s ease-out;
    }

    .carrusel-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(4px);
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .carrusel-title {
        font-size: 24px;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 8px;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.4);
    }

    .carrusel-desc {
        font-size: 14px;
        line-height: 1.5;
        color: #e2e8f0;
        margin-bottom: 16px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.4);
    }

    .carrusel-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        color: #0f172a;
        font-weight: 700;
        font-size: 13px;
        padding: 9px 18px;
        border-radius: 8px;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.25s ease;
    }

    .carrusel-btn:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
    }

    /* ---------- Botones de Navegación (Flechas) ---------- */
    .carrusel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        outline: none;
    }

    .carrusel-arrow:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #0f172a;
        transform: translateY(-50%) scale(1.08);
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }

    .carrusel-arrow-prev {
        left: 18px;
    }

    .carrusel-arrow-next {
        right: 18px;
    }

    /* ---------- Puntos Indicadores (Dots) ---------- */
    .carrusel-dots {
        position: absolute;
        bottom: 16px;
        right: 28px;
        z-index: 10;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .carrusel-dot {
        width: 10px;
        height: 10px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.4);
        border: none;
        cursor: pointer;
        padding: 0;
        transition: all 0.3s ease;
    }

    .carrusel-dot.active {
        width: 26px;
        background: #2563eb;
        box-shadow: 0 0 8px rgba(37, 99, 235, 0.6);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .carrusel-container {
            height: 280px;
        }
        .carrusel-caption {
            padding: 20px;
        }
        .carrusel-title {
            font-size: 19px;
        }
        .carrusel-desc {
            font-size: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .carrusel-arrow {
            width: 36px;
            height: 36px;
        }
        .carrusel-arrow-prev { left: 10px; }
        .carrusel-arrow-next { right: 10px; }
        .carrusel-dots { right: 16px; bottom: 12px; }
    }
</style>
<?php endif; ?>

<!-- HTML del Carrusel -->
<div class="carrusel-wrapper" id="portalCarruselWrapper">
    <div class="carrusel-container">
        <div class="carrusel-track" id="carruselTrack">

            <!-- Slide 1 -->
            <div class="carrusel-slide active">
                <img src="<?= $urlBase ?>img/carrusel/slide1.png" alt="Portal INEES Slide 1" class="carrusel-image">
                <div class="carrusel-gradient"></div>
                <div class="carrusel-caption">
                    <span class="carrusel-badge" style="background: <?= $slide1['badge_bg'] ?>;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <?= htmlspecialchars($slide1['badge']) ?>
                    </span>
                    <h2 class="carrusel-title"><?= htmlspecialchars($slide1['title']) ?></h2>
                    <p class="carrusel-desc"><?= htmlspecialchars($slide1['desc']) ?></p>
                    <a href="<?= $slide1['btn_link'] ?>" class="carrusel-btn">
                        <span><?= htmlspecialchars($slide1['btn_text']) ?></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carrusel-slide">
                <img src="<?= $urlBase ?>img/carrusel/slide2.jpg" alt="Portal INEES Slide 2" class="carrusel-image">
                <div class="carrusel-gradient"></div>
                <div class="carrusel-caption">
                    <span class="carrusel-badge" style="background: <?= $slide2['badge_bg'] ?>;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        <?= htmlspecialchars($slide2['badge']) ?>
                    </span>
                    <h2 class="carrusel-title"><?= htmlspecialchars($slide2['title']) ?></h2>
                    <p class="carrusel-desc"><?= htmlspecialchars($slide2['desc']) ?></p>
                    <a href="<?= $slide2['btn_link'] ?>" class="carrusel-btn">
                        <span><?= htmlspecialchars($slide2['btn_text']) ?></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carrusel-slide">
                <img src="<?= $urlBase ?>img/carrusel/slide3.jpg" alt="Portal INEES Slide 3" class="carrusel-image">
                <div class="carrusel-gradient"></div>
                <div class="carrusel-caption">
                    <span class="carrusel-badge" style="background: <?= $slide3['badge_bg'] ?>;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <?= htmlspecialchars($slide3['badge']) ?>
                    </span>
                    <h2 class="carrusel-title"><?= htmlspecialchars($slide3['title']) ?></h2>
                    <p class="carrusel-desc"><?= htmlspecialchars($slide3['desc']) ?></p>
                    <a href="<?= $slide3['btn_link'] ?>" class="carrusel-btn">
                        <span><?= htmlspecialchars($slide3['btn_text']) ?></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>

        </div><!-- /.carrusel-track -->

        <!-- Flechas de navegación -->
        <button class="carrusel-arrow carrusel-arrow-prev" id="carruselPrev" aria-label="Slide anterior" title="Anterior">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="carrusel-arrow carrusel-arrow-next" id="carruselNext" aria-label="Slide siguiente" title="Siguiente">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <!-- Indicadores (Dots) -->
        <div class="carrusel-dots" id="carruselDots">
            <button class="carrusel-dot active" data-index="0" aria-label="Ir al slide 1"></button>
            <button class="carrusel-dot" data-index="1" aria-label="Ir al slide 2"></button>
            <button class="carrusel-dot" data-index="2" aria-label="Ir al slide 3"></button>
        </div>

    </div><!-- /.carrusel-container -->
</div><!-- /.carrusel-wrapper -->

<!-- Lógica JS del Carrusel -->
<?php if (!defined('CARRUSEL_SCRIPTS_LOADED')): define('CARRUSEL_SCRIPTS_LOADED', true); ?>
<script id="carrusel-partial-scripts">
    (function() {
        var wrapper = document.getElementById('portalCarruselWrapper');
        if (!wrapper) return;

        var track = document.getElementById('carruselTrack');
        var slides = track.querySelectorAll('.carrusel-slide');
        var dots = document.querySelectorAll('#carruselDots .carrusel-dot');
        var prevBtn = document.getElementById('carruselPrev');
        var nextBtn = document.getElementById('carruselNext');
        var currentIndex = 0;
        var totalSlides = slides.length;
        var autoTimer = null;
        var intervalMs = 5000;

        function goToSlide(index) {
            if (index < 0) {
                currentIndex = totalSlides - 1;
            } else if (index >= totalSlides) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }

            track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';

            slides.forEach(function(slide, idx) {
                if (idx === currentIndex) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });

            dots.forEach(function(dot, idx) {
                if (idx === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function startAutoPlay() {
            stopAutoPlay();
            autoTimer = setInterval(function() {
                goToSlide(currentIndex + 1);
            }, intervalMs);
        }

        function stopAutoPlay() {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                goToSlide(currentIndex + 1);
                startAutoPlay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                goToSlide(currentIndex - 1);
                startAutoPlay();
            });
        }

        dots.forEach(function(dot) {
            dot.addEventListener('click', function(e) {
                e.preventDefault();
                var idx = parseInt(this.getAttribute('data-index'), 10);
                goToSlide(idx);
                startAutoPlay();
            });
        });

        // Pausar con el mouse encima
        wrapper.addEventListener('mouseenter', stopAutoPlay);
        wrapper.addEventListener('mouseleave', startAutoPlay);

        // Soporte Swipe táctil
        var startX = 0;
        var endX = 0;
        wrapper.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            stopAutoPlay();
        }, { passive: true });

        wrapper.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            var diff = startX - endX;
            if (Math.abs(diff) > 40) {
                if (diff > 0) {
                    goToSlide(currentIndex + 1);
                } else {
                    goToSlide(currentIndex - 1);
                }
            }
            startAutoPlay();
        }, { passive: true });

        // Iniciar
        goToSlide(0);
        startAutoPlay();
    })();
</script>
<?php endif; ?>
