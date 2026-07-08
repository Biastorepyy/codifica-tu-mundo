<?php
/**
 * Página Principal (Inicio)
 * Proyecto Integrador - 3° BTI CRECE
 */

$pageTitle = "Inicio";
require_once __DIR__ . '/includes/header.php';
?>

<!-- SVG Filter para efecto Gooey (oculto) -->
<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0;overflow:hidden;" aria-hidden="true">
    <defs>
        <filter id="threshold">
            <feColorMatrix in="SourceGraphic" type="matrix"
                values="1 0 0 0 0
                        0 1 0 0 0
                        0 0 1 0 0
                        0 0 0 255 -140"
                result="thresholded"/>
            <feComposite in="SourceGraphic" in2="thresholded" operator="atop"/>
        </filter>
    </defs>
</svg>

<!-- Sección Hero (Estilo Aranduka Inmersivo) -->
<section class="hero-immersive" id="hero" style="background-image: url('assets/img/foto%20grupal.jpeg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="hero-container">

        <!-- Gooey Badge Text Morphing -->
        <div class="gooey-text-container" id="gooey-hero-badge" aria-label="CRECE · 3° BTI · INFORMÁTICA" role="heading" aria-level="2">
            <div class="gooey-text-wrapper" id="gooey-wrapper">
                <span class="gooey-span" id="gooey-text1">CRECE</span>
                <span class="gooey-span" id="gooey-text2">3° BTI</span>
            </div>
        </div>

        <h1 class="hero-title" id="hero-title-main">CODIFICA TU MUNDO</h1>
        <p class="hero-lead" id="hero-lead-text">
            Explora las iniciativas de software, planificaciones académicas y evidencias de aprendizaje desarrolladas por los estudiantes del 3° Bachillerato Técnico en Informática del Centro Regional de Educación de Ciudad del Este.
        </p>
    </div>
</section>

<!-- Contenido Principal -->
<main class="main-content">
    
    <!-- Sección de Módulos Destacados -->
    <div class="section-header">
        <h2 class="section-title" id="section-modules-title">Estructura del Proyecto Integrador</h2>
        <p class="section-description">Módulos diseñados para centralizar las actividades académicas del Bachillerato.</p>
    </div>

    <div class="cards-grid" style="margin-bottom: 4rem;">
        
        <!-- Tarjeta 1: Galería -->
        <article class="project-card" style="padding: 2rem;">
            <div style="color: var(--color-primary); margin-bottom: 1rem;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </div>
            <h3 class="card-title">Galería de Evidencias</h3>
            <p class="card-description">
                Un registro visual dinámico de las exposiciones, ferias de ciencias y defensas de proyectos finales de los alumnos del CRECE.
            </p>
            <div style="margin-top: auto;">
                <a href="galeria.php" class="btn btn-secondary" id="module-gallery-btn">Explorar Galería</a>
            </div>
        </article>

        <!-- Tarjeta 2: Asistencia -->
        <article class="project-card" style="padding: 2rem;">
            <div style="color: var(--color-primary); margin-bottom: 1rem;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <h3 class="card-title">Asistencia Alumnos</h3>
            <p class="card-description">
                Consulta rápida y detallada de la asistencia de los alumnos, útil para padres y profesores.
            </p>
            <div style="margin-top: auto;">
                <a href="asistencia_padres.php" class="btn btn-secondary" id="module-attendance-btn">Consultar Asistencia</a>
            </div>
        </article>

        <!-- Tarjeta 3: Experiencias -->
        <article class="project-card" style="padding: 2rem;">
            <div style="color: var(--color-primary); margin-bottom: 1rem;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                </svg>
            </div>
            <h3 class="card-title">Experiencias y Testimonios</h3>
            <p class="card-description">
                Conoce de primera mano las experiencias y aprendizajes de nuestros alumnos durante el desarrollo del proyecto.
            </p>
            <div style="margin-top: auto;">
                <a href="experiencias.php" class="btn btn-secondary" id="module-experiences-btn">Leer Experiencias</a>
            </div>
        </article>

        <!-- Tarjeta 4: Historia -->
        <article class="project-card" style="padding: 2rem;">
            <div style="color: var(--color-primary); margin-bottom: 1rem;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <h3 class="card-title">Historia del Proyecto</h3>
            <p class="card-description">
                Descubre cómo nació el proyecto "Codifica Tu Mundo" y los objetivos que nos propusimos alcanzar.
            </p>
            <div style="margin-top: auto;">
                <a href="historia.php" class="btn btn-secondary" id="module-history-btn">Ver Historia</a>
            </div>
        </article>

    </div>

    <!-- Sección Institucional Breve -->
    <div style="background-color: #ffffff; border: 1px solid var(--color-border); border-radius: 10px; padding: 3rem; display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; box-shadow: 0 4px 20px var(--color-shadow);">
        <div style="flex: 1 1 300px;">
            <h3 style="color: var(--color-primary); font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Sobre el 3° BTI - CRECE</h3>
            <p style="color: var(--color-secondary); margin-bottom: 1.25rem; font-size: 0.95rem;">
                El Bachillerato Técnico en Informática forma profesionales técnicos capaces de planificar, diseñar y programar soluciones tecnológicas reales. 
            </p>
            <p style="color: var(--color-secondary); font-size: 0.95rem;">
                El proyecto <strong>"Codifica Tu Mundo"</strong> representa la culminación de nuestro trabajo con Scratch, donde diseñamos juegos y dinámicas interactivas para enseñar lógica de programación de manera divertida a los niños de la institución.
            </p>
        </div>
        <div style="flex: 1 1 300px; display: flex; justify-content: center;">
            <div style="border-left: 3px solid var(--color-primary); padding-left: 1.5rem;">
                <blockquote style="font-style: italic; color: var(--color-text); font-weight: 500; font-size: 1.1rem; margin-bottom: 0.5rem;">
                    "La tecnología es mejor cuando junta a las personas."
                </blockquote>
                <cite style="font-size: 0.85rem; color: var(--color-secondary); font-weight: 600; text-transform: uppercase;">— Centro Regional de Educación C.D.E.</cite>
            </div>
        </div>
    </div>

</main>

<!-- ============================================================
     GOOEY TEXT MORPHING ENGINE — Pura onda coseno, flujo continuo
     CRECE ↔ 3° BTI, alternando sin pausa ni retraso.
     Período total = PERIOD segundos (cada texto ~PERIOD/2 visible).
     ============================================================ -->
<script>
(function () {
    /* ── Textos a alternar ───────────────────────────────────── */
    const T1 = 'CRECE';
    const T2 = '3° BTI';

    /* ── Duración total de un ciclo completo (CRECE→BTI→CRECE) ─
       Cada texto queda visible el ~44 % del período (≈2.5 s con 9 s).
       La transición ocupa el ~12 % (≈0.55 s).                  */
    const PERIOD = 9;          // segundos
    const BLUR   = 9;          // px de blur máximo durante la transición
    const POWER  = 0.45;       // curva de opacidad (< 0.5 = más tiempo limpio)

    const el1 = document.getElementById('gooey-text1');
    const el2 = document.getElementById('gooey-text2');
    if (!el1 || !el2) return;

    el1.textContent = T1;
    el2.textContent = T2;

    /* ── Motor ──────────────────────────────────────────────── */
    let raf;
    let pausedAt  = null;   // timestamp cuando se ocultó la pestaña
    let offset    = 0;      // acumula el tiempo pausado

    function tick(now) {
        /* tiempo efectivo, descontando pausas */
        const t = (now - offset) / 1000;

        /* fracción 0→1→0→1… con coseno suave (nunca para) */
        const raw      = (1 - Math.cos(2 * Math.PI * t / PERIOD)) / 2;

        /* ── Elevar al cuadrado estira el tiempo en los extremos
           (más tiempo "limpio") y comprime la zona de blur        */
        const fraction = raw < 0.5
            ? 2 * raw * raw
            : 1 - 2 * (1 - raw) * (1 - raw);

        /* ── Aplicar blur / opacidad ─────────────────────────── */
        const f = fraction;

        if (f <= 0.005) {
            /* el1 totalmente visible */
            el1.style.filter = ''; el1.style.opacity = '1';
            el2.style.filter = `blur(${BLUR}px)`; el2.style.opacity = '0';
        } else if (f >= 0.995) {
            /* el2 totalmente visible */
            el2.style.filter = ''; el2.style.opacity = '1';
            el1.style.filter = `blur(${BLUR}px)`; el1.style.opacity = '0';
        } else {
            /* zona de transición: ambos parcialmente visibles */
            const v1 = 1 - f;
            const v2 = f;

            el1.style.filter  = `blur(${Math.min(BLUR / v1 - BLUR, 100).toFixed(2)}px)`;
            el1.style.opacity = Math.pow(v1, POWER).toFixed(3);

            el2.style.filter  = `blur(${Math.min(BLUR / v2 - BLUR, 100).toFixed(2)}px)`;
            el2.style.opacity = Math.pow(v2, POWER).toFixed(3);
        }

        raf = requestAnimationFrame(tick);
    }

    raf = requestAnimationFrame(tick);

    /* Pausa limpia cuando la pestaña queda en segundo plano */
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            cancelAnimationFrame(raf);
            pausedAt = performance.now();
        } else {
            if (pausedAt !== null) {
                offset  += performance.now() - pausedAt;
                pausedAt = null;
            }
            raf = requestAnimationFrame(tick);
        }
    });
})();
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
