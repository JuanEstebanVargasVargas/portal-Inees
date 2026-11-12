<?php
// vistas/partials/background/animatedBackground.php
// Fondo animado Low-Poly (Geométrico 3D en movimiento)
if (!defined('ANIMATED_BG_LOADED')):
    define('ANIMATED_BG_LOADED', true);
?>
<!-- Canvas animado Low-Poly -->
<canvas id="poly-bg"></canvas>

<style id="poly-bg-styles">
    #poly-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
        pointer-events: none;
    }
    /* Asegurar que el contenido principal se renderice sobre el canvas */
    body {
        position: relative;
    }
    main, .page-wrapper, .main-content, header, aside, footer {
        position: relative;
        z-index: 1;
    }
</style>

<script id="poly-bg-scripts">
(function() {
    // Evitar inicialización doble
    if (window._polyBgInitialized) return;
    window._polyBgInitialized = true;

    const canvas = document.getElementById('poly-bg');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    let width = 0;
    let height = 0;
    let cols = 0;
    let rows = 0;
    const spacing = 130; // Tamaño aproximado de la cuadrícula base
    let points = [];
    let triangles = [];

    // Paleta de blancos y grises tenues facetados estilo low-poly 3D
    const palette = [
        '#ffffff', '#fcfcfd', '#f8fafc', '#f1f5f9', '#eef2f6', 
        '#e2e8f0', '#edf2f7', '#f4f6f9', '#f9fafb', '#f3f4f6'
    ];

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        initPoints();
    }

    function initPoints() {
        points = [];
        triangles = [];
        cols = Math.ceil(width / spacing) + 3;
        rows = Math.ceil(height / spacing) + 3;

        for (let r = 0; r < rows; r++) {
            points[r] = [];
            for (let c = 0; c < cols; c++) {
                const baseX = (c - 1) * spacing;
                const baseY = (r - 1) * spacing;
                points[r][c] = {
                    baseX: baseX,
                    baseY: baseY,
                    range: spacing * 0.45,
                    pulseSpeed: 0.0008 + Math.random() * 0.0012,
                    pulsePhase: Math.random() * Math.PI * 2
                };
            }
        }

        // Construir triángulos uniendo los vértices de la cuadrícula
        for (let r = 0; r < rows - 1; r++) {
            for (let c = 0; c < cols - 1; c++) {
                const p0 = points[r][c];
                const p1 = points[r][c + 1];
                const p2 = points[r + 1][c];
                const p3 = points[r + 1][c + 1];

                const color1 = palette[Math.floor(Math.random() * palette.length)];
                const color2 = palette[Math.floor(Math.random() * palette.length)];

                if ((r + c) % 2 === 0) {
                    triangles.push({ a: p0, b: p1, c: p2, color: color1 });
                    triangles.push({ a: p1, b: p3, c: p2, color: color2 });
                } else {
                    triangles.push({ a: p0, b: p1, c: p3, color: color1 });
                    triangles.push({ a: p0, b: p3, c: p2, color: color2 });
                }
            }
        }
    }

    let time = 0;
    function animate() {
        time += 1;
        ctx.clearRect(0, 0, width, height);

        // Mover sutilmente los vértices en un ciclo armónico
        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                const p = points[r][c];
                const shiftX = Math.sin(time * p.pulseSpeed + p.pulsePhase) * p.range;
                const shiftY = Math.cos(time * p.pulseSpeed + p.pulsePhase) * p.range;
                p.currentX = p.baseX + shiftX;
                p.currentY = p.baseY + shiftY;
            }
        }

        // Dibujar polígonos
        for (let i = 0; i < triangles.length; i++) {
            const t = triangles[i];
            ctx.beginPath();
            ctx.moveTo(t.a.currentX, t.a.currentY);
            ctx.lineTo(t.b.currentX, t.b.currentY);
            ctx.lineTo(t.c.currentX, t.c.currentY);
            ctx.closePath();

            ctx.fillStyle = t.color;
            ctx.fill();

            ctx.strokeStyle = 'rgba(215, 222, 230, 0.5)';
            ctx.lineWidth = 0.8;
            ctx.stroke();
        }

        requestAnimationFrame(animate);
    }

    window.addEventListener('resize', resize);
    resize();
    animate();
})();
</script>
<?php endif; ?>
