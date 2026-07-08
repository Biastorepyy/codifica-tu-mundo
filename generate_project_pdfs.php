<?php
/**
 * Script to generate project PDFs for 3° BTI CRECE
 */

require_once __DIR__ . '/fpdf.php';

class BTI_Project_PDF extends FPDF {
    protected $pdfType;

    public function setPdfType($type) {
        $this->pdfType = $type;
    }

    public function Header() {
        // Top accent band - Burgundy
        $this->SetFillColor(115, 0, 20);
        $this->Rect(0, 0, 210, 4, 'F');
        // Blue accent line
        $this->SetFillColor(26, 26, 117);
        $this->Rect(0, 4, 210, 1.5, 'F');

        // Safely load left logo
        $hasLogoLeft = false;
        $hasLogoRight = false;
        if (file_exists(__DIR__ . '/assets/img/logo.png')) {
            try {
                $imgSize = @getimagesize(__DIR__ . '/assets/img/logo.png');
                if ($imgSize !== false && $imgSize[2] === IMAGETYPE_PNG) {
                    $this->Image(__DIR__ . '/assets/img/logo.png', 15, 10, 16);
                    $hasLogoLeft = true;
                }
            } catch (Exception $e) {}
        }
        if (file_exists(__DIR__ . '/assets/img/escudo_crece.png')) {
            try {
                $imgSize = @getimagesize(__DIR__ . '/assets/img/escudo_crece.png');
                if ($imgSize !== false && $imgSize[2] === IMAGETYPE_PNG) {
                    $this->Image(__DIR__ . '/assets/img/escudo_crece.png', 179, 10, 16);
                    $hasLogoRight = true;
                }
            } catch (Exception $e) {}
        }

        $leftMargin = $hasLogoLeft ? 33 : 15;
        $rightMargin = $hasLogoRight ? 33 : 15;
        $cellW = 210 - $leftMargin - $rightMargin;

        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(115, 0, 20);
        $this->SetX($leftMargin);
        $this->Cell($cellW, 5, utf8_decode("CENTRO REGIONAL DE EDUCACIÓN DE CIUDAD DEL ESTE"), 0, 1, 'C');

        $this->SetFont('Arial', 'B', 9.5);
        $this->SetTextColor(26, 26, 117);
        $this->SetX($leftMargin);
        $this->Cell($cellW, 5, utf8_decode("Bachillerato Técnico EN INFORMÁTICA (BTI)"), 0, 1, 'C');

        $this->SetFont('Arial', 'I', 8.5);
        $this->SetTextColor(74, 85, 104);
        $this->SetX($leftMargin);
        $this->Cell($cellW, 5, utf8_decode("Proyectos Integradores & Documentación Académica"), 0, 1, 'C');

        $this->Ln(3);
        $this->SetDrawColor(115, 0, 20);
        $this->SetLineWidth(0.6);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-18);
        $this->SetDrawColor(237, 242, 247);
        $this->SetLineWidth(0.4);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(2);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(74, 85, 104);
        $this->Cell(90, 10, utf8_decode("Proyecto Integrador - 3° BTI CRECE"), 0, 0, 'L');
        $this->Cell(90, 10, utf8_decode("Página ") . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

// Helper: draw a section title bar
function sectionTitle($pdf, $number, $title) {
    $pdf->SetFillColor(245, 245, 250);
    $pdf->SetDrawColor(230, 230, 240);
    $pdf->SetTextColor(26, 26, 117);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 9, utf8_decode("  $number. $title"), 'LB', 1, 'L', true);
    $pdf->Ln(2);
    $pdf->SetTextColor(45, 55, 72);
}

function bodyText($pdf, $text) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(45, 55, 72);
    $pdf->MultiCell(0, 5.5, utf8_decode($text), 0, 'J');
    $pdf->Ln(3);
}

function bulletList($pdf, $items) {
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->SetTextColor(45, 55, 72);
    foreach ($items as $item) {
        $pdf->Cell(6, 5.5, utf8_decode("-"), 0, 0, 'C');
        $pdf->MultiCell(0, 5.5, utf8_decode($item), 0, 'J');
    }
    $pdf->Ln(3);
}

$docsDir = __DIR__ . '/docs';
if (!is_dir($docsDir)) mkdir($docsDir, 0777, true);

// ==============================================================================
// PDF 1: Anteproyecto BTI 2026
// ==============================================================================
$pdf = new BTI_Project_PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(115, 0, 20);
$pdf->Cell(0, 10, utf8_decode("ANTEPROYECTO BTI 2026"), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(26, 26, 117);
$pdf->Cell(0, 7, utf8_decode("Propuesta Técnica - Proyecto Integrador"), 0, 1, 'L');
$pdf->Ln(2);

// Meta
$pdf->SetFont('Arial', 'B', 10); $pdf->SetTextColor(45, 55, 72);
$pdf->Cell(40, 6, utf8_decode("Año Lectivo:"), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, "2026", 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 6, utf8_decode("Grupo:"), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode("3° Bachillerato Técnico en Informática (BTI)"), 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 6, utf8_decode("Institución:"), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode("Centro Regional de Educación de Ciudad del Este (CRECE)"), 0, 1);
$pdf->Ln(6);

sectionTitle($pdf, 1, "RESUMEN EJECUTIVO");
bodyText($pdf, "El presente Anteproyecto describe la propuesta técnica y académica del Proyecto Integrador de la promoción 2026 del 3° Bachillerato Técnico en Informática (BTI) del Centro Regional de Educación de Ciudad del Este. El proyecto busca consolidar las competencias técnicas y metodológicas adquiridas a lo largo de la carrera, integrando el desarrollo web, las bases de datos, el análisis de sistemas y las redes en una solución de software funcional con impacto comunitario real.");

sectionTitle($pdf, 2, "DESCRIPCIÓN DEL PROYECTO");
bodyText($pdf, "El Proyecto Integrador 2026 del BTI consiste en el diseño, desarrollo y despliegue de un sistema web integral que sirve como plataforma de gestión académica y comunicacional para el CRECE. El sistema permite centralizar la documentación institucional, las planificaciones curriculares de los docentes, los proyectos de los alumnos y el historial de actividades académicas del bachillerato. Utiliza tecnologías modernas del ecosistema PHP/MySQL y se despliega en la plataforma serverless de Vercel, garantizando disponibilidad y escalabilidad.");

sectionTitle($pdf, 3, "OBJETIVOS DEL PROYECTO");
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(115, 0, 20);
$pdf->Cell(0, 6, utf8_decode("Objetivo General:"), 0, 1);
bodyText($pdf, "Desarrollar un portal web institucional completo que centralice y organice de manera digital los recursos académicos del 3° BTI del CRECE, aplicando metodologías ágiles y las mejores prácticas del desarrollo de software moderno.");

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(115, 0, 20);
$pdf->Cell(0, 6, utf8_decode("Objetivos Específicos:"), 0, 1);
bulletList($pdf, [
    "Implementar un módulo de gestión de planificaciones curriculares con funcionalidades de búsqueda y filtrado avanzado.",
    "Desarrollar un repositorio digital de proyectos académicos con acceso a documentación en formato PDF.",
    "Crear un sistema de galería fotográfica dinámica para registrar y compartir evidencias de actividades.",
    "Diseñar e implementar un módulo de control de asistencia exportable para uso docente.",
    "Garantizar la accesibilidad y compatibilidad del sistema con dispositivos móviles (diseño responsive).",
    "Desplegar la aplicación en un entorno serverless en la nube para acceso público y permanente."
]);

sectionTitle($pdf, 4, "TECNOLOGÍAS Y HERRAMIENTAS");
bulletList($pdf, [
    "Frontend: HTML5 Semántico, CSS3 (Grid, Flexbox, Variables CSS), JavaScript ES6+.",
    "Backend: PHP 8.x con arquitectura modular, programación orientada a objetos (POO).",
    "Base de Datos: MySQL/MariaDB con modelo relacional normalizado (3FN).",
    "Control de Versiones: Git con repositorio remoto en GitHub.",
    "Plataforma de Despliegue: Vercel con PHP runtime serverless.",
    "Diseño UI/UX: Sistema de diseño propio inspirado en el portal Aranduka del MEC.",
    "Generación de PDFs: Librería FPDF v1.86 para documentos institucionales."
]);

sectionTitle($pdf, 5, "EQUIPO DESARROLLADOR");
bulletList($pdf, [
    "Joseph Fretez - Desarrollo Frontend y Arquitectura del Sistema.",
    "Arnaldo Romero - Desarrollo Backend, Base de Datos y Despliegue.",
    "Mathias Galeano - UI/UX, Documentación Técnica y Control de Calidad."
]);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetTextColor(74, 85, 104);
$pdf->Cell(0, 5, utf8_decode("Documento elaborado por la Comisión de Proyectos del 3° BTI CRECE | Año Lectivo 2026"), 0, 1, 'C');

$pdf->Output('F', $docsDir . '/anteproyecto_2026_bti.pdf');
echo "Generated: anteproyecto_2026_bti.pdf\n";

// ==============================================================================
// PDF 2: PAS - Proyecto de Aprendizaje y Servicio
// ==============================================================================
$pdf2 = new BTI_Project_PDF('P', 'mm', 'A4');
$pdf2->AliasNbPages();
$pdf2->AddPage();

$pdf2->SetFont('Arial', 'B', 16);
$pdf2->SetTextColor(115, 0, 20);
$pdf2->Cell(0, 10, utf8_decode("PROYECTO DE APRENDIZAJE Y SERVICIO (PAS)"), 0, 1, 'L');
$pdf2->SetFont('Arial', 'B', 11);
$pdf2->SetTextColor(26, 26, 117);
$pdf2->Cell(0, 6, utf8_decode("Memoria Técnica y Pedagógica - Impacto Social del Software"), 0, 1, 'L');
$pdf2->Ln(2);

$pdf2->SetFont('Arial', 'B', 10); $pdf2->SetTextColor(45, 55, 72);
$pdf2->Cell(40, 6, utf8_decode("Modalidad:"), 0, 0);
$pdf2->SetFont('Arial', '', 10);
$pdf2->Cell(0, 6, utf8_decode("Aprendizaje y Servicio (PAS) - Modalidad Comunitaria"), 0, 1);
$pdf2->SetFont('Arial', 'B', 10);
$pdf2->Cell(40, 6, utf8_decode("Participantes:"), 0, 0);
$pdf2->SetFont('Arial', '', 10);
$pdf2->Cell(0, 6, utf8_decode("Estudiantes del 2° y 3° BTI CRECE"), 0, 1);
$pdf2->SetFont('Arial', 'B', 10);
$pdf2->Cell(40, 6, utf8_decode("Año:"), 0, 0);
$pdf2->SetFont('Arial', '', 10);
$pdf2->Cell(0, 6, "2026", 0, 1);
$pdf2->Ln(6);

sectionTitle($pdf2, 1, "¿QUÉ ES EL PAS?");
bodyText($pdf2, "El Proyecto de Aprendizaje y Servicio (PAS) es una metodología pedagógica innovadora que combina el aprendizaje académico con el servicio comunitario. Los estudiantes del BTI aplican los conocimientos técnicos adquiridos en clase para resolver necesidades reales y concretas de comunidades, organizaciones o instituciones del entorno de Ciudad del Este, generando un impacto social positivo y significativo al mismo tiempo que consolidan sus competencias profesionales.");

sectionTitle($pdf2, 2, "DESCRIPCIÓN DE LA INICIATIVA");
bodyText($pdf2, "En el marco del PAS, los estudiantes del 2° y 3° BTI del CRECE identificaron problemáticas tecnológicas en instituciones educativas, organizaciones sin fines de lucro y pequeñas empresas del barrio que operaban de forma manual o con sistemas obsoletos. El equipo diseñó e implementó soluciones de software a medida, incluyendo sistemas de gestión, portales informativos y herramientas de digitalización de procesos, todo de forma gratuita como servicio a la comunidad.");

sectionTitle($pdf2, 3, "LÍNEAS DE ACCIÓN DEL PAS");
bulletList($pdf2, [
    "Digitalización de procesos administrativos en instituciones educativas locales.",
    "Desarrollo de sitios web informativos para pequeños comercios y emprendedores locales.",
    "Capacitación básica en informática y alfabetización digital para adultos mayores.",
    "Diseño de materiales digitales educativos y presentaciones institucionales.",
    "Implementación de sistemas de inventario y gestión para organizaciones comunitarias.",
    "Soporte técnico gratuito y mantenimiento de equipos en escuelas del distrito."
]);

sectionTitle($pdf2, 4, "IMPACTO Y RESULTADOS");
bodyText($pdf2, "A través del PAS, los estudiantes del BTI lograron transformar su aprendizaje técnico en un bien social concreto y medible. Las soluciones desarrolladas impactaron positivamente a más de 15 organizaciones e instituciones de Ciudad del Este, beneficiando a cientos de personas. Este proceso fortaleció no solo las competencias técnicas de los alumnos, sino también sus habilidades blandas como la comunicación efectiva, el trabajo en equipo, la empatía y el sentido de responsabilidad social.");

sectionTitle($pdf2, 5, "REFLEXIÓN PEDAGÓGICA");
bodyText($pdf2, "El PAS demostró que la tecnología es una herramienta poderosa de transformación social cuando se aplica con compromiso y responsabilidad. Los estudiantes comprendieron en la práctica que el valor real del conocimiento técnico se manifiesta cuando se pone al servicio de los demás, generando soluciones que mejoran la vida cotidiana de las personas. Esta experiencia formativa es un pilar fundamental de la formación integral del Bachillerato Técnico en Informática del CRECE.");

$pdf2->Ln(8);
$pdf2->SetFont('Arial', 'I', 9);
$pdf2->SetTextColor(74, 85, 104);
$pdf2->Cell(0, 5, utf8_decode("Proyecto de Aprendizaje y Servicio | 2° y 3° BTI CRECE | C.D.E. 2026"), 0, 1, 'C');

$pdf2->Output('F', $docsDir . '/pas_aprendizaje_servicio.pdf');
echo "Generated: pas_aprendizaje_servicio.pdf\n";

// ==============================================================================
// PDF 3: Especificación de Requerimientos BTI 2025
// ==============================================================================
$pdf3 = new BTI_Project_PDF('P', 'mm', 'A4');
$pdf3->AliasNbPages();
$pdf3->AddPage();

$pdf3->SetFont('Arial', 'B', 16);
$pdf3->SetTextColor(115, 0, 20);
$pdf3->Cell(0, 10, utf8_decode("ESPECIFICACIÓN DE REQUERIMIENTOS BTI 2025"), 0, 1, 'L');
$pdf3->SetFont('Arial', 'B', 11);
$pdf3->SetTextColor(26, 26, 117);
$pdf3->Cell(0, 6, utf8_decode("Análisis de Sistemas - Promoción 2025"), 0, 1, 'L');
$pdf3->Ln(2);

$pdf3->SetFont('Arial', 'B', 10); $pdf3->SetTextColor(45, 55, 72);
$pdf3->Cell(40, 6, utf8_decode("Año Lectivo:"), 0, 0);
$pdf3->SetFont('Arial', '', 10); $pdf3->Cell(0, 6, "2025", 0, 1);
$pdf3->SetFont('Arial', 'B', 10);
$pdf3->Cell(40, 6, utf8_decode("Promoción:"), 0, 0);
$pdf3->SetFont('Arial', '', 10);
$pdf3->Cell(0, 6, utf8_decode("Egresados 3° BTI CRECE - Año 2025"), 0, 1);
$pdf3->SetFont('Arial', 'B', 10);
$pdf3->Cell(40, 6, utf8_decode("Tipo de documento:"), 0, 0);
$pdf3->SetFont('Arial', '', 10);
$pdf3->Cell(0, 6, utf8_decode("Análisis Inicial - Especificación de Requisitos del Sistema (SRS)"), 0, 1);
$pdf3->Ln(6);

sectionTitle($pdf3, 1, "DESCRIPCIÓN GENERAL DEL SISTEMA");
bodyText($pdf3, "Este documento corresponde al análisis de sistemas, diagrama de entidad-relación y levantamiento inicial de requisitos del proyecto integrador desarrollado por la promoción egresada en el año lectivo 2025 del 3° Bachillerato Técnico en Informática del CRECE. El sistema propuesto consiste en un portal web institucional con módulos de gestión de proyectos académicos, control de asistencia y galería de evidencias fotográficas.");

sectionTitle($pdf3, 2, "REQUISITOS FUNCIONALES");
bulletList($pdf3, [
    "RF-01: El sistema permitirá la visualización de planificaciones curriculares filtrables por grado y año.",
    "RF-02: El sistema habilitará la descarga de documentos académicos en formato PDF.",
    "RF-03: El sistema gestionará un repositorio de proyectos integradores con metadatos completos.",
    "RF-04: El sistema incluirá una galería fotográfica dinámica con soporte para múltiples imágenes.",
    "RF-05: El sistema dispondrá de un módulo de control de asistencia exportable.",
    "RF-06: El sistema implementará un formulario de contacto con validación del lado del servidor.",
    "RF-07: El sistema deberá ser accesible desde navegadores modernos en dispositivos móviles.",
    "RF-08: El sistema mostrará información de ubicación georreferenciada de la institución."
]);

sectionTitle($pdf3, 3, "REQUISITOS NO FUNCIONALES");
bulletList($pdf3, [
    "RNF-01: El sistema deberá cargar en menos de 3 segundos en condiciones normales de red.",
    "RNF-02: El sistema deberá ser compatible con los navegadores Chrome, Firefox y Edge.",
    "RNF-03: El sistema deberá soportar resoluciones de pantalla desde 320px hasta 4K.",
    "RNF-04: El código fuente deberá seguir los estándares PSR-12 de codificación PHP.",
    "RNF-05: El sistema deberá estar disponible 24/7 mediante despliegue en la nube.",
    "RNF-06: La base de datos deberá estar normalizada hasta la Tercera Forma Normal (3FN)."
]);

sectionTitle($pdf3, 4, "MÓDULOS IDENTIFICADOS");
bulletList($pdf3, [
    "Módulo de Inicio y Hero Section - Presentación institucional del proyecto.",
    "Módulo de Proyectos - Repositorio de documentos académicos con filtros.",
    "Módulo de Planificaciones - Gestión de programas curriculares por materia.",
    "Módulo de Galería - Visualización de evidencias fotográficas institucionales.",
    "Módulo de Experiencias - Testimonios y opiniones de estudiantes.",
    "Módulo de Historia - Contexto institucional y cronología del CRECE.",
    "Módulo de Asistencia - Control y registro de asistencia del alumnado.",
    "Módulo de Ubicación - Información de contacto y mapa interactivo."
]);

sectionTitle($pdf3, 5, "DIAGRAMA ENTIDAD-RELACIÓN (DESCRIPCIÓN)");
bodyText($pdf3, "El modelo de datos del sistema está compuesto por las siguientes entidades principales: PROYECTO (id, titulo, descripcion, grado, autores, año, enlace, tecnologias), PLANIFICACION (id, materia, docente, horas, descripcion, temas, pdf, grado, fecha), GALERIA_ITEM (id, categoria, titulo, descripcion, imagen, fecha), ASISTENCIA (id, alumno, fecha, estado, observaciones), EXPERIENCIA (id, nombre, rol, testimonio, imagen). Las relaciones se establecen mediante claves foráneas garantizando la integridad referencial del sistema.");

$pdf3->Ln(8);
$pdf3->SetFont('Arial', 'I', 9);
$pdf3->SetTextColor(74, 85, 104);
$pdf3->Cell(0, 5, utf8_decode("Especificación de Requerimientos - Promoción 2025 | 3° BTI CRECE"), 0, 1, 'C');

$pdf3->Output('F', $docsDir . '/proyecto_3robti_2025.pdf');
echo "Generated: proyecto_3robti_2025.pdf\n";

// ==============================================================================
// PDF 4: Diseño y Prototipado Inicial BTI 2026
// ==============================================================================
$pdf4 = new BTI_Project_PDF('P', 'mm', 'A4');
$pdf4->AliasNbPages();
$pdf4->AddPage();

$pdf4->SetFont('Arial', 'B', 16);
$pdf4->SetTextColor(115, 0, 20);
$pdf4->Cell(0, 10, utf8_decode("DISEÑO Y PROTOTIPADO INICIAL BTI 2026"), 0, 1, 'L');
$pdf4->SetFont('Arial', 'B', 11);
$pdf4->SetTextColor(26, 26, 117);
$pdf4->Cell(0, 6, utf8_decode("Alcance Funcional y Arquitectura del Sistema - Promoción 2026"), 0, 1, 'L');
$pdf4->Ln(2);

$pdf4->SetFont('Arial', 'B', 10); $pdf4->SetTextColor(45, 55, 72);
$pdf4->Cell(40, 6, utf8_decode("Año Lectivo:"), 0, 0);
$pdf4->SetFont('Arial', '', 10); $pdf4->Cell(0, 6, "2026", 0, 1);
$pdf4->SetFont('Arial', 'B', 10);
$pdf4->Cell(40, 6, utf8_decode("Promoción:"), 0, 0);
$pdf4->SetFont('Arial', '', 10);
$pdf4->Cell(0, 6, utf8_decode("3° BTI CRECE - Año Lectivo en Curso"), 0, 1);
$pdf4->SetFont('Arial', 'B', 10);
$pdf4->Cell(40, 6, utf8_decode("Fase del proyecto:"), 0, 0);
$pdf4->SetFont('Arial', '', 10);
$pdf4->Cell(0, 6, utf8_decode("Diseño de Interfaz, Prototipado y Definición de Alcance"), 0, 1);
$pdf4->Ln(6);

sectionTitle($pdf4, 1, "VISIÓN GENERAL DEL SISTEMA");
bodyText($pdf4, "Este documento describe los esquemas preliminares de interfaz de usuario, los objetivos del sistema y el alcance funcional del Proyecto Integrador correspondiente a la promoción del año lectivo 2026. El sistema adopta un diseño institucional moderno inspirado en el portal Aranduka del MEC, con una paleta de colores institucionales del CRECE (granate y azul marino), tipografía contemporánea y componentes de UI altamente interactivos.");

sectionTitle($pdf4, 2, "SISTEMA DE DISEÑO UI/UX");
bulletList($pdf4, [
    "Paleta de colores: Granate primario (#730014), Azul marino (#1a1a75), Gris texto (#2d3748).",
    "Tipografía: Plus Jakarta Sans (Google Fonts) - Pesos 300, 400, 500, 600, 700, 800.",
    "Sistema de grilla: CSS Grid con columnas responsivas auto-fill minmax(350px, 1fr).",
    "Componentes: Tarjetas (Cards), Modales, Filtros de píldora, Barras de progreso.",
    "Animaciones: Transiciones suaves, efectos Hover, Gooey Text Morphing en el hero.",
    "Accesibilidad: ARIA roles, contraste mínimo WCAG AA, navegación por teclado."
]);

sectionTitle($pdf4, 3, "ARQUITECTURA DEL SISTEMA");
bodyText($pdf4, "El sistema sigue una arquitectura modular basada en PHP con inclusión de componentes reutilizables (header.php, footer.php). Cada página es un archivo PHP independiente que encapsula su propia lógica de datos y presentación. La capa de datos está gestionada por MySQL con PDO para las operaciones de base de datos. El despliegue utiliza Vercel con configuración de rutas PHP serverless a través del archivo vercel.json, lo que garantiza disponibilidad global, escalabilidad automática y certificados SSL gratuitos.");

sectionTitle($pdf4, 4, "PÁGINAS Y MÓDULOS IMPLEMENTADOS");
bulletList($pdf4, [
    "index.php - Página principal con Hero inmersivo y resumen de módulos.",
    "proyectos.php - Repositorio de proyectos con filtros dinámicos.",
    "planificaciones.php - Planificaciones curriculares con búsqueda y calendarios.",
    "galeria.php - Galería fotográfica con lightbox y categorías.",
    "experiencias.php - Testimonios de estudiantes con diseño de tarjetas.",
    "historia.php - Historia institucional del CRECE.",
    "asistencia.php - Sistema de control de asistencia exportable.",
    "ubicacion.php - Mapa de ubicación y formulario de contacto."
]);

sectionTitle($pdf4, 5, "INNOVACIONES TÉCNICAS DESTACADAS");
bulletList($pdf4, [
    "Implementación de Gooey Text Morphing en CSS/JS puro para el badge del hero.",
    "Despliegue Serverless en Vercel con PHP runtime sin servidor dedicado.",
    "Generación dinámica de PDFs académicos con la librería FPDF v1.86.",
    "Sistema de filtros reactivos en JavaScript sin dependencias externas.",
    "Diseño pixel-perfect inspirado en portales educativos de referencia nacional.",
    "Exportación de asistencia a formato HTML imprimible desde el navegador."
]);

$pdf4->Ln(8);
$pdf4->SetFont('Arial', 'I', 9);
$pdf4->SetTextColor(74, 85, 104);
$pdf4->Cell(0, 5, utf8_decode("Diseño y Prototipado - Promoción 2026 | 3° BTI CRECE | Ciudad del Este"), 0, 1, 'C');

$pdf4->Output('F', $docsDir . '/proyecto_3robti_2026.pdf');
echo "Generated: proyecto_3robti_2026.pdf\n";

echo "\nAll project PDFs generated successfully!\n";
