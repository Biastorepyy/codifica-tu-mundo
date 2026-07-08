<?php
/**
 * Página Interactiva: Repositorio de Proyectos
 * Proyecto Integrador - 3° BTI CRECE
 */

$pageTitle = "Repositorio de Proyectos";
require_once __DIR__ . '/includes/header.php';

// 1. Detección y escaneo dinámico de la carpeta de contenidos
$dirName = 'Contenido';
$dirPath = __DIR__ . '/' . $dirName;
if (!is_dir($dirPath) && is_dir(__DIR__ . '/contenidosw')) {
    $dirName = 'contenidosw';
    $dirPath = __DIR__ . '/' . $dirName;
}

$archivosEnCarpeta = [];
if (is_dir($dirPath)) {
    // Filtrar directorios y archivos ocultos
    $archivosEnCarpeta = array_filter(scandir($dirPath), function($file) use ($dirPath) {
        return !in_array($file, ['.', '..']) && is_file($dirPath . '/' . $file);
    });
}

// 2. Mapeo de metadatos académicos de la experiencia de Aprendizaje y Servicio (PAS)
$metadatosDocumentos = [
    "Anteproyecto 2026 BTI.docx" => [
        "titulo" => "Anteproyecto BTI 2026 - Propuesta Técnica",
        "descripcion" => "Documento formal de planificación inicial y propuesta técnica para los proyectos informáticos integradores a desarrollarse por el 3° BTI en el CRECE.",
        "grado" => 6,
        "autores" => "Comisión de Proyectos - 3° BTI CRECE",
        "año" => 2026,
        "pdf" => "docs/anteproyecto_2026_bti.pdf",
        "tecnologias" => ["Planificación", "Modelado UML", "Definición de Requerimientos"]
    ],
    "PAS.docx" => [
        "titulo" => "Proyecto de Aprendizaje y Servicio (PAS)",
        "descripcion" => "Guía pedagógica y memoria técnica sobre el impacto social del software. Los estudiantes aplican programación para resolver necesidades comunitarias reales en C.D.E.",
        "grado" => 5,
        "autores" => "Estudiantes del 2° y 3° BTI CRECE",
        "año" => 2026,
        "pdf" => "docs/pas_aprendizaje_servicio.pdf",
        "tecnologias" => ["Aprendizaje y Servicio", "Impacto Comunitario", "Investigación"]
    ],
    "PROYECTO_DE_3ROBTI_2025_INICIAL.docx" => [
        "titulo" => "Especificación de Requerimientos BTI 2025",
        "descripcion" => "Documento de análisis de sistemas, diagrama de entidad-relación y requisitos iniciales de la promoción egresada del año lectivo 2025.",
        "grado" => 6,
        "autores" => "Promoción 2025 - 3° BTI",
        "año" => 2025,
        "pdf" => "docs/proyecto_3robti_2025.pdf",
        "tecnologias" => ["PHP", "Base de Datos MySQL", "Flujo de Datos"]
    ],
    "PROYECTO_DE_3ROBTI_2026_INICIAL.docx" => [
        "titulo" => "Diseño y Prototipado Inicial BTI 2026",
        "descripcion" => "Esquemas preliminares de interfaz, objetivos del sistema y alcance funcional del Proyecto Integrador correspondiente a la promoción del año lectivo actual.",
        "grado" => 6,
        "autores" => "Promoción 2026 - 3° BTI",
        "año" => 2026,
        "pdf" => "docs/proyecto_3robti_2026.pdf",
        "tecnologias" => ["UI/UX", "Vercel PHP Serverless", "Lógica del Servidor"]
    ]
];

// 3. Cruzar archivos en disco con el mapeo de metadatos
$proyectosLista = [];
$idCounter = 1;

if (!empty($archivosEnCarpeta)) {
    foreach ($archivosEnCarpeta as $archivo) {
        if (isset($metadatosDocumentos[$archivo])) {
            $meta = $metadatosDocumentos[$archivo];
            
            // Comprobar si ya existe el PDF generado en docs/
            $pdfFisico = __DIR__ . '/' . $meta['pdf'];
            $enlaceFisico = $meta['pdf'];
            $esPDF = true;
            
            if (!file_exists($pdfFisico)) {
                // Fallback seguro: Enlazar al archivo Word original en la carpeta de contenidos
                $enlaceFisico = $dirName . '/' . rawurlencode($archivo);
                $esPDF = false;
            }
            
            $proyectosLista[] = [
                "id" => $idCounter++,
                "titulo" => $meta['titulo'],
                "descripcion" => $meta['descripcion'],
                "grado" => $meta['grado'],
                "autores" => $meta['autores'],
                "año" => $meta['año'],
                "enlace" => $enlaceFisico,
                "esPDF" => $esPDF,
                "archivoOriginal" => $archivo,
                "tecnologias" => $meta['tecnologias']
            ];
        } else {
            // Archivo en la carpeta que no está explícitamente en el mapeo
            $ext = pathinfo($archivo, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['docx', 'doc', 'pdf'])) {
                $proyectosLista[] = [
                    "id" => $idCounter++,
                    "titulo" => "Recurso: " . pathinfo($archivo, PATHINFO_FILENAME),
                    "descripcion" => "Documento técnico y evidencias de aprendizaje subidos a la plataforma de contenidos.",
                    "grado" => 6,
                    "autores" => "Estudiantes del BTI CRECE",
                    "año" => date('Y'),
                    "enlace" => $dirName . '/' . rawurlencode($archivo),
                    "esPDF" => (strtolower($ext) === 'pdf'),
                    "archivoOriginal" => $archivo,
                    "tecnologias" => ["Recurso Dinámico"]
                ];
            }
        }
    }
}

// 4. Mock secundario de respaldo si la carpeta estuviera vacía (para desarrollo offline)
if (empty($proyectosLista)) {
    $proyectosLista = [
        [
            "id" => 1,
            "titulo" => "Aranduka CRECE - Portal de Lectura",
            "descripcion" => "Plataforma de biblioteca digital orientada a la catalogación, publicación y consulta en línea de materiales académicos desarrollados por alumnos del CRECE.",
            "grado" => 6,
            "autores" => "Elena Martínez, Lucas Espínola, Sofía Coronel",
            "año" => 2026,
            "enlace" => "docs/aranduka_crece_proyecto.pdf",
            "esPDF" => true,
            "tecnologias" => ["PHP", "MySQL", "JavaScript", "CSS"]
        ],
        [
            "id" => 2,
            "titulo" => "EduGestor - Control de Asistencia",
            "descripcion" => "Sistema web para control de asistencia de alumnos y reporte automatizado de ausencias mediante notificaciones de correo para el cuerpo directivo del colegio.",
            "grado" => 5,
            "autores" => "Mathias Ortellado, Camila Duarte",
            "año" => 2026,
            "enlace" => "docs/edugestor_asistencia.pdf",
            "esPDF" => true,
            "tecnologias" => ["PHP", "MySQL", "CSS"]
        ],
        [
            "id" => 3,
            "titulo" => "CRECE Connect - Red de Estudiantes",
            "descripcion" => "Espacio virtual e integrador para el intercambio de apuntes académicos, foros de discusión y avisos institucionales oficiales entre los diferentes bachilleratos.",
            "grado" => 6,
            "autores" => "Juan Zárate, Valeria Bogado, Thiago Benítez",
            "año" => 2026,
            "enlace" => "docs/crece_connect_red.pdf",
            "esPDF" => true,
            "tecnologias" => ["PHP", "MySQL", "JS", "Tailwind"]
        ]
    ];
}

// 5. Procesar el Filtro por Parámetro GET
$filtroGrado = isset($_GET['grado']) ? trim($_GET['grado']) : 'todos';

// Filtrar el array
$proyectosFiltrados = [];
if ($filtroGrado === '5') {
    $proyectosFiltrados = array_filter($proyectosLista, function($p) {
        return $p['grado'] == 5;
    });
} elseif ($filtroGrado === '6') {
    $proyectosFiltrados = array_filter($proyectosLista, function($p) {
        return $p['grado'] == 6;
    });
} else {
    $proyectosFiltrados = $proyectosLista;
    $filtroGrado = 'todos';
}
?>

<main class="main-content">
    
    <!-- Encabezado de la Sección -->
    <div class="section-header">
        <h1 class="section-title" id="projects-main-title">Proyectos Integradores BTI</h1>
        <p class="section-description">Explora los sistemas informáticos diseñados por los estudiantes del 5° y 6° semestre/grado.</p>
    </div>

    <!-- Barra de Filtros (Estilo Aranduka) -->
    <div class="filter-wrapper" id="filters-container">
        <div class="filter-group">
            <span class="filter-label">Filtrar por Grado:</span>
            <a href="?grado=todos" class="filter-btn <?php echo $filtroGrado === 'todos' ? 'active' : ''; ?>" id="filter-btn-all">Todos</a>
            <a href="?grado=5" class="filter-btn <?php echo $filtroGrado === '5' ? 'active' : ''; ?>" id="filter-btn-5">5° Grado</a>
            <a href="?grado=6" class="filter-btn <?php echo $filtroGrado === '6' ? 'active' : ''; ?>" id="filter-btn-6">6° Grado</a>
        </div>
        
        <div class="results-counter" id="results-count">
            Mostrando <strong><?php echo count($proyectosFiltrados); ?></strong> de <?php echo count($proyectosLista); ?> registros cargados
        </div>
    </div>

    <!-- Grid de Tarjetas de Proyectos -->
    <div class="cards-grid" id="projects-grid">
        <?php if (empty($proyectosFiltrados)): ?>
            <div class="placeholder-container" style="grid-column: 1 / -1;">
                <div class="placeholder-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </div>
                <h3 class="placeholder-title">No se encontraron proyectos</h3>
                <p class="placeholder-text">Intenta cambiar el criterio de filtrado para ver otros registros.</p>
                <a href="?grado=todos" class="btn btn-primary" style="width: auto;">Ver todos los proyectos</a>
            </div>
        <?php else: ?>
            <?php foreach ($proyectosFiltrados as $proyecto): ?>
                <article class="project-card" data-grado="<?php echo $proyecto['grado']; ?>" id="project-card-<?php echo $proyecto['id']; ?>">
                    
                    <!-- Insignias Superiores -->
                    <div class="card-header-badge">
                        <span class="badge-grado"><?php echo $proyecto['grado']; ?>° Grado</span>
                        <span class="badge-año">Año: <?php echo $proyecto['año']; ?></span>
                    </div>
                    
                    <!-- Cuerpo de la Tarjeta -->
                    <div class="card-body">
                        <h3 class="card-title"><?php echo htmlspecialchars($proyecto['titulo']); ?></h3>
                        <p class="card-description"><?php echo htmlspecialchars($proyecto['descripcion']); ?></p>
                        
                        <!-- Metadatos de Autores -->
                        <div class="card-metadata">
                            <div class="meta-item">
                                <span class="meta-label">Autores:</span>
                                <span class="meta-value"><?php echo htmlspecialchars($proyecto['autores']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Módulos:</span>
                                <span class="meta-value">
                                    <?php echo htmlspecialchars(implode(', ', $proyecto['tecnologias'])); ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Acciones Inteligentes -->
                        <div class="card-actions" style="margin-top: auto;">
                            <?php if ($proyecto['esPDF']): ?>
                                <a href="<?php echo htmlspecialchars($proyecto['enlace']); ?>" target="_blank" class="btn btn-primary" id="btn-view-pdf-<?php echo $proyecto['id']; ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                    Ver Documento (PDF)
                                </a>
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($proyecto['enlace']); ?>" download class="btn btn-secondary" style="border-color: var(--color-primary); color: var(--color-primary); font-weight: 700;" id="btn-download-docx-<?php echo $proyecto['id']; ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="12" y1="18" x2="12" y2="12"></line>
                                        <polyline points="9 15 12 18 15 15"></polyline>
                                    </svg>
                                    Descargar Word (DOCX)
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
