<?php
// Inicialización de variables para conservar los valores del formulario
$nombre = "";
$email = "";
$asunto = "";
$mensaje = "";
$status_message = "";
$status_type = ""; // 'success' o 'error'

// Procesamiento del formulario al enviar vía POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización de entradas
    $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $asunto = isset($_POST['asunto']) ? htmlspecialchars(trim($_POST['asunto'])) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars(trim($_POST['mensaje'])) : '';

    // Validación de campos
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        $status_message = "Por favor, completa todos los campos del formulario.";
        $status_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status_message = "La dirección de correo electrónico no es válida.";
        $status_type = "error";
    } elseif (strlen($nombre) < 3) {
        $status_message = "El nombre debe tener al menos 3 caracteres.";
        $status_type = "error";
    } elseif (strlen($mensaje) < 10) {
        $status_message = "El mensaje debe tener al menos 10 caracteres.";
        $status_type = "error";
    } else {
        // Guardamos el mensaje en base de datos o JSON local
        require_once __DIR__ . '/includes/db.php';
        db_add_mensaje($nombre, $email, $asunto, $mensaje);

        // Formatear el mensaje para WhatsApp
        $texto_wa = "*Nuevo mensaje de contacto (BTI - CRECE)*\n\n";
        $texto_wa .= "*Nombre:* " . $nombre . "\n";
        $texto_wa .= "*Email:* " . $email . "\n";
        $texto_wa .= "*Asunto:* " . $asunto . "\n\n";
        $texto_wa .= "*Mensaje:*\n" . $mensaje;
        
        $whatsapp_url = "https://api.whatsapp.com/send?phone=595973898966&text=" . urlencode($texto_wa);

        // Redirigir directamente a WhatsApp
        header("Location: " . $whatsapp_url);
        exit();
    }
}

$pageTitle = "Ubicación y Contacto";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hojas de estilos externas para esta página (Leaflet.js y FontAwesome) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos complementarios para alineación y cuadrícula simétrica */
    .symmetric-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
        margin-top: 2rem;
        margin-bottom: 4rem;
    }

    @media (max-width: 992px) {
        .symmetric-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }

    /* Estilo de la cabecera de sección secundaria */
    .section-header-custom {
        margin-bottom: 2rem;
        border-left: 4px solid var(--color-primary);
        padding-left: 1rem;
    }

    .section-header-custom h2 {
        font-size: 1.75rem;
        color: var(--color-primary);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .section-header-custom p {
        color: var(--color-secondary);
        font-size: 0.95rem;
    }

    /* Estilos de Contacto e Info */
    .contact-info-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 20px var(--color-shadow);
        margin-bottom: 2rem;
    }

    .contact-info-card h3 {
        font-size: 1.3rem;
        color: var(--color-primary);
        margin-bottom: 1.5rem;
        font-weight: 700;
        border-bottom: 1px solid var(--color-border);
        padding-bottom: 0.75rem;
    }

    .contact-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .contact-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        transition: var(--transition-fast);
    }

    .contact-item:hover .contact-icon {
        background-color: var(--color-primary);
        color: #ffffff;
        transform: scale(1.05);
    }

    .contact-text h4 {
        font-size: 1rem;
        color: var(--color-text);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .contact-text p, .contact-text a {
        font-size: 0.9rem;
        color: var(--color-secondary);
        text-decoration: none;
        line-height: 1.5;
    }

    .contact-text a:hover {
        color: var(--color-primary);
        text-decoration: underline;
    }

    /* Formulario de Contacto al estilo Pronus */
    .form-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 20px var(--color-shadow);
    }

    .form-card h3 {
        font-size: 1.3rem;
        color: var(--color-primary);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .form-card p {
        font-size: 0.9rem;
        color: var(--color-secondary);
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--color-border);
        background-color: var(--color-bg);
        border-radius: 8px;
        font-size: 0.95rem;
        font-family: var(--font-sans);
        color: var(--color-text);
        transition: var(--transition-fast);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--color-primary);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(115, 0, 20, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Alertas */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
    }

    .alert-success {
        background-color: #e6f6ee;
        color: #1b7a4b;
        border: 1px solid #c2ebd5;
    }

    .alert-error {
        background-color: #fae6e8;
        color: var(--color-primary);
        border: 1px solid #f3c2c7;
    }

    /* Mapa e indicaciones */
    .map-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 4px 20px var(--color-shadow);
        margin-bottom: 1.5rem;
    }

    #map {
        width: 100%;
        height: 380px;
        border-radius: 8px;
        z-index: 1;
    }

    .map-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 576px) {
        .map-actions {
            grid-template-columns: 1fr;
        }
    }

    .action-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: var(--color-text);
        box-shadow: 0 2px 8px var(--color-shadow);
        transition: var(--transition-smooth);
    }

    .action-card:hover {
        transform: translateY(-2px);
        border-color: var(--color-primary);
        box-shadow: 0 4px 15px rgba(115, 0, 20, 0.08);
    }

    .action-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        transition: var(--transition-fast);
    }

    .action-card:hover .action-icon {
        background-color: var(--color-primary);
        color: #ffffff;
    }

    .action-info h4 {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0.15rem;
    }

    .action-info p {
        font-size: 0.75rem;
        color: var(--color-secondary);
    }

    /* Redes Sociales */
    .social-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 20px var(--color-shadow);
        margin-bottom: 2rem;
    }

    .social-card h3 {
        font-size: 1.3rem;
        color: var(--color-primary);
        margin-bottom: 0.5rem;
        font-weight: 700;
        border-bottom: 1px solid var(--color-border);
        padding-bottom: 0.75rem;
    }

    .social-card p {
        font-size: 0.9rem;
        color: var(--color-secondary);
        margin-bottom: 1.25rem;
    }

    .social-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 576px) {
        .social-grid {
            grid-template-columns: 1fr;
        }
    }

    .social-button {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid var(--color-border);
        transition: var(--transition-smooth);
    }

    .social-button.instagram {
        background-color: #fdf2f4;
        color: #d62976;
        border-color: rgba(214, 41, 118, 0.15);
    }

    .social-button.instagram:hover {
        background-color: #d62976;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(214, 41, 118, 0.2);
        transform: translateY(-2px);
    }

    .social-button.facebook {
        background-color: #f0f4fc;
        color: #1877f2;
        border-color: rgba(24, 119, 242, 0.15);
    }

    .social-button.facebook:hover {
        background-color: #1877f2;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.2);
        transform: translateY(-2px);
    }
</style>

<!-- Sección Hero Inmersiva -->
<section class="hero-immersive" id="hero" style="background-image: url('assets/img/foto%20grupal.jpeg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="hero-container">
        <span class="hero-badge">3° BTI - CRECE</span>
        <h1 class="hero-title">Ubicación y Canales de Contacto</h1>
        <p class="hero-lead">
            Encuéntranos en Ciudad del Este, conoce nuestros horarios institucionales y envíanos un mensaje directamente desde este portal.
        </p>
    </div>
</section>

<!-- Contenido Principal -->
<main class="main-content">
    <div class="symmetric-grid">
        
        <!-- COLUMNA IZQUIERDA: Formulario e Información de Contacto -->
        <div>
            <div class="section-header-custom">
                <h2>Comunícate con Nosotros</h2>
                <p>Completa el formulario oficial o utiliza los datos directos</p>
            </div>

            <!-- Datos oficiales -->
            <div class="contact-info-card">
                <h3>Datos Oficiales</h3>
                <div class="contact-list">
                    <!-- Dirección -->
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Dirección</h4>
                            <p>Avda. Bernardino Caballero y Dra. Guillermina Núñez de Báez, Ciudad del Este, Paraguay</p>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Teléfono</h4>
                            <p><a href="tel:+595973898966">0973 898 966</a></p>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Correo Electrónico</h4>
                            <p><a href="mailto:cecrecepy@gmail.com">cecrecepy@gmail.com</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="social-card">
                <h3>Redes Sociales</h3>
                <p>Sigue nuestras cuentas oficiales institucionales para estar al día.</p>
                <div class="social-grid">
                    <a href="https://www.instagram.com/crece_marandu?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="social-button instagram">
                        <i class="fa-brands fa-instagram" style="font-size: 1.2rem;"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="https://www.facebook.com/767402356656542?ref=PROFILE_EDIT_xav_ig_profile_page_web" target="_blank" rel="noopener noreferrer" class="social-button facebook">
                        <i class="fa-brands fa-facebook-f" style="font-size: 1.2rem;"></i>
                        <span>Facebook</span>
                    </a>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="form-card">
                <h3>Envíanos un mensaje</h3>
                <p>Completa el formulario y responderemos a la brevedad.</p>
                
                <!-- Alerta de PHP -->
                <?php if (!empty($status_message)): ?>
                    <div class="alert alert-<?php echo $status_type; ?>">
                        <?php if ($status_type === 'success'): ?>
                            <i class="fa-solid fa-circle-check"></i>
                        <?php else: ?>
                            <i class="fa-solid fa-circle-exclamation"></i>
                        <?php endif; ?>
                        <span><?php echo $status_message; ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate>
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej. Juan Pérez" value="<?php echo $nombre; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Ej. juan@gmail.com" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Ej. Solicitud de Información" value="<?php echo $asunto; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="form-control" placeholder="Escribe tu mensaje aquí..." required><?php echo $mensaje; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i>
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
        
        <!-- COLUMNA DERECHA: Ubicación en el Mapa y Guías de GPS -->
        <div>
            <div class="section-header-custom">
                <h2>Mapa e Indicaciones</h2>
                <p>Ubicación geográfica del CRECE en Ciudad del Este</p>
            </div>

            <!-- Mapa -->
            <div class="map-card">
                <div id="map"></div>
            </div>

            <!-- Acciones del mapa -->
            <div class="map-actions">
                <a href="https://www.google.com/maps/place/Centro+Regional+de+Educaci%C3%B3n+%E2%80%93+%E2%80%9CDr.+Jos%C3%A9+Gaspar+Rodr%C3%ADguez+de+Francia%E2%80%9D/@-25.5244608,-54.6155594,16z/data=!3m1!4b1!4m6!3m5!1s0x94f68f94072b590f:0x986960ae4b052ddc!8m2!3d-25.5244608!4d-54.6129791!16s%2Fg%2F11gmcbnqtz" target="_blank" rel="noopener noreferrer" class="action-card">
                    <div class="action-icon">
                        <i class="fa-solid fa-map-pin"></i>
                    </div>
                    <div class="action-info">
                        <h4>Abrir en Google Maps</h4>
                        <p>Ver ruta en GPS</p>
                    </div>
                </a>
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <div class="action-info">
                        <h4>Cómo llegar</h4>
                        <p>Frente a la Municipalidad</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Leaflet JS para el Mapa Interactivo -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Coordenadas exactas del CRECE Ciudad del Este
        const coordLat = -25.5244608;
        const coordLng = -54.6129791;

        // Inicializar el mapa
        const map = L.map('map', {
            scrollWheelZoom: false
        }).setView([coordLat, coordLng], 16);

        // Tiles CartoDB Voyager
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        map.on('focus', () => { map.scrollWheelZoom.enable(); });
        map.on('blur', () => { map.scrollWheelZoom.disable(); });

        // Popup HTML con estilo de tipografía Plus Jakarta Sans
        const popupContent = `
            <div style="font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;">
                <h3 style="margin: 0 0 5px 0; color: #730014; font-size: 1.1rem; font-weight:700;">
                    CRECE Ciudad del Este
                </h3>
                <p style="margin: 0 0 8px 0; font-size: 0.85rem; color: #555; line-height: 1.3;">
                    Centro Regional de Educación "Dr. José Gaspar Rodríguez de Francia"
                </p>
                <p style="margin: 0 0 12px 0; font-size: 0.8rem; color: #777;">
                    <i class="fa-solid fa-location-dot" style="color: #730014; margin-right: 4px;"></i> 
                    Avda. Bernardino Caballero
                </p>
                <a href="https://www.google.com/maps/place/Centro+Regional+de+Educaci%C3%B3n+%E2%80%93+%E2%80%9CDr.+Jos%C3%A9+Gaspar+Rodr%C3%ADguez+de+Francia%E2%80%9D/@-25.5244608,-54.6155594,16z/data=!3m1!4b1!4m6!3m5!1s0x94f68f94072b590f:0x986960ae4b052ddc!8m2!3d-25.5244608!4d-54.6129791!16s%2Fg%2F11gmcbnqtz" 
                   target="_blank" 
                   style="display: inline-flex; align-items: center; gap: 6px; background-color: #730014; color: #ffffff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
                   <i class="fa-solid fa-arrow-turn-up"></i> Cómo llegar
                </a>
            </div>
        `;

        // Marcador SVG personalizado con el color primario de Pronus (#730014)
        const markerHtmlStyles = `
            background-color: #730014;
            width: 3rem;
            height: 3rem;
            display: block;
            left: -1.5rem;
            top: -1.5rem;
            position: relative;
            border-radius: 3rem 3rem 0;
            transform: rotate(45deg);
            border: 2px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        `;

        const iconInnerStyles = `
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #ffffff;
            font-size: 1.1rem;
        `;

        const customMarkerIcon = L.divIcon({
            className: "custom-pin-marker",
            iconAnchor: [0, 24],
            popupAnchor: [0, -36],
            html: `<span style="${markerHtmlStyles}"><div style="${iconInnerStyles}"><i class="fa-solid fa-graduation-cap"></i></div></span>`
        });

        const marker = L.marker([coordLat, coordLng], { icon: customMarkerIcon }).addTo(map);
        marker.bindPopup(popupContent).openPopup();
    });
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
