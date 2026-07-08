<?php
/**
 * Componente modular: Encabezado (Header)
 * Proyecto Integrador - 3° BTI CRECE
 */

// Normalizar variables si no están definidas
if (!isset($pageTitle)) {
    $pageTitle = "CODIFICA TU MUNDO";
}

// Obtener el nombre del archivo actual sin extensión para marcar la pestaña activa
$currentPage = basename($_SERVER['SCRIPT_NAME'], '.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Proyecto Integrador del 3° Bachillerato Técnico en Informática (BTI) del Centro Regional de Educación de Ciudad del Este (CRECE). Inspirado en el diseño limpio de Aranduka.">
    
    <!-- Título dinámico -->
    <title><?php echo htmlspecialchars($pageTitle); ?> | BTI</title>
    
    <!-- Favicon (Minilogo) -->
    <link rel="icon" type="image/png" href="<?php echo dirname($_SERVER['SCRIPT_NAME']) === '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/assets/img/logo.png">
    
    <!-- Estilos de Google Fonts e Iconos -->
    <link rel="stylesheet" href="<?php echo dirname($_SERVER['SCRIPT_NAME']) === '/' ? '' : dirname($_SERVER['SCRIPT_NAME']); ?>/assets/css/estilos.css?v=<?php echo time(); ?>">
    
    <script>
        // Funciones auxiliares o analíticas pueden ir aquí
    </script>
</head>
<body>
    <!-- Barra de Navegación Estilo Aranduka -->
    <header class="header-navigation">
        <div class="nav-container">
            <!-- Logotipo y Nombre Institucional -->
            <a href="index.php" class="logo-link" id="nav-brand">
                <img src="assets/img/logo.png" alt="CODIFICA TU MUNDO" class="header-logo-img">
            </a>
            
            <!-- Navegación de Escritorio -->
            <nav aria-label="Navegación principal">
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item <?php echo ($currentPage == 'index' || $currentPage == '') ? 'active' : ''; ?>">
                        <a href="index.php" id="nav-home">Inicio</a>
                    </li>
                    <li class="nav-item <?php echo ($currentPage == 'asistencia_padres') ? 'active' : ''; ?>">
                        <a href="asistencia_padres.php" id="nav-parents">Asistencia Alumnos</a>
                    </li>

                    <li class="nav-item <?php echo ($currentPage == 'galeria') ? 'active' : ''; ?>">
                        <a href="galeria.php" id="nav-gallery">Galería</a>
                    </li>
                    <li class="nav-item <?php echo ($currentPage == 'experiencias') ? 'active' : ''; ?>">
                        <a href="experiencias.php" id="nav-experiencias">Experiencias</a>
                    </li>
                    <li class="nav-item <?php echo ($currentPage == 'historia') ? 'active' : ''; ?>">
                        <a href="historia.php" id="nav-history">Historia</a>
                    </li>
                    <?php if (isset($_SESSION['bti_admin']) && $_SESSION['bti_admin'] === true): ?>
                    <li class="nav-item <?php echo in_array($currentPage, ['panel_bti', 'asistencia', 'panel_observaciones']) ? 'active' : ''; ?>">
                        <a href="panel_bti.php" id="nav-attendance">Panel BTI</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item <?php echo ($currentPage == 'login' || $currentPage == 'panel_bti') ? 'active' : ''; ?>">
                        <a href="login.php" id="nav-attendance">Panel BTI</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <!-- Botón de Acción Destacada (escritorio) -->
            <a href="ubicacion.php" class="nav-cta" id="nav-info-btn">Ubicación</a>
            
            <!-- Toggle para móviles -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Abrir menú de navegación" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Menú Móvil Desplegable (separado del header para posición fixed correcta) -->
    <div class="nav-mobile-overlay" id="navMobileOverlay" role="navigation" aria-label="Menú móvil">
        <ul class="nav-mobile-list">
            <li class="<?php echo ($currentPage == 'index' || $currentPage == '') ? 'active' : ''; ?>">
                <a href="index.php">Inicio</a>
            </li>
            <li class="<?php echo ($currentPage == 'asistencia_padres') ? 'active' : ''; ?>">
                <a href="asistencia_padres.php">Asistencia Alumnos</a>
            </li>

            <li class="<?php echo ($currentPage == 'galeria') ? 'active' : ''; ?>">
                <a href="galeria.php">Galería</a>
            </li>
            <li class="<?php echo ($currentPage == 'experiencias') ? 'active' : ''; ?>">
                <a href="experiencias.php">Experiencias</a>
            </li>
            <li class="<?php echo ($currentPage == 'historia') ? 'active' : ''; ?>">
                <a href="historia.php">Historia</a>
            </li>
            <?php if (isset($_SESSION['bti_admin']) && $_SESSION['bti_admin'] === true): ?>
            <li class="<?php echo in_array($currentPage, ['panel_bti', 'asistencia', 'panel_observaciones']) ? 'active' : ''; ?>">
                <a href="panel_bti.php">Panel BTI</a>
            </li>
            <?php else: ?>
            <li class="<?php echo ($currentPage == 'login' || $currentPage == 'panel_bti') ? 'active' : ''; ?>">
                <a href="login.php">Panel BTI</a>
            </li>
            <?php endif; ?>
        </ul>
        <a href="ubicacion.php" class="nav-mobile-cta" id="nav-mobile-info-btn">Ubicación y Contacto</a>
    </div>

