<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/inees_Portal/img/logo.png">`r`n    <link rel="shortcut icon" href="/inees_Portal/img/logo.png">
    <title>Biblioteca — Portal INEES</title>
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
            --shadow-lg:     0 12px 28px -4px rgba(15,34,61,.13);
        }
        * { box-sizing: border-box; margin: 0; padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: var(--bg-page); color: var(--text-main); min-height: 100vh; }
        main { max-width: 1200px; width: 100%; margin: 0 auto; padding: 32px 20px 80px; }

        /* ── Breadcrumb ── */
        .breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:24px; }
        .breadcrumb a { color:var(--primary); text-decoration:none; font-weight:500; }
        .breadcrumb a:hover { text-decoration:underline; }
        .breadcrumb-sep { color:var(--border); }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, #0b1728 0%, #0f2b48 55%, #1a1040 100%);
            border-radius: var(--radius-lg);
            padding: 36px 40px;
            margin-bottom: 36px;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content:'';
            position:absolute;
            top:-40px; right:-40px;
            width:200px; height:200px;
            border-radius:50%;
            background: radial-gradient(circle, rgba(13,148,136,.18) 0%, transparent 70%);
        }
        .hero-icon {
            width:60px; height:60px;
            background: rgba(13,148,136,.2);
            border-radius: var(--radius-md);
            display:flex; align-items:center; justify-content:center;
            border:1px solid rgba(13,148,136,.35);
            margin-bottom:16px;
            font-size:28px;
        }
        .hero-title { font-size:26px; font-weight:800; color:#fff; margin-bottom:6px; }
        .hero-sub { font-size:14px; color:rgba(255,255,255,.65); }
        .hero-badge {
            display:inline-block;
            margin-top:12px;
            background:rgba(13,148,136,.25);
            color:#2dd4bf;
            border:1px solid rgba(13,148,136,.4);
            border-radius:20px;
            padding:3px 12px;
            font-size:11px;
            font-weight:700;
            letter-spacing:.5px;
        }

        /* ── Section header ── */
        .section-header { display:flex; align-items:center; gap:12px; margin-bottom:24px; }
        .section-header h2 { font-size:20px; font-weight:800; color:var(--text-main); }
        .section-line { flex:1; height:2px; background: linear-gradient(to right, var(--border), transparent); }
        .section-count {
            background:var(--primary-light);
            color:var(--primary);
            border:1px solid rgba(13,148,136,.3);
            border-radius:20px;
            padding:2px 10px;
            font-size:12px;
            font-weight:700;
        }

        /* ── Book Grid ── */
        .books-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:28px; }

        /* ── Book Card ── */
        .book-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            display: flex;
            flex-direction: column;
        }
        .book-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }

        /* Book cover */
        .book-cover {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .cover-sombreros { background: linear-gradient(135deg, #1e3a5f 0%, #0d4a6b 40%, #145a8a 70%, #1a7abf 100%); }
        .cover-acuerdos  { background: linear-gradient(135deg, #3d1c0a 0%, #7c3a0e 40%, #b85a1a 70%, #d4820d 100%); }
        .cover-rinoceronte { background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 70%, #10b981 100%); }

        .book-spine {
            width: 140px; height: 190px;
            border-radius: 4px 12px 12px 4px;
            box-shadow: -6px 6px 20px rgba(0,0,0,.4), inset -3px 0 8px rgba(0,0,0,.3);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 20px 14px; text-align: center;
            position: relative; overflow: hidden;
        }
        .cover-sombreros .book-spine {
            background: linear-gradient(160deg, #2563a8 0%, #1a4d8f 50%, #0f3270 100%);
            border-left: 8px solid rgba(0,0,0,.25);
        }
        .cover-acuerdos .book-spine {
            background: linear-gradient(160deg, #c47a2a 0%, #a05c18 50%, #7a3f08 100%);
            border-left: 8px solid rgba(0,0,0,.25);
        }
        .cover-rinoceronte .book-spine {
            background: linear-gradient(160deg, #059669 0%, #047857 50%, #064e3b 100%);
            border-left: 8px solid rgba(0,0,0,.25);
        }
        .book-spine::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:rgba(255,255,255,.15); }
        .spine-emoji  { font-size:36px; margin-bottom:10px; }
        .spine-title  { font-size:12px; font-weight:800; color:#fff; line-height:1.3; text-shadow:0 1px 3px rgba(0,0,0,.4); }
        .spine-author { font-size:10px; color:rgba(255,255,255,.7); margin-top:8px; font-style:italic; }

        .hats-deco { position:absolute; display:flex; gap:6px; top:12px; right:12px; }
        .hat-dot   { width:18px; height:18px; border-radius:50%; box-shadow:0 2px 6px rgba(0,0,0,.3); }

        .agreements-deco { position:absolute; display:grid; grid-template-columns:1fr 1fr; gap:6px; top:12px; right:12px; }
        .agree-dot {
            width:20px; height:20px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:800; color:#fff;
            box-shadow:0 2px 6px rgba(0,0,0,.35);
        }

        /* Book body */
        .book-body { padding: 24px 24px 20px; flex:1; display:flex; flex-direction:column; }
        .book-meta { display:flex; align-items:center; gap:8px; margin-bottom:12px; flex-wrap:wrap; }
        .book-tag { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; letter-spacing:.4px; }
        .tag-azul    { background:#dbeafe; color:#1e40af; }
        .tag-verde   { background:#d1fae5; color:#065f46; }
        .tag-naranja { background:#fef3c7; color:#92400e; }
        .tag-morado  { background:#ede9fe; color:#5b21b6; }

        .book-title   { font-size:20px; font-weight:800; color:var(--text-main); margin-bottom:4px; line-height:1.3; }
        .book-author  { font-size:13px; color:var(--text-muted); margin-bottom:14px; display:flex; align-items:center; gap:5px; }
        .book-description { font-size:13.5px; line-height:1.7; color:var(--text-muted); margin-bottom:18px; flex:1; }

        /* Concepts */
        .concepts-title {
            font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.6px;
            color:var(--text-muted); margin-bottom:12px;
            display:flex; align-items:center; gap:6px;
        }
        .concepts-title::after { content:''; flex:1; height:1px; background:var(--border-light); }
        .concepts-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:20px; }
        .concept-chip {
            display:flex; align-items:center; gap:8px;
            padding:8px 10px; border-radius:var(--radius-sm);
            font-size:12px; font-weight:600; border:1px solid;
        }
        .chip-icon { font-size:16px; flex-shrink:0; }

        .chip-blanco   { background:#f8fafc; border-color:#e2e8f0; color:#334155; }
        .chip-rojo     { background:#fff1f2; border-color:#fecdd3; color:#9f1239; }
        .chip-negro    { background:#1e293b; border-color:#334155; color:#e2e8f0; }
        .chip-amarillo { background:#fefce8; border-color:#fef08a; color:#713f12; }
        .chip-verde    { background:#f0fdf4; border-color:#bbf7d0; color:#14532d; }
        .chip-azul     { background:#eff6ff; border-color:#bfdbfe; color:#1e3a8a; }

        .chip-acuerdo-1 { background:#fef3c7; border-color:#fde68a; color:#92400e; }
        .chip-acuerdo-2 { background:#fce7f3; border-color:#f9a8d4; color:#9d174d; }
        .chip-acuerdo-3 { background:#ede9fe; border-color:#c4b5fd; color:#4c1d95; }
        .chip-acuerdo-4 { background:#d1fae5; border-color:#6ee7b7; color:#065f46; }

        .chip-rino-1 { background:#ecfdf5; border-color:#a7f3d0; color:#065f46; }
        .chip-rino-2 { background:#fff7ed; border-color:#fed7aa; color:#9a3412; }
        .chip-rino-3 { background:#fef2f2; border-color:#fecaca; color:#991b1b; }
        .chip-rino-4 { background:#f0fdf4; border-color:#bbf7d0; color:#166534; }

        /* Actions */
        .book-actions { display:flex; gap:10px; border-top:1px solid var(--border-light); padding-top:16px; }
        .btn {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 16px; border-radius:var(--radius-sm);
            border:none; cursor:pointer; font-size:13px; font-weight:600;
            text-decoration:none; transition:all .2s;
        }
        .btn-primary { background:var(--primary); color:#fff; flex:1; justify-content:center; }
        .btn-primary:hover { background:var(--primary-dark); transform:translateY(-1px); box-shadow:0 4px 12px rgba(13,148,136,.3); }
        .btn-outline { background:transparent; color:var(--text-main); border:1.5px solid var(--border); }
        .btn-outline:hover { border-color:var(--primary); color:var(--primary); background:var(--primary-light); }

        /* ── Quotes ── */
        .quotes-section { margin-top:48px; }
        .quote-cards { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .quote-card {
            background:var(--bg-card); border:1px solid var(--border); border-left:4px solid;
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
            padding:20px 22px; box-shadow:var(--shadow-sm);
        }
        .quote-card.qc-teal   { border-left-color: var(--primary); }
        .quote-card.qc-gold   { border-left-color: #d97706; }
        .quote-card.qc-purple { border-left-color: #7c3aed; }
        .quote-card.qc-rose   { border-left-color: #e11d48; }
        .quote-text { font-size:14px; font-style:italic; color:var(--text-main); line-height:1.7; margin-bottom:10px; }
        .quote-source { font-size:12px; font-weight:700; color:var(--text-muted); }

        @media (max-width:768px) {
            .books-grid { grid-template-columns:1fr; }
            .concepts-grid { grid-template-columns:1fr; }
            .quote-cards { grid-template-columns:1fr; }
            .hero { padding:24px; }
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
        <span>Talento Humano</span>
        <span class="breadcrumb-sep">›</span>
        <span>Biblioteca Organizacional</span>
    </nav>

    <!-- Hero -->
    <div class="hero">
        <div class="hero-icon">📚</div>
        <div class="hero-title">Biblioteca Organizacional</div>
        <div class="hero-sub">Lecturas recomendadas para el crecimiento personal y profesional en INEES</div>
        <div class="hero-badge">📖 Conocimiento · Desarrollo · Liderazgo</div>
    </div>

    <!-- Section title -->
    <div class="section-header">
        <h2>Libros Recomendados</h2>
        <div class="section-line"></div>
        <div class="section-count">3 libros</div>
    </div>

    <div class="books-grid">

        <!-- ══ Los 6 Sombreros para Pensar ══ -->
        <div class="book-card">
            <div class="book-cover cover-sombreros">
                <div class="hats-deco">
                    <div class="hat-dot" style="background:#fff;"></div>
                    <div class="hat-dot" style="background:#ef4444;"></div>
                    <div class="hat-dot" style="background:#1e293b;"></div>
                    <div class="hat-dot" style="background:#eab308;"></div>
                    <div class="hat-dot" style="background:#22c55e;"></div>
                    <div class="hat-dot" style="background:#3b82f6;"></div>
                </div>
                <div class="book-spine">
                    <div class="spine-emoji">🎩</div>
                    <div class="spine-title">Los 6 Sombreros para Pensar</div>
                    <div class="spine-author">Edward de Bono</div>
                </div>
            </div>
            <div class="book-body">
                <div class="book-meta">
                    <span class="book-tag tag-azul">Pensamiento Creativo</span>
                    <span class="book-tag tag-verde">Liderazgo</span>
                    <span class="book-tag tag-morado">Decisiones</span>
                </div>
                <div class="book-title">Los 6 Sombreros para Pensar</div>
                <div class="book-author">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Edward de Bono
                </div>
                <div class="book-description">
                    Una metodología que usa seis sombreros de colores para representar distintos modos de pensar. Permite a equipos y líderes explorar problemas desde múltiples ángulos de forma estructurada, mejorando la creatividad y la calidad de las decisiones grupales.
                </div>

                <div class="concepts-title">Los 6 Sombreros</div>
                <div class="concepts-grid">
                    <div class="concept-chip chip-blanco">
                        <span class="chip-icon">🎩</span>
                        <span><strong>Blanco</strong><br><small>Datos y hechos</small></span>
                    </div>
                    <div class="concept-chip chip-rojo">
                        <span class="chip-icon">🎩</span>
                        <span><strong>Rojo</strong><br><small>Emociones</small></span>
                    </div>
                    <div class="concept-chip chip-negro">
                        <span class="chip-icon">🎩</span>
                        <span><strong>Negro</strong><br><small>Riesgos y problemas</small></span>
                    </div>
                    <div class="concept-chip chip-amarillo">
                        <span class="chip-icon">🎩</span>
                        <span><strong>Amarillo</strong><br><small>Optimismo y valor</small></span>
                    </div>
                    <div class="concept-chip chip-verde">
                        <span class="chip-icon">🎩</span>
                        <span><strong>Verde</strong><br><small>Creatividad e ideas</small></span>
                    </div>
                    <div class="concept-chip chip-azul">
                        <span class="chip-icon">🎩</span>
                        <span><strong>Azul</strong><br><small>Control del proceso</small></span>
                    </div>
                </div>

                <div class="book-actions">
                    <a href="https://www.amazon.com/-/es/Edward-Bono/dp/0316178314" target="_blank" class="btn btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Explorar libro
                    </a>
                    <a href="https://www.youtube.com/results?search_query=los+6+sombreros+para+pensar" target="_blank" class="btn btn-outline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Ver resumen
                    </a>
                </div>
            </div>
        </div>

        <!-- ══ Los 4 Acuerdos ══ -->
        <div class="book-card">
            <div class="book-cover cover-acuerdos">
                <div class="agreements-deco">
                    <div class="agree-dot" style="background:#d97706;">1</div>
                    <div class="agree-dot" style="background:#db2777;">2</div>
                    <div class="agree-dot" style="background:#7c3aed;">3</div>
                    <div class="agree-dot" style="background:#059669;">4</div>
                </div>
                <div class="book-spine">
                    <div class="spine-emoji">🌟</div>
                    <div class="spine-title">Los 4 Acuerdos</div>
                    <div class="spine-author">Don Miguel Ruiz</div>
                </div>
            </div>
            <div class="book-body">
                <div class="book-meta">
                    <span class="book-tag tag-naranja">Desarrollo Personal</span>
                    <span class="book-tag tag-verde">Bienestar</span>
                    <span class="book-tag tag-morado">Filosofía Tolteca</span>
                </div>
                <div class="book-title">Los 4 Acuerdos</div>
                <div class="book-author">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Don Miguel Ruiz
                </div>
                <div class="book-description">
                    Basado en la sabiduría de los antiguos toltecas, este libro propone cuatro acuerdos simples pero transformadores con uno mismo. Practicarlos lleva a la libertad personal, el bienestar emocional y relaciones más auténticas en el trabajo y la vida.
                </div>

                <div class="concepts-title">Los 4 Acuerdos</div>
                <div class="concepts-grid">
                    <div class="concept-chip chip-acuerdo-1" style="grid-column:1/-1;">
                        <span class="chip-icon">🗣️</span>
                        <span><strong>1. Sé impecable con tus palabras</strong><br><small>Habla con integridad. Di solo lo que quieres decir.</small></span>
                    </div>
                    <div class="concept-chip chip-acuerdo-2" style="grid-column:1/-1;">
                        <span class="chip-icon">🛡️</span>
                        <span><strong>2. No te tomes nada personalmente</strong><br><small>Lo que otros dicen y hacen es su propia realidad.</small></span>
                    </div>
                    <div class="concept-chip chip-acuerdo-3" style="grid-column:1/-1;">
                        <span class="chip-icon">🔍</span>
                        <span><strong>3. No hagas suposiciones</strong><br><small>Pregunta y exprésate para evitar malentendidos.</small></span>
                    </div>
                    <div class="concept-chip chip-acuerdo-4" style="grid-column:1/-1;">
                        <span class="chip-icon">💪</span>
                        <span><strong>4. Haz siempre lo máximo que puedas</strong><br><small>Tu máximo cambia, pero siempre da lo mejor de ti.</small></span>
                    </div>
                </div>

                <div class="book-actions">
                    <a href="https://www.amazon.com/-/es/Miguel-Ruiz/dp/1878424319" target="_blank" class="btn btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Explorar libro
                    </a>
                    <a href="https://www.youtube.com/results?search_query=los+4+acuerdos+don+miguel+ruiz+resumen" target="_blank" class="btn btn-outline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Ver resumen
                    </a>
                </div>
            </div>
        </div>

        <!-- ══ El Rinoceronte ══ -->
        <div class="book-card">
            <div class="book-cover cover-rinoceronte">
                <div class="hats-deco">
                    <div class="hat-dot" style="background:#10b981;"></div>
                    <div class="hat-dot" style="background:#34d399;"></div>
                    <div class="hat-dot" style="background:#059669;"></div>
                </div>
                <div class="book-spine">
                    <div class="spine-emoji">🦏</div>
                    <div class="spine-title">El Rinoceronte</div>
                    <div class="spine-author">Scott Alexander</div>
                </div>
            </div>
            <div class="book-body">
                <div class="book-meta">
                    <span class="book-tag tag-verde">Motivación y Acción</span>
                    <span class="book-tag tag-naranja">Persistencia</span>
                    <span class="book-tag tag-azul">Mentalidad Ganadora</span>
                </div>
                <div class="book-title">El Rinoceronte</div>
                <div class="book-author">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Scott Alexander
                </div>
                <div class="book-description">
                    Un clásico vibrante de superación personal que te invita a despertar el rinoceronte que llevas dentro: cargar a toda velocidad hacia tus metas, desarrollar una piel de 5 cm de grosor resistente a las dudas y el pesimismo, y jamás rendirte en la jungla del éxito.
                </div>

                <div class="concepts-title">Claves del Rinoceronte</div>
                <div class="concepts-grid">
                    <div class="concept-chip chip-rino-1" style="grid-column:1/-1;">
                        <span class="chip-icon">⚡</span>
                        <span><strong>1. ¡Carga con toda tu fuerza!</strong><br><small>Acción masiva, audaz e inmediata hacia tus objetivos.</small></span>
                    </div>
                    <div class="concept-chip chip-rino-2" style="grid-column:1/-1;">
                        <span class="chip-icon">🛡️</span>
                        <span><strong>2. Piel de 5 centímetros</strong><br><small>Inmune a las críticas, torpedos y pesimismo del entorno.</small></span>
                    </div>
                    <div class="concept-chip chip-rino-3" style="grid-column:1/-1;">
                        <span class="chip-icon">🎯</span>
                        <span><strong>3. Ojos fijos en la meta</strong><br><small>Enfoque absoluto: los rinocerontes no miran hacia atrás.</small></span>
                    </div>
                    <div class="concept-chip chip-rino-4" style="grid-column:1/-1;">
                        <span class="chip-icon">🦏</span>
                        <span><strong>4. Cero vacilación ni pereza</strong><br><small>Diferénciate de las vacas dormidas; vive con energía y pasión.</small></span>
                    </div>
                </div>

                <div class="book-actions">
                    <a href="https://www.amazon.com/s?k=el+rinoceronte+scott+alexander" target="_blank" class="btn btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Explorar libro
                    </a>
                    <a href="https://www.youtube.com/results?search_query=el+rinoceronte+scott+alexander+resumen" target="_blank" class="btn btn-outline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Ver resumen
                    </a>
                </div>
            </div>
        </div>

    </div><!-- /books-grid -->

    <!-- ── Frases destacadas ── -->
    <div class="quotes-section">
        <div class="section-header">
            <h2>Frases para Reflexionar</h2>
            <div class="section-line"></div>
        </div>
        <div class="quote-cards">
            <div class="quote-card qc-teal">
                <div class="quote-text">¡El secreto del éxito es convertirse en un rinoceronte! Ponte tu piel de cinco centímetros de espesor y carga con toda tu fuerza.</div>
                <div class="quote-source">🦏 Scott Alexander — El Rinoceronte</div>
            </div>
            <div class="quote-card qc-gold">
                <div class="quote-text">Sé impecable con tus palabras. Habla con integridad. Di solo lo que quieres decir.</div>
                <div class="quote-source">🌟 Don Miguel Ruiz — Los 4 Acuerdos</div>
            </div>
            <div class="quote-card qc-purple">
                <div class="quote-text">Los seis sombreros te permiten pensar en paralelo, en lugar de combatirte con tus propias ideas.</div>
                <div class="quote-source">🎩 Edward de Bono — Los 6 Sombreros para Pensar</div>
            </div>
            <div class="quote-card qc-rose">
                <div class="quote-text">¡A la carga! No hay tiempo para dudas ni lamentos; cada nuevo día es una oportunidad salvaje de conquistar tus metas.</div>
                <div class="quote-source">🦏 Scott Alexander — El Rinoceronte</div>
            </div>
        </div>
    </div>

</main>
</body>
</html>
