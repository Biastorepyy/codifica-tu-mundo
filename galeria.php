<?php
session_start();
/**
 * Página: Galería de Evidencias
 * Proyecto Integrador - 3° BTI CRECE
 */
require_once __DIR__ . '/includes/db.php';

// --- Procesar subida de imagen ---
$mensajeExito = '';
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $titulo = trim($_POST['titulo'] ?? '');
    $categoria = $_POST['categoria'] ?? 'clases';
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha = date('Y-m-d');
    
    // Validaciones básicas
    if (empty($titulo)) {
        $mensajeError = "Por favor, ingresa un título para la imagen.";
    } elseif ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $mensajeError = "Ocurrió un error al subir la imagen.";
    } else {
        $tmpName = $_FILES['imagen']['tmp_name'];
        $fileName = basename($_FILES['imagen']['name']);
        
        // Generar un nombre único para evitar colisiones
        $uniqueName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '', $fileName);
        
        $uploadDir = __DIR__ . '/assets/img/galeria/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }
        $destPath = $uploadDir . $uniqueName;
        
        if (move_uploaded_file($tmpName, $destPath)) {
            $rutaRelativa = 'assets/img/galeria/' . $uniqueName;
            
            if (db_add_galeria($titulo, $descripcion, $rutaRelativa, $categoria, $fecha)) {
                $mensajeExito = "¡Imagen subida y publicada correctamente!";
            } else {
                $mensajeError = "La imagen se subió, pero no pudo guardarse en la base de datos.";
            }
        } else {
            $mensajeError = "No se pudo mover el archivo subido al directorio de destino.";
        }
    }
}


$pageTitle = "Galería de Evidencias";
require_once __DIR__ . '/includes/header.php';

// Obtener todas las imágenes usando la base de datos (o JSON fallback)
$galeriaItems = db_get_galerias();

?>

<style>
/* ── Galería Grid ───────────────────────────────── */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.75rem;
}

.gallery-card {
    background: #ffffff;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px var(--color-shadow);
    transition: transform 0.32s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.32s ease,
                border-color 0.32s ease,
                opacity 0.3s ease;
    cursor: pointer;
    opacity: 1;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 36px rgba(115,0,20,0.10);
    border-color: rgba(115,0,20,0.18);
}

.gallery-card.hidden {
    display: none;
}

/* Imagen con relación de aspecto fija */
.gallery-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    background: #f7fafc;
}

.gallery-img-wrap > img:not(.overlay-baner):not(.overlay-escudo) {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    display: block;
}

.gallery-card:hover .gallery-img-wrap > img:not(.overlay-baner):not(.overlay-escudo) {
    transform: scale(1.06);
}

/* Overlays en las tarjetas de galería */
.overlay-baner, .overlay-escudo {
    position: absolute;
    top: 12px;
    z-index: 5;
    pointer-events: none;
    transition: transform 0.3s ease;
    width: auto !important;
}
.overlay-baner {
    left: 12px;
    height: 65px !important;
}
.overlay-escudo {
    right: 12px;
    height: 85px !important;
}

/* Overlay de zoom */
.gallery-zoom-btn {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(115,0,20,0.0);
    transition: background 0.3s ease;
    border: none;
    cursor: pointer;
    width: 100%;
}

.gallery-card:hover .gallery-zoom-btn {
    background: rgba(115,0,20,0.45);
}

.gallery-zoom-icon {
    background: rgba(255,255,255,0.95);
    color: var(--color-primary);
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: scale(0.7);
    transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

.gallery-card:hover .gallery-zoom-icon {
    opacity: 1;
    transform: scale(1);
}

/* Contenido de la tarjeta */
.gallery-card-body {
    padding: 1.25rem 1.5rem;
}

.gallery-meta {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
}

.gallery-cat-badge {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--color-primary);
    color: #ffffff;
    padding: 0.25rem 0.7rem;
    border-radius: 50px;
}

.gallery-date {
    font-size: 0.82rem;
    color: var(--color-secondary);
    font-weight: 500;
}

.gallery-card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--color-text);
    margin-bottom: 0.5rem;
    line-height: 1.35;
}

.gallery-card-desc {
    font-size: 0.9rem;
    color: var(--color-secondary);
    line-height: 1.5;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ── Interfaz de Filtros Premium ────────────────── */
.filter-wrapper {
    background: #ffffff;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2.5rem;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
}

.filter-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--color-text);
    margin-right: 0.5rem;
}

.filter-btn {
    background-color: transparent;
    color: var(--color-secondary);
    border: 1px solid var(--color-border);
    padding: 0.4rem 1.25rem;
    border-radius: 50px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-fast);
    font-family: var(--font-sans);
}

.filter-btn:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
    background-color: rgba(115,0,20,0.03);
}

.filter-btn.active {
    background-color: var(--color-primary);
    color: #ffffff;
    border-color: var(--color-primary);
    box-shadow: 0 4px 12px rgba(115, 0, 20, 0.15);
}

/* ── Formulario Subida ──────────────────────────── */
.upload-wrapper {
    background: #ffffff;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
}

.upload-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.upload-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.upload-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.upload-field {
    flex: 1;
    min-width: 200px;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.upload-field label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--color-secondary);
}

.upload-input {
    padding: 0.6rem 0.8rem;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    font-size: 0.95rem;
    font-family: var(--font-sans);
    outline: none;
    transition: border-color 0.2s;
}

.upload-input:focus {
    border-color: var(--color-primary);
}

.upload-btn {
    background: var(--color-primary);
    color: #ffffff;
    border: none;
    padding: 0.7rem 1.5rem;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    align-self: flex-start;
    transition: background 0.2s;
}

.upload-btn:hover {
    background: var(--color-primary-dark, #5a0010);
}

/* ── Animaciones ────────────────────────────────── */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.gallery-card {
    animation: fadeIn 0.5s ease backwards;
}

/* ── Lightbox Overlay Estilo Aranduka ───────────── */
.lightbox-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 15, 25, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 3000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.lightbox-overlay.active {
    opacity: 1;
    pointer-events: auto;
}

.lightbox-inner {
    position: relative;
    max-width: 90%;
    max-height: 90%;
    display: flex;
    flex-direction: column;
    align-items: center;
    transform: scale(0.95);
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}

.lightbox-overlay.active .lightbox-inner {
    transform: scale(1);
}

.lightbox-img {
    max-width: 100%;
    max-height: 75vh;
    border-radius: 8px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    object-fit: contain;
}

/* Overlays en el Lightbox */
.lightbox-overlay-baner, .lightbox-overlay-escudo {
    position: absolute;
    top: 20px;
    z-index: 3005;
    pointer-events: none;
    width: auto !important;
}
.lightbox-overlay-baner {
    left: 20px;
    height: 110px !important;
}
.lightbox-overlay-escudo {
    right: 20px;
    height: 140px !important;
}

.lightbox-caption {
    margin-top: 1.5rem;
    text-align: center;
    color: #ffffff;
    width: 100%;
}

.lightbox-caption h4 {
    font-size: 1.4rem;
    margin-bottom: 0.5rem;
    color: #ffffff;
}

.lightbox-caption p {
    font-size: 0.875rem;
    color: #a0aec0;
    max-width: 580px;
    margin: 0 auto;
}

.lightbox-close-btn {
    position: fixed;
    top: 1.25rem;
    right: 1.5rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.2);
    color: #ffffff;
    font-size: 1.6rem;
    line-height: 1;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease, transform 0.2s ease;
    z-index: 3001;
}

.lightbox-close-btn:hover {
    background: rgba(115,0,20,0.7);
    transform: scale(1.08);
}

/* Counter badge */
.lightbox-counter {
    font-size: 0.78rem;
    color: #718096;
    letter-spacing: 1px;
    margin-top: 0.5rem !important;
}

</style>

<main class="main-content">

    <!-- Encabezado -->
    <div class="section-header">
        <h1 class="section-title" id="gallery-main-title">Galería de Evidencias</h1>
        <p class="section-description">Registro visual e interactivo de las actividades del Bachillerato Técnico en Informática.</p>
    </div>

    <!-- Mensajes de subida -->
    <?php if ($mensajeExito): ?>
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <?php echo $mensajeExito; ?>
        </div>
    <?php endif; ?>
    <?php if ($mensajeError): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <?php echo $mensajeError; ?>
        </div>
    <?php endif; ?>

    <!-- Botón para mostrar formulario -->
    <div style="text-align: right; margin-bottom: 1rem;">
        <button id="toggleUploadBtn" class="upload-btn">+ Añadir Imagen</button>
    </div>

    <!-- Formulario para cargar nuevas fotos -->
    <div class="upload-wrapper" id="uploadFormContainer" style="display: none;">
        <h3 class="upload-title">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
            Publicar Nueva Imagen
        </h3>
        <form class="upload-form" action="galeria.php" method="POST" enctype="multipart/form-data">
            <div class="upload-row">
                <div class="upload-field">
                    <label for="titulo">Título de la imagen</label>
                    <input type="text" id="titulo" name="titulo" class="upload-input" placeholder="Ej: Presentación Final" required>
                </div>
                <div class="upload-field">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" class="upload-input" required>
                        <option value="clases">Clases</option>
                        <option value="defensas">Defensa</option>
                    </select>
                </div>
            </div>
            <div class="upload-field" style="width: 100%;">
                <label for="descripcion">Descripción (opcional)</label>
                <input type="text" id="descripcion" name="descripcion" class="upload-input" placeholder="Breve descripción de la actividad">
            </div>
            <div class="upload-field">
                <label for="imagen">Archivo de imagen</label>
                <input type="file" id="imagen" name="imagen" class="upload-input" accept="image/*" required style="padding: 0.4rem;">
            </div>
            <button type="submit" class="upload-btn">Subir Imagen</button>
        </form>
    </div>

    <!-- Filtros Multi-faceta Premium -->
    <div class="filter-wrapper" id="gallery-filters-container">
        <div class="filter-group" id="filter-categoria">
            <span class="filter-label">CATEGORÍA:</span>
            <button class="filter-btn active" data-filter="todos">Todos</button>
            <button class="filter-btn" data-filter="clases">Clases</button>
            <button class="filter-btn" data-filter="defensas">Defensa</button>
        </div>
        
        <div class="results-counter" id="gallery-counter" style="font-weight: 600;">
            Mostrando <strong id="gallery-count" style="color: var(--color-primary);"><?php echo count($galeriaItems); ?></strong> registros
        </div>
    </div>

    <!-- Grid de fotos -->
    <div class="gallery-grid" id="gallery-grid">
        <?php foreach ($galeriaItems as $i => $item): ?>
            <article
                class="gallery-card"
                data-cat="<?php echo htmlspecialchars($item['categoria'] ?? 'clases'); ?>"
                id="gallery-item-<?php echo htmlspecialchars($item['id'] ?? $i); ?>"
                data-index="<?php echo $i; ?>"
            >
                <div class="gallery-img-wrap">
                    <img src="assets/img/baner.jpeg" class="overlay-baner" alt="Banner">
                    <img src="assets/img/descarga (1).png" class="overlay-escudo" alt="Escudo">
                    <img
                        src="<?php echo htmlspecialchars($item['imagen']); ?>"
                        alt="<?php echo htmlspecialchars($item['titulo'] ?? ''); ?>"
                        loading="lazy"
                    >
                    <button
                        class="gallery-zoom-btn zoom-trigger"
                        data-img="<?php echo htmlspecialchars($item['imagen']); ?>"
                        data-title="<?php echo htmlspecialchars($item['titulo'] ?? ''); ?>"
                        data-desc="<?php echo htmlspecialchars($item['descripcion'] ?? ''); ?>"
                        data-index="<?php echo $i; ?>"
                        aria-label="Ampliar imagen"
                    >
                        <span class="gallery-zoom-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="gallery-card-body">
                    <div class="gallery-meta">
                        <span class="gallery-cat-badge"><?php echo htmlspecialchars($item['categoriaLabel'] ?? 'Clases'); ?></span>
                        <span class="gallery-date" style="margin-left: auto;">
                            <?php 
                                // Formatear fecha si está disponible
                                if(isset($item['fecha'])) {
                                    echo htmlspecialchars($item['fecha']);
                                }
                            ?>
                        </span>
                    </div>
                    <h3 class="gallery-card-title"><?php echo htmlspecialchars($item['titulo'] ?? ''); ?></h3>
                    <p class="gallery-card-desc"><?php echo htmlspecialchars($item['descripcion'] ?? ''); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</main>

<!-- Lightbox Modal -->
<div class="lightbox-overlay" id="lightboxOverlay" role="dialog" aria-modal="true" aria-label="Vista ampliada">
    <button class="lightbox-close-btn" id="lightboxClose" aria-label="Cerrar">&#x2715;</button>
    <div class="lightbox-inner" style="position: relative; display: inline-block;">
        <img src="assets/img/baner.jpeg" class="lightbox-overlay-baner" alt="Banner">
        <img src="assets/img/descarga (1).png" class="lightbox-overlay-escudo" alt="Escudo">
        <img class="lightbox-img" id="lightboxImg" src="" alt="Vista ampliada">
        <div class="lightbox-caption">
            <h4 id="lightboxTitle"></h4>
            <p id="lightboxDesc"></p>
            <p class="lightbox-counter" id="lightboxCounter"></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Filtros Combinados ────────────────────── */
    const filterCatBtns   = document.querySelectorAll('#filter-categoria .filter-btn');
    const cards           = document.querySelectorAll('#gallery-grid .gallery-card');
    const countEl         = document.getElementById('gallery-count');

    // Toggle Upload Form
    const toggleUploadBtn = document.getElementById('toggleUploadBtn');
    const uploadFormContainer = document.getElementById('uploadFormContainer');
    if (toggleUploadBtn && uploadFormContainer) {
        toggleUploadBtn.addEventListener('click', () => {
            if (uploadFormContainer.style.display === 'none') {
                uploadFormContainer.style.display = 'block';
                toggleUploadBtn.textContent = 'Ocultar Formulario';
            } else {
                uploadFormContainer.style.display = 'none';
                toggleUploadBtn.textContent = '+ Añadir Imagen';
            }
        });
    }

    let activeCat         = 'todos';

    function applyFilters() {
        let n = 0;
        cards.forEach(card => {
            const cat = card.getAttribute('data-cat');
            const matchCat = activeCat === 'todos' || cat === activeCat;

            const show = matchCat;
            card.classList.toggle('hidden', !show);
            if (show) n++;
        });
        countEl.textContent = n;
    }

    /* Eventos para botones de categoría */
    filterCatBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterCatBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCat = btn.getAttribute('data-filter');
            applyFilters();
        });
    });

    /* ── Lightbox Logic ────────────────────────────── */
    const lightbox        = document.getElementById('lightboxOverlay');
    const lightboxImg     = document.getElementById('lightboxImg');
    const lightboxTitle   = document.getElementById('lightboxTitle');
    const lightboxDesc    = document.getElementById('lightboxDesc');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const btnClose        = document.getElementById('lightboxClose');
    const zoomTriggers    = document.querySelectorAll('.zoom-trigger');

    let currentItemIndex = 0;
    // Solo navegamos por los visibles
    let visibleItems = [];

    function openLightbox(indexAttr) {
        // Encontrar los elementos visibles en el orden actual
        visibleItems = Array.from(cards).filter(c => !c.classList.contains('hidden'));
        
        // Buscar cuál es el índice real dentro de los visibles basado en el data-index original
        const clickedCard = document.querySelector(`.gallery-card[data-index="${indexAttr}"]`);
        currentItemIndex = visibleItems.indexOf(clickedCard);
        
        if(currentItemIndex === -1) currentItemIndex = 0; // fallback

        updateLightboxContent();
        
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(() => { lightboxImg.src = ""; }, 300); // clear
    }

    function updateLightboxContent() {
        if(visibleItems.length === 0) return;
        const currentCard = visibleItems[currentItemIndex];
        const btn = currentCard.querySelector('.zoom-trigger');
        
        lightboxImg.src           = btn.getAttribute('data-img');
        lightboxTitle.textContent = btn.getAttribute('data-title');
        lightboxDesc.textContent  = btn.getAttribute('data-desc');
        lightboxCounter.textContent = `Imagen ${currentItemIndex + 1} de ${visibleItems.length}`;
    }

    function prevImage() {
        if(visibleItems.length <= 1) return;
        currentItemIndex = (currentItemIndex === 0) ? visibleItems.length - 1 : currentItemIndex - 1;
        updateLightboxContent();
    }

    function nextImage() {
        if(visibleItems.length <= 1) return;
        currentItemIndex = (currentItemIndex === visibleItems.length - 1) ? 0 : currentItemIndex + 1;
        updateLightboxContent();
    }

    // Eventos Click en Fotos
    zoomTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            openLightbox(trigger.getAttribute('data-index'));
        });
    });

    // Cerrar
    btnClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Navegación por teclado (Flechas y ESC)
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    });


});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
