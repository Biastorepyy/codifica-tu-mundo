<?php
/**
 * Script to generate academic planning PDFs for 3° BTI CRECE
 */

require_once __DIR__ . '/fpdf.php';

class BTI_PDF extends FPDF {
    protected $materiaName;
    protected $gradoLabel;

    public function setMateriaDetails($materiaName, $gradoLabel) {
        $this->materiaName = $materiaName;
        $this->gradoLabel = $gradoLabel;
    }

    // Header
    public function Header() {
        // Draw a premium top accent band
        $this->SetFillColor(115, 0, 20); // Burgundy
        $this->Rect(0, 0, 210, 4, 'F');
        
        // Secondary accent line
        $this->SetFillColor(26, 26, 117); // Dark Blue
        $this->Rect(0, 4, 210, 1.5, 'F');
        
        $hasLogoLeft = false;
        $hasLogoRight = false;
        
        // Safely try to load left logo
        if (file_exists(__DIR__ . '/assets/img/logo.png')) {
            try {
                // Disable error reporting temporarily for image type check
                $imgSize = @getimagesize(__DIR__ . '/assets/img/logo.png');
                if ($imgSize !== false && $imgSize[2] === IMAGETYPE_PNG) {
                    $this->Image(__DIR__ . '/assets/img/logo.png', 15, 10, 16);
                    $hasLogoLeft = true;
                }
            } catch (Exception $e) {
                // Ignore image error
            }
        }
        
        // Safely try to load right logo
        if (file_exists(__DIR__ . '/assets/img/escudo_crece.png')) {
            try {
                $imgSize = @getimagesize(__DIR__ . '/assets/img/escudo_crece.png');
                if ($imgSize !== false && $imgSize[2] === IMAGETYPE_PNG) {
                    $this->Image(__DIR__ . '/assets/img/escudo_crece.png', 179, 10, 16);
                    $hasLogoRight = true;
                }
            } catch (Exception $e) {
                // Ignore image error
            }
        }
        
        // Adjust text margins based on logos
        $align = 'C';
        $leftMargin = 15;
        if ($hasLogoLeft) {
            $leftMargin = 33;
        }
        
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(115, 0, 20); // Burgundy Primary
        $this->SetX($leftMargin);
        $this->Cell(210 - $leftMargin - ($hasLogoRight ? 33 : 15), 5, utf8_decode("CENTRO REGIONAL DE EDUCACIÓN DE CIUDAD DEL ESTE"), 0, 1, $align);
        
        $this->SetFont('Arial', 'B', 9.5);
        $this->SetTextColor(26, 26, 117); // Dark Blue Accent
        $this->SetX($leftMargin);
        $this->Cell(210 - $leftMargin - ($hasLogoRight ? 33 : 15), 5, utf8_decode("Bachillerato Técnico EN INFORMÁTICA (BTI)"), 0, 1, $align);
        
        $this->SetFont('Arial', 'I', 8.5);
        $this->SetTextColor(74, 85, 104); // Slate Secondary
        $this->SetX($leftMargin);
        $this->Cell(210 - $leftMargin - ($hasLogoRight ? 33 : 15), 5, utf8_decode("Planificación Curricular & Contenido Pedagógico"), 0, 1, $align);
        
        // Line break
        $this->Ln(3);
        // Burgundy horizontal bar
        $this->SetDrawColor(115, 0, 20);
        $this->SetLineWidth(0.6);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(5);
    }

    // Footer
    public function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-18);
        // Burgundy thin line
        $this->SetDrawColor(237, 242, 247);
        $this->SetLineWidth(0.4);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(2);
        
        // Font
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(74, 85, 104);
        // Info
        $this->Cell(90, 10, utf8_decode("Proyecto Integrador - 3° BTI CRECE"), 0, 0, 'L');
        $this->Cell(90, 10, utf8_decode("Página ") . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

// Data of materias corresponding to the 5 PDF files
$pdfsData = [
    'planificacion_programacion.pdf' => [
        'materia' => 'Programación Web I, II y III',
        'descripcion' => 'El área de Programación Web del Bachillerato Técnico en Informática comprende un trayecto formativo de tres niveles (desde el 5to grado al 6to grado). Abarca el desarrollo frontend y backend, iniciando con la maquetación estructurada HTML5 semántica y estilos CSS3 adaptables con Flexbox y Grid. Prosigue con lógica avanzada en JavaScript, manipulación de DOM, consumo de APIs mediante asincronía y Fetch. Finalmente, consolida el desarrollo del lado del servidor con PHP Orientado a Objetos, patrones de diseño (MVC), acceso a datos robusto a través de PDO, seguridad web avanzada y despliegues modernos utilizando arquitecturas Serverless en la plataforma Vercel.',
        'grados' => '5to y 6to Grado',
        'docente' => 'Prof. Lic. Carlos Ferreira',
        'horas' => '320 Horas Totales',
        'unidades' => [
            [
                'titulo' => 'Nivel I: Fundamentos Frontend (5to Grado - 100 hs)',
                'temas' => [
                    'Maquetación estructurada utilizando HTML5 semántico.',
                    'Diseño visual y adaptabilidad (Responsive Web Design) con CSS3, Flexbox y Grid.',
                    'Fundamentos de lógica de programación y estructuras de control en JavaScript.',
                    'Efectos visuales y micro-animaciones con CSS Transiciones y Transformaciones.'
                ]
            ],
            [
                'titulo' => 'Nivel II: Interactividad y Asincronía (6to Grado - 100 hs)',
                'temas' => [
                    'Manipulación avanzada del Document Object Model (DOM) y eventos.',
                    'Consumo de servicios web externos y formateo de datos con Fetch API y JSON.',
                    'Asincronía en JavaScript (Promesas, Async/Await) para interfaces fluidas.',
                    'Introducción al entorno de ejecución backend básico en Node.js.',
                    'Conceptos iniciales y esquemas de autenticación del lado del cliente.'
                ]
            ],
            [
                'titulo' => 'Nivel III: Programación Backend y Servidores (6to Grado - 120 hs)',
                'temas' => [
                    'Programación Orientada a Objetos (POO) en PHP y patrón arquitectónico MVC.',
                    'Acceso a bases de datos relacionales de forma segura mediante PHP Data Objects (PDO).',
                    'Seguridad web: mitigación de vulnerabilidades SQL Injection, XSS y CSRF.',
                    'Arquitecturas modernas de despliegue Serverless en Vercel utilizando PHP runtime.'
                ]
            ]
        ],
        'competencias' => [
            'Diseñar e implementar sitios web interactivos, accesibles y adaptables a dispositivos móviles.',
            'Consumir y exponer APIs de manera eficiente utilizando formatos estandarizados (JSON).',
            'Desarrollar aplicaciones del lado del servidor seguras conectadas a bases de datos relacionales.',
            'Implementar prácticas modernas de despliegue continuo en entornos de la nube.'
        ]
    ],
    'planificacion_base_datos.pdf' => [
        'materia' => 'Bases de Datos I y II',
        'descripcion' => 'La asignatura de Bases de Datos capacita al estudiante en el diseño lógico, conceptual y físico de almacenes de datos relacionales. Abarca desde los diagramas de Entidad-Relación y la aplicación estricta de las reglas de normalización, hasta la codificación avanzada de consultas SQL mediante lenguajes de definición (DDL) y manipulación de datos (DML). Se profundiza en técnicas de optimización, indexación, vistas, transacciones seguras y el desarrollo de lógica del lado de la base de datos a través de procedimientos almacenados, triggers y funciones en el motor MySQL/MariaDB.',
        'grados' => '5to Grado (Ciclos I y II)',
        'docente' => 'Prof. Ing. Andrea Espínola',
        'horas' => '160 Horas Totales',
        'unidades' => [
            [
                'titulo' => 'Nivel I: Diseño y Consultas Básicas (80 hs)',
                'temas' => [
                    'Conceptos fundamentales y ciclo de vida de los sistemas de bases de datos.',
                    'Modelado conceptual mediante Diagramas de Entidad-Relación (DER).',
                    'Restricciones de integridad referencial, claves primarias y foráneas.',
                    'Creación de estructuras de datos utilizando comandos SQL DDL.',
                    'Manipulación de datos mediante sentencias SQL DML y consultas condicionales simples.'
                ]
            ],
            [
                'titulo' => 'Nivel II: Administración Avanzada y Programación SQL (80 hs)',
                'temas' => [
                    'Teoría y aplicación práctica del proceso de Normalización (1FN, 2FN, 3FN).',
                    'Desarrollo de lógica en el servidor mediante Procedimientos Almacenados.',
                    'Automatización y auditoría mediante Triggers (Disparadores) y Funciones.',
                    'Construcción de Vistas para la simplificación de reportes complejos.',
                    'Optimización de consultas de alto rendimiento (Queries) mediante Índices y Planes de Ejecución.'
                ]
            ]
        ],
        'competencias' => [
            'Diseñar esquemas de bases de datos relacionales normalizados que eviten la redundancia de datos.',
            'Escribir consultas SQL complejas utilizando subconsultas, uniones (JOINs) y agrupaciones.',
            'Programar rutinas automatizadas seguras dentro de la base de datos para optimizar el rendimiento de las aplicaciones.',
            'Garantizar la integridad y consistencia de los datos mediante el uso correcto de transacciones.'
        ]
    ],
    'planificacion_analisis.pdf' => [
        'materia' => 'Análisis y Diseño de Sistemas I y II',
        'descripcion' => 'Esta área curricular proporciona los marcos metodológicos necesarios para abordar el ciclo de vida del desarrollo de software desde la concepción de la idea hasta las pruebas finales. Cubre técnicas de relevamiento y especificación de requerimientos, prototipado rápido de interfaces de usuario (UI/UX), modelado visual del sistema con diagramas UML estándar, diseño de arquitecturas de software y la adopción de metodologías ágiles de gestión como Scrum para facilitar el trabajo en equipo y el desarrollo iterativo.',
        'grados' => '5to y 6to Grado',
        'docente' => 'Prof. Lic. Mabel Rojas',
        'horas' => '160 Horas Totales',
        'unidades' => [
            [
                'titulo' => 'Nivel I: Ciclo de Vida y Requisitos (5to Grado - 80 hs)',
                'temas' => [
                    'Introducción al ciclo de vida del software (Modelos en Cascada, Espiral e Iterativo).',
                    'Técnicas de relevamiento de información, entrevistas y captura de requerimientos.',
                    'Modelado conceptual y diseño de procesos de negocio utilizando diagramas de flujo.',
                    'Técnicas de prototipado rápido de interfaces de usuario y esquemas de pantalla (Wireframing).'
                ]
            ],
            [
                'titulo' => 'Nivel II: Ingeniería de Software y Metodologías Ágiles (6to Grado - 80 hs)',
                'temas' => [
                    'Ingeniería de requerimientos: especificación formal de requisitos funcionales y no funcionales.',
                    'Modelado orientado a objetos con UML: Diagramas de Casos de Uso, Clases y Secuencia.',
                    'Fundamentos de arquitectura de software y patrones arquitectónicos comunes.',
                    'Gestión ágil de proyectos mediante el marco Scrum (Sprints, Backlog, Daily Meetings).',
                    'Planificación, diseño y ejecución de casos de prueba de software (Testing).'
                ]
            ]
        ],
        'competencias' => [
            'Analizar y documentar de forma precisa las necesidades y requerimientos de un cliente o negocio.',
            'Modelar sistemas complejos utilizando la notación estándar del Lenguaje Unificado de Modelado (UML).',
            'Crear prototipos funcionales centrados en la experiencia del usuario final.',
            'Gestionar proyectos de desarrollo de software bajo metodologías ágiles en equipos multidisciplinarios.'
        ]
    ],
    'planificacion_redes.pdf' => [
        'materia' => 'Redes de Computadoras I y II',
        'descripcion' => 'La asignatura de Redes de Computadoras prepara a los estudiantes para el diseño, instalación, configuración y administración de redes locales y de área amplia (LAN/WAN). Los alumnos aprenden la teoría del direccionamiento IP y la pila de protocolos OSI y TCP/IP, el cableado estructurado e interconexión mediante switches y routers. Asimismo, se capacitan en seguridad perimetral, subnetting avanzado en IPv4 e IPv6, y la configuración de servicios esenciales del servidor en entornos Linux para habilitar la conectividad empresarial segura.',
        'grados' => '5to y 6to Grado',
        'docente' => 'Prof. Ing. Gustavo Galeano',
        'horas' => '180 Horas Totales',
        'unidades' => [
            [
                'titulo' => 'Nivel I: Fundamentos y Cableado (5to Grado - 80 hs)',
                'temas' => [
                    'Conceptos fundamentales de comunicación de datos y topologías de red.',
                    'Estudio detallado del Modelo de Referencia OSI y la arquitectura TCP/IP.',
                    'Estándares de cableado estructurado físico (normas EIA/TIA 568A/568B).',
                    'Direccionamiento lógico IP básico y configuración inicial de dispositivos de red.',
                    'Concepto y configuración básica de Switches Cisco y segmentación con VLANs.'
                ]
            ],
            [
                'titulo' => 'Nivel II: Enrutamiento y Servicios de Red (6to Grado - 100 hs)',
                'temas' => [
                    'Subnetting y división de redes avanzado en IPv4 (VLSM) y fundamentos de IPv6.',
                    'Configuración de protocolos de enrutamiento estático y dinámico en routers.',
                    'Implementación y administración de servicios críticos de red: DNS, DHCP y servidores web.',
                    'Seguridad perimetral: firewalls, listas de control de acceso (ACLs) y VPNs.',
                    'Administración básica del sistema operativo Linux para servicios del servidor.'
                ]
            ]
        ],
        'competencias' => [
            'Diseñar e implementar topologías de red LAN utilizando cableado estructurado y tecnologías inalámbricas.',
            'Configurar switches y routers Cisco utilizando comandos CLI estándar para enrutamiento y conmutación.',
            'Administrar y solucionar problemas en servidores de red en entornos Linux y Windows.',
            'Implementar medidas de seguridad para proteger los recursos de la red contra accesos no autorizados.'
        ]
    ],
    'planificacion_soporte.pdf' => [
        'materia' => 'Soporte Técnico y Mantenimiento',
        'descripcion' => 'Esta asignatura eminentemente práctica capacita al estudiante en el diagnóstico preventivo, predictivo y correctivo de fallas tanto en componentes de hardware como a nivel de sistemas operativos y software. Se estudian detalladamente las arquitecturas de computadoras modernas, las técnicas de ensamblado seguro de componentes físicos, la virtualización de entornos aislados de prueba, la instalación y optimización de sistemas operativos comerciales y de código abierto, así como el uso de herramientas profesionales de diagnóstico y recuperación ante desastres.',
        'grados' => '5to Grado',
        'docente' => 'Prof. T.S. Ricardo Benítez',
        'horas' => '60 Horas',
        'unidades' => [
            [
                'titulo' => 'Unidad Única: Diagnóstico y Mantenimiento de Equipos (60 hs)',
                'temas' => [
                    'Arquitectura interna de la computadora: componentes de hardware y compatibilidad.',
                    'Técnicas profesionales de ensamblado de computadoras y medidas de seguridad ESD.',
                    'Instalación, configuración y optimización de sistemas operativos (Windows, GNU/Linux).',
                    'Virtualización de sistemas operativos mediante hipervisores para pruebas seguras.',
                    'Técnicas de mantenimiento correctivo y preventivo de hardware y periféricos.',
                    'Diagnóstico avanzado utilizando software utilitario y herramientas de hardware.',
                    'Métodos de respaldo (backup) y recuperación de datos perdidos.'
                ]
            ]
        ],
        'competencias' => [
            'Ensamblar computadoras desde cero garantizando la compatibilidad de todos sus componentes físicos.',
            'Diagnosticar y resolver fallas físicas y lógicas en equipos informáticos de manera sistemática.',
            'Instalar y dar mantenimiento a múltiples sistemas operativos optimizando recursos.',
            'Diseñar e implementar políticas de respaldo de datos y recuperación ante fallas del sistema.'
        ]
    ]
];

// Ensure docs folder exists
$docsDir = __DIR__ . '/docs';
if (!is_dir($docsDir)) {
    mkdir($docsDir, 0777, true);
}

// Generate each PDF
foreach ($pdfsData as $filename => $data) {
    $pdf = new BTI_PDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->setMateriaDetails($data['materia'], $data['grados']);
    
    // Add page
    $pdf->AddPage();
    
    // Title of the Subject
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(115, 0, 20); // Burgundy
    $pdf->Cell(0, 10, utf8_decode(strtoupper($data['materia'])), 0, 1, 'L');
    $pdf->Ln(2);
    
    // Sub-header metadata
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(45, 55, 72); // Slate dark
    $pdf->Cell(35, 6, utf8_decode("Docente a Cargo:"), 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, utf8_decode($data['docente']), 0, 1);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 6, utf8_decode("Carga Horaria:"), 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, utf8_decode($data['horas']), 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 6, utf8_decode("Curso / Nivel:"), 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, utf8_decode($data['grados']), 0, 1);
    
    $pdf->Ln(5);
    
    // Section 1: Descripcion
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(26, 26, 117); // Blue
    $pdf->Cell(0, 8, utf8_decode("1. DESCRIPCIÓN DE LA ASIGNATURA"), 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(45, 55, 72);
    $pdf->MultiCell(0, 5, utf8_decode($data['descripcion']), 0, 'J');
    $pdf->Ln(6);
    
    // Section 2: Unidades y Temas
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(26, 26, 117); // Blue
    $pdf->Cell(0, 8, utf8_decode("2. EJES TEMÁTICOS Y UNIDADES DIDÁCTICAS"), 0, 1);
    
    foreach ($data['unidades'] as $index => $unidad) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(115, 0, 20); // Burgundy
        $pdf->Cell(0, 6, utf8_decode($unidad['titulo']), 0, 1);
        $pdf->SetTextColor(45, 55, 72);
        
        $pdf->SetFont('Arial', '', 9.5);
        foreach ($unidad['temas'] as $tema) {
            // Draw bullet
            $pdf->Cell(5, 5, utf8_decode("-"), 0, 0, 'C');
            $pdf->MultiCell(0, 5, utf8_decode($tema), 0, 'J');
        }
        $pdf->Ln(4);
    }
    
    // Section 3: Competencias
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(26, 26, 117); // Blue
    $pdf->Cell(0, 8, utf8_decode("3. COMPETENCIAS Y HABILIDADES A DESARROLLAR"), 0, 1);
    
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->SetTextColor(45, 55, 72);
    foreach ($data['competencias'] as $competencia) {
        $pdf->Cell(5, 5, utf8_decode("*"), 0, 0, 'C');
        $pdf->MultiCell(0, 5, utf8_decode($competencia), 0, 'J');
    }
    $pdf->Ln(8);
    
    // Signatures
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(74, 85, 104);
    
    // Two columns for signatures
    $x_pos = $pdf->GetX();
    $y_pos = $pdf->GetY();
    
    $pdf->SetXY($x_pos, $y_pos);
    $pdf->Cell(80, 4, "_____________________________", 0, 1, 'C');
    $pdf->Cell(80, 4, utf8_decode($data['docente']), 0, 1, 'C');
    $pdf->Cell(80, 4, utf8_decode("Docente de la Materia"), 0, 1, 'C');
    
    $pdf->SetXY($x_pos + 100, $y_pos);
    $pdf->Cell(80, 4, "_____________________________", 0, 1, 'C');
    $pdf->Cell(80, 4, utf8_decode("Dirección Académica BTI"), 0, 1, 'C');
    $pdf->Cell(80, 4, utf8_decode("Centro Regional de Educación C.D.E."), 0, 1, 'C');

    // Save PDF
    $pdfPath = $docsDir . '/' . $filename;
    $pdf->Output('F', $pdfPath);
    echo "Generated PDF: " . $pdfPath . "\n";
}

echo "All PDFs generated successfully!\n";
