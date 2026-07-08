<?php
/**
 * Página: Planificaciones Curriculares
 * Proyecto Integrador - 3° BTI CRECE
 */

$pageTitle = "Planificaciones Curriculares";
require_once __DIR__ . '/includes/header.php';

// Array estructurado de asignaturas técnicas del BTI (Grados 5to y 6to / Años 2025 y 2026)
// Balanceado para que ambos cursos tengan asignaturas en ambos periodos anuales
$planificaciones = [
    [
        "id" => 1,
        "materia" => "Programación Web III",
        "docente" => "Prof. Lic. Carlos Ferreira",
        "horas" => 120,
        "descripcion" => "Desarrollo de aplicaciones web dinámicas del lado del servidor. Arquitectura MVC, integración de bases de datos relacionales, consumo de APIs y despliegues modernos utilizando entornos Serverless en Vercel.",
        "temas" => ["PHP Orientado a Objetos", "Arquitectura Serverless", "Acceso a Datos (PDO)", "Seguridad Web"],
        "pdf" => "docs/planificacion_programacion.pdf",
        "grado" => "6to",
        "fecha" => "2026-03-05",
        "fechaLabel" => "5 de Marzo, 2026"
    ],
    [
        "id" => 2,
        "materia" => "Bases de Datos II",
        "docente" => "Prof. Ing. Andrea Espínola",
        "horas" => 80,
        "descripcion" => "Modelado conceptual, lógico y físico avanzado de bases de datos relacionales. Optimización de consultas SQL, creación de procedimientos almacenados, triggers, vistas, índices y mantenimiento del servidor MySQL/MariaDB.",
        "temas" => ["Normalización de Datos", "Procedimientos Almacenados", "Triggers y Vistas", "Optimización de Queries"],
        "pdf" => "docs/planificacion_base_datos.pdf",
        "grado" => "5to",
        "fecha" => "2025-03-10",
        "fechaLabel" => "10 de Marzo, 2025"
    ],
    [
        "id" => 3,
        "materia" => "Análisis y Diseño de Sistemas II",
        "docente" => "Prof. Lic. Mabel Rojas",
        "horas" => 80,
        "descripcion" => "Metodologías de desarrollo de software (Ágiles y Tradicionales). Levantamiento de requerimientos, diagramado UML completo (casos de uso, clases, secuencia), diseño de arquitectura y especificación de pruebas de software.",
        "temas" => ["Ingeniería de Requerimientos", "Diagramas UML", "Metodología SCRUM", "Modelos de Arquitectura"],
        "pdf" => "docs/planificacion_analisis.pdf",
        "grado" => "6to",
        "fecha" => "2026-03-05",
        "fechaLabel" => "5 de Marzo, 2026"
    ],
    [
        "id" => 4,
        "materia" => "Redes de Computadoras II",
        "docente" => "Prof. Ing. Gustavo Galeano",
        "horas" => 100,
        "descripcion" => "Diseño y administración de redes LAN/WAN locales. Configuración de enrutamiento estático y dinámico, direccionamiento IP (Subnetting IPv4 e IPv6), seguridad perimetral, firewalls y administración de servidores Linux.",
        "temas" => ["Subnetting IPv4/IPv6", "Protocolos de Enrutamiento", "Servicios del Servidor (DNS/DHCP)", "Seguridad de Redes"],
        "pdf" => "docs/planificacion_redes.pdf",
        "grado" => "6to",
        "fecha" => "2026-03-08",
        "fechaLabel" => "8 de Marzo, 2026"
    ],
    [
        "id" => 5,
        "materia" => "Soporte Técnico y Mantenimiento",
        "docente" => "Prof. T.S. Ricardo Benítez",
        "horas" => 60,
        "descripcion" => "Diagnóstico y resolución de fallas a nivel de hardware y sistemas operativos. Ensamblado avanzado de computadoras, virtualización de entornos de prueba, instalación de sistemas operativos y herramientas de recuperación.",
        "temas" => ["Mantenimiento Correctivo", "Virtualización", "Instalación de S.O.", "Diagnóstico de Hardware"],
        "pdf" => "docs/planificacion_soporte.pdf",
        "grado" => "5to",
        "fecha" => "2025-03-12",
        "fechaLabel" => "12 de Marzo, 2025"
    ],
    [
        "id" => 6,
        "materia" => "Programación Web I",
        "docente" => "Prof. Lic. Carlos Ferreira",
        "horas" => 100,
        "descripcion" => "Introducción al desarrollo web frontend. Maquetación estructurada con HTML5, hojas de estilo en cascada CSS3, diseño adaptable (responsive) y fundamentos de programación lógica con JavaScript.",
        "temas" => ["HTML5 Semántico", "Flexbox y Grid", "Fundamentos de JS", "CSS Transiciones"],
        "pdf" => "docs/planificacion_programacion.pdf",
        "grado" => "5to",
        "fecha" => "2025-03-05",
        "fechaLabel" => "5 de Marzo, 2025"
    ],
    [
        "id" => 7,
        "materia" => "Bases de Datos I",
        "docente" => "Prof. Ing. Andrea Espínola",
        "horas" => 80,
        "descripcion" => "Conceptos fundamentales de sistemas de gestión de bases de datos. Modelo Entidad-Relación, álgebra relacional y diseño básico utilizando sentencias estructuradas SQL DDL y DML.",
        "temas" => ["Modelo Entidad-Relación", "Sentencias DDL/DML", "Claves Primarias y Foráneas", "Consultas Simples"],
        "pdf" => "docs/planificacion_base_datos.pdf",
        "grado" => "5to",
        "fecha" => "2025-03-08",
        "fechaLabel" => "8 de Marzo, 2025"
    ],
    [
        "id" => 8,
        "materia" => "Programación Web II",
        "docente" => "Prof. Lic. Carlos Ferreira",
        "horas" => 100,
        "descripcion" => "Desarrollo del lado del cliente avanzado e introducción al entorno backend. Consumo de servicios RESTful mediante APIs, manipulación avanzada de DOM, asincronía y bases del runtime Node.js.",
        "temas" => ["Fetch API y JSON", "JavaScript Asíncrono", "Node.js Básico", "Esquemas de Autenticación"],
        "pdf" => "docs/planificacion_programacion.pdf",
        "grado" => "6to",
        "fecha" => "2025-03-05",
        "fechaLabel" => "5 de Marzo, 2025"
    ],
    [
        "id" => 9,
        "materia" => "Análisis y Diseño de Sistemas I",
        "docente" => "Prof. Lic. Mabel Rojas",
        "horas" => 80,
        "descripcion" => "Fundamentos del ciclo de vida del desarrollo de software. Captura de requisitos iniciales, prototipado rápido de interfaces de usuario (wireframing) y flujos de procesos de negocio.",
        "temas" => ["Ciclo de Vida del Software", "Prototipado (Wireframes)", "Diagramas de Flujo", "Modelado de Negocios"],
        "pdf" => "docs/planificacion_analisis.pdf",
        "grado" => "5to",
        "fecha" => "2026-03-10",
        "fechaLabel" => "10 de Marzo, 2026"
    ],
    [
        "id" => 10,
        "materia" => "Redes de Computadoras I",
        "docente" => "Prof. Ing. Gustavo Galeano",
        "horas" => 80,
        "descripcion" => "Fundamentos de redes y comunicaciones de datos. Modelo de referencia OSI y TCP/IP, cableado estructurado, normas EIA/TIA y configuración básica inicial de switches Cisco.",
        "temas" => ["Modelo OSI", "Cableado UTP", "Direccionamiento IP Básico", "Switches y VLANs"],
        "pdf" => "docs/planificacion_redes.pdf",
        "grado" => "5to",
        "fecha" => "2026-03-08",
        "fechaLabel" => "8 de Marzo, 2026"
    ]
];
?>

<style>
/* Selectores Premium */
.premium-select {
    padding: 0.45rem 1.8rem 0.45rem 0.8rem;
    border-radius: 6px;
    border: 1px solid var(--color-border);
    outline: none;
    font-size: 0.88rem;
    color: var(--color-secondary);
    background-color: #ffffff;
    cursor: pointer;
    font-family: var(--font-sans);
    transition: var(--transition-fast);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg fill='%234a5568' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 1.25rem;
}
.premium-select:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(115, 0, 20, 0.08);
}
</style>

<main class="main-content">
    
    <!-- Encabezado de la Sección -->
    <div class="section-header">
        <h1 class="section-title" id="plans-main-title">Planificaciones Curriculares</h1>
        <p class="section-description">Consulta los planes pedagógicos y contenidos conceptuales de las áreas técnicas del BTI.</p>
    </div>

    <!-- Buscador e Filtros Interactivos -->
    <div class="filter-wrapper" style="margin-bottom: 2.5rem; padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; align-items: stretch;" id="search-container">
        <!-- Fila de búsqueda y contador -->
        <div style="width: 100%; display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: space-between; align-items: center;">
            <div style="position: relative; flex: 1; min-width: 280px;">
                <input type="text" id="searchInput" placeholder="Buscar asignatura, docente o tema de interés..." 
                       style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: var(--font-sans); font-size: 0.95rem; outline: none; transition: var(--transition-fast);">
                <div style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--color-secondary); pointer-events: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>
            <div class="results-counter" style="white-space: nowrap; font-weight: 600;">
                Asignaturas: <strong id="visibleCount" style="color: var(--color-primary);"><?php echo count($planificaciones); ?></strong>
            </div>
        </div>

        <!-- Fila de filtros avanzados (Grado y Calendario) -->
        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; border-top: 1px dashed var(--color-border); padding-top: 1rem; align-items: center;">
            <div class="filter-group" id="filter-grado" style="display: flex; align-items: center; gap: 0.5rem;">
                <span class="filter-label">Curso/Grado:</span>
                <button class="filter-btn active" data-grado="todos">Todos</button>
                <button class="filter-btn" data-grado="5to">5to Grado</button>
                <button class="filter-btn" data-grado="6to">6to Grado</button>
            </div>

            <!-- Calendario Avanzado (Año, Mes y Día Exacto) -->
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-left: auto;">
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span class="filter-label" style="font-size: 0.78rem;">Año:</span>
                    <select id="select-year" class="premium-select">
                        <option value="todos">Todos</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>

                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span class="filter-label" style="font-size: 0.78rem;">Mes:</span>
                    <select id="select-month" class="premium-select">
                        <option value="todos">Todos</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>

                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span class="filter-label" style="font-size: 0.78rem;">Fecha Exacta:</span>
                    <input type="date" id="input-date" style="padding: 0.35rem 0.6rem; border-radius: 6px; border: 1px solid var(--color-border); outline: none; font-size: 0.88rem; color: var(--color-secondary); font-family: var(--font-sans);">
                    <button id="btn-clear-date" style="background: none; border: none; color: var(--color-primary); font-size: 0.82rem; font-weight: 700; cursor: pointer; display: none; margin-left: 0.25rem;">Limpiar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Planificaciones -->
    <div class="cards-grid" id="plansGrid">
        <?php foreach ($planificaciones as $plan): ?>
            <article class="project-card" id="plan-card-<?php echo $plan['id']; ?>" 
                     data-materia="<?php echo htmlspecialchars(strtolower($plan['materia'])); ?>" 
                     data-docente="<?php echo htmlspecialchars(strtolower($plan['docente'])); ?>" 
                     data-temas="<?php echo htmlspecialchars(strtolower(implode(' ', $plan['temas']))); ?>"
                     data-grado="<?php echo $plan['grado']; ?>"
                     data-fecha="<?php echo $plan['fecha']; ?>">
                
                <!-- Encabezado de Tarjeta -->
                <div class="card-header-badge" style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    <span class="badge-grado" style="background-color: var(--color-primary-light); color: var(--color-primary); font-weight: 700;">
                        <?php echo $plan['grado'] === '5to' ? '5to Grado' : '6to Grado'; ?>
                    </span>
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; background: rgba(26, 26, 117, 0.08); color: var(--color-accent-blue); padding: 0.25rem 0.75rem; border-radius: 50px;">
                        <?php echo $plan['fechaLabel']; ?>
                    </span>
                    <span class="badge-año" style="font-weight: 600; color: var(--color-secondary); margin-left: auto;"><?php echo $plan['horas']; ?> Horas</span>
                </div>
                
                <!-- Cuerpo de Tarjeta -->
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($plan['materia']); ?></h3>
                    <span style="font-size: 0.85rem; color: var(--color-secondary); font-weight: 600; margin-bottom: 0.75rem; display: block;">
                        <?php echo htmlspecialchars($plan['docente']); ?>
                    </span>
                    <p class="card-description"><?php echo htmlspecialchars($plan['descripcion']); ?></p>
                    
                    <!-- Ejes Temáticos -->
                    <div class="card-metadata" style="margin-bottom: 1.5rem;">
                        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--color-primary); letter-spacing: 0.5px; margin-bottom: 0.5rem; display: block;">Ejes Temáticos:</span>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            <?php foreach ($plan['temas'] as $tema): ?>
                                <span style="font-size: 0.75rem; background-color: #f7fafc; border: 1px solid var(--color-border); padding: 0.25rem 0.6rem; border-radius: 4px; color: var(--color-secondary);">
                                    <?php echo htmlspecialchars($tema); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="card-actions" style="margin-top: auto;">
                        <a href="<?php echo htmlspecialchars($plan['pdf']); ?>" target="_blank" class="btn btn-primary" id="btn-view-plan-<?php echo $plan['id']; ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Descargar Programa
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Mensaje si no hay resultados -->
    <div class="placeholder-container" id="noResults" style="display: none;">
        <div class="placeholder-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
        </div>
        <h3 class="placeholder-title">No hay asignaturas que coincidan</h3>
        <p class="placeholder-text">Prueba buscando términos generales como "PHP", "UML", "Hardware" o cambia los filtros de grado/fecha.</p>
    </div>

</main>

<!-- Lógica de Búsqueda y Filtros Interactiva en JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput     = document.getElementById('searchInput');
    const filterGradoBtns = document.querySelectorAll('#filter-grado .filter-btn');
    
    // Selectores de fecha avanzados
    const selectYear      = document.getElementById('select-year');
    const selectMonth     = document.getElementById('select-month');
    const inputDate       = document.getElementById('input-date');
    const btnClearDate    = document.getElementById('btn-clear-date');

    const cards           = document.querySelectorAll('#plansGrid article');
    const visibleCount    = document.getElementById('visibleCount');
    const noResults       = document.getElementById('noResults');
    const plansGrid       = document.getElementById('plansGrid');

    let activeGrado       = 'todos';
    let selectedYear      = 'todos';
    let selectedMonth     = 'todos';
    let selectedExactDate = '';
    let searchQuery       = '';

    function filterPlans() {
        let matchCount = 0;

        cards.forEach(card => {
            const materia  = card.getAttribute('data-materia');
            const docente  = card.getAttribute('data-docente');
            const temas    = card.getAttribute('data-temas');
            const grado    = card.getAttribute('data-grado');
            const fullDate = card.getAttribute('data-fecha'); // AAAA-MM-DD

            // Extraer componentes del string "AAAA-MM-DD"
            const parts = fullDate.split('-');
            const yearStr = parts[0];
            const monthStr = parts[1];

            const matchSearch = searchQuery === '' || 
                                materia.includes(searchQuery) || 
                                docente.includes(searchQuery) || 
                                temas.includes(searchQuery);

            const matchGrado = activeGrado === 'todos' || grado === activeGrado;
            
            // Filtros de fecha
            const matchYear  = selectedYear === 'todos' || yearStr === selectedYear;
            const matchMonth = selectedMonth === 'todos' || monthStr === selectedMonth;
            const matchExactDate = selectedExactDate === '' || fullDate === selectedExactDate;

            if (matchSearch && matchGrado && matchYear && matchMonth && matchExactDate) {
                card.style.display = '';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Actualizar contador
        visibleCount.textContent = matchCount;

        // Mostrar / Ocultar mensaje de no resultados
        if (matchCount === 0) {
            plansGrid.style.display = 'none';
            noResults.style.display = 'block';
        } else {
            plansGrid.style.display = '';
            noResults.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', () => {
        searchQuery = searchInput.value.toLowerCase().trim();
        filterPlans();
    });

    filterGradoBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterGradoBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeGrado = btn.getAttribute('data-grado');
            filterPlans();
        });
    });

    // Listeners del Calendario y Selects
    selectYear.addEventListener('change', () => {
        selectedYear = selectYear.value;
        filterPlans();
    });

    selectMonth.addEventListener('change', () => {
        selectedMonth = selectMonth.value;
        filterPlans();
    });

    inputDate.addEventListener('input', () => {
        selectedExactDate = inputDate.value; // Formato AAAA-MM-DD
        if (selectedExactDate) {
            btnClearDate.style.display = 'inline-block';
        } else {
            btnClearDate.style.display = 'none';
        }
        filterPlans();
    });

    btnClearDate.addEventListener('click', () => {
        inputDate.value = '';
        selectedExactDate = '';
        btnClearDate.style.display = 'none';
        filterPlans();
    });

    // Enfoque visual al escribir
    searchInput.addEventListener('focus', () => {
        searchInput.style.borderColor = 'var(--color-primary)';
        searchInput.style.boxShadow = '0 0 0 3px rgba(115, 0, 20, 0.08)';
    });

    searchInput.addEventListener('blur', () => {
        searchInput.style.borderColor = '';
        searchInput.style.boxShadow = '';
    });
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
