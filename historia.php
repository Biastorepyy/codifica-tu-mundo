<?php
/**
 * Página: Historia del BTI y CRECE
 * Proyecto Integrador - 3° BTI CRECE
 */

$pageTitle = "Historia del BTI";
require_once __DIR__ . '/includes/header.php';
?>

<style>
/* Estilos locales para la línea de tiempo interactiva (Timeline) */
.timeline-container {
    position: relative;
    max-width: 800px;
    margin: 3rem auto;
    padding: 0 1rem;
}

.timeline-container::after {
    content: '';
    position: absolute;
    width: 3px;
    background-color: var(--color-border);
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -1.5px;
    z-index: 1;
}

.timeline-block {
    position: relative;
    margin: 2rem 0;
    width: 50%;
    z-index: 2;
}

.timeline-block-left {
    left: 0;
    padding-right: 2.5rem;
    text-align: right;
}

.timeline-block-right {
    left: 50%;
    padding-left: 2.5rem;
    text-align: left;
}

/* Punto central de la línea de tiempo */
.timeline-dot {
    position: absolute;
    width: 14px;
    height: 14px;
    right: -7px;
    top: 6px;
    background-color: var(--color-primary);
    border: 3px solid #ffffff;
    border-radius: 50%;
    z-index: 10;
    transition: var(--transition-fast);
}

.timeline-block-right .timeline-dot {
    left: -7px;
}

.timeline-block:hover .timeline-dot {
    transform: scale(1.4);
    background-color: var(--color-accent-red);
}

.timeline-date {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--color-primary);
    margin-bottom: 0.25rem;
    display: inline-block;
}

.timeline-content {
    background-color: #ffffff;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid var(--color-border);
    box-shadow: 0 4px 15px var(--color-shadow);
    transition: var(--transition-smooth);
}

.timeline-block:hover .timeline-content {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    border-color: rgba(115, 0, 20, 0.15);
}

.timeline-title {
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--color-text);
}

.timeline-desc {
    font-size: 0.88rem;
    color: var(--color-secondary);
    line-height: 1.5;
}

/* Tarjeta de Misión / Visión */
.mv-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.mv-card {
    background-color: #ffffff;
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 2.5rem 2rem;
    box-shadow: 0 4px 20px var(--color-shadow);
    transition: var(--transition-smooth);
}

.mv-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    border-color: rgba(115, 0, 20, 0.15);
}

.mv-icon {
    color: var(--color-primary);
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .timeline-container::after {
        left: 20px;
    }
    
    .timeline-block {
        width: 100%;
        text-align: left;
    }
    
    .timeline-block-left {
        left: 0;
        padding-right: 0;
        padding-left: 2.5rem;
    }
    
    .timeline-block-right {
        left: 0;
        padding-left: 2.5rem;
    }
    
    
    .timeline-dot {
        left: 13px !important;
        right: auto !important;
    }
}

/* Estilos Premium para la Sección de Introducción */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400&display=swap');

.intro-premium-card {
    background-color: #ffffff;
    border: 1px solid var(--color-border);
    border-radius: 16px;
    padding: 3.5rem;
    margin-bottom: 3.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02), 0 1px 3px rgba(0, 0, 0, 0.01);
    position: relative;
    overflow: hidden;
    transition: var(--transition-smooth);
}

.intro-premium-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: linear-gradient(to bottom, var(--color-primary), var(--color-accent-blue));
}

.intro-premium-card::after {
    content: '“';
    position: absolute;
    top: -20px;
    right: 30px;
    font-size: 10rem;
    color: rgba(115, 0, 20, 0.03);
    font-family: 'Playfair Display', serif;
    font-weight: 900;
    pointer-events: none;
    line-height: 1;
}

.intro-premium-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(115, 0, 20, 0.05), 0 3px 10px rgba(0, 0, 0, 0.01);
    border-color: rgba(115, 0, 20, 0.12);
}

.intro-premium-title {
    font-family: 'Outfit', sans-serif;
    color: var(--color-primary);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    letter-spacing: -0.5px;
    position: relative;
    display: inline-block;
}

.intro-premium-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3.5px;
    background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-accent-blue) 100%);
    margin-top: 0.5rem;
    border-radius: 2px;
}

.intro-lead-paragraph {
    font-family: 'Outfit', sans-serif;
    color: #1a202c;
    font-size: 1.15rem;
    font-weight: 400;
    line-height: 1.8;
    text-align: justify;
    margin-bottom: 1.5rem;
}

.intro-lead-paragraph strong {
    font-weight: 700;
    color: var(--color-primary);
    background: linear-gradient(120deg, rgba(115, 0, 20, 0.07) 0%, rgba(115, 0, 20, 0.07) 100%);
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
}

.intro-secondary-paragraph {
    font-size: 1.02rem;
    color: var(--color-secondary);
    text-align: justify;
    line-height: 1.75;
}

.escudo-glow-container {
    position: relative;
    padding: 1.5rem;
    background: radial-gradient(circle, rgba(115, 0, 20, 0.03) 0%, rgba(255, 255, 255, 0) 70%);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

@media (max-width: 768px) {
    .intro-premium-card {
        padding: 2.25rem 1.75rem;
    }
    .intro-premium-title {
        font-size: 1.6rem;
    }
    .intro-lead-paragraph {
        font-size: 1.05rem;
    }
}
</style>

<main class="main-content">
    
    <!-- Encabezado de la Sección -->
    <div class="section-header">
        <h1 class="section-title" id="history-main-title">Nuestra Historia</h1>
        <p class="section-description">Reseña del Centro Regional y la evolución tecnológica del Bachillerato en Informática.</p>
    </div>

    <!-- Introducción Institucional -->
    <div class="intro-premium-card" id="intro-card">
        <div style="max-width: 900px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 2.5rem; align-items: center;">
            <div style="flex: 2 1 400px;">
                <h2 class="intro-premium-title" id="intro-title">
                    El Centro Regional de Educación C.D.E.
                </h2>
                <p class="intro-lead-paragraph">
                    Fundado oficialmente el <strong>10 de marzo de 1977</strong>, el Centro Regional de Educación "Dr. José Gaspar Rodríguez de Francia" (CRECE) nació con la misión de convertirse en el eje pedagógico y formador del Alto Paraná. Inicialmente liderado por la destacada <strong>Prof. Dra. Guillermina Núñez de Báez</strong>, la institución ha graduado a miles de líderes y profesionales de la región del Este.
                </p>
                <p class="intro-secondary-paragraph">
                    El Bachillerato Técnico en Informática (BTI) constituye una de sus ofertas más demandadas, preparando a los estudiantes para enfrentar los desafíos de la revolución del software y redes desde sus aulas técnicas equipadas.
                </p>
            </div>
            
            <div style="flex: 1 1 200px; display: flex; justify-content: center; align-items: center;">
                <!-- Escudo oficial del CRECE -->
                <div class="escudo-glow-container">
                    <div id="escudo-frame" style="display:flex; flex-direction:column; align-items:center; gap:0.75rem;">
                        <img
                            src="assets/img/escudo_crece.png"
                            alt="Escudo oficial del Centro Regional de Educación CRECE - Ciudad del Este"
                            id="escudo-crece-img"
                            style="
                                width: 190px;
                                height: auto;
                                display: block;
                                transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
                            "
                            onmouseover="this.style.transform='translateY(-5px) scale(1.04)';"
                            onmouseout="this.style.transform='translateY(0) scale(1)';"
                        />
                        <!-- Badge año institucional -->
                        <div style="
                            background: linear-gradient(135deg, #730014 0%, #50000d 100%);
                            color: #ffffff;
                            font-size: 0.72rem;
                            font-weight: 700;
                            letter-spacing: 2px;
                            text-transform: uppercase;
                            padding: 0.3rem 1rem;
                            border-radius: 50px;
                            box-shadow: 0 3px 10px rgba(115,0,20,0.25);
                        ">Desde 1977</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
