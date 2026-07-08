<?php
/**
 * Página: Experiencias de los Alumnos
 * Proyecto Integrador - 3° BTI CRECE
 */
require_once __DIR__ . '/includes/db.php';

$mensajeExito = '';
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'nueva_experiencia') {
    $nombre = trim($_POST['nombre'] ?? '');
    $rol = trim($_POST['rol'] ?? 'Visitante');
    $comentario = trim($_POST['comentario'] ?? '');
    
    if (empty($nombre) || empty($comentario)) {
        $mensajeError = "Por favor, completa tu nombre y el comentario.";
    } else {
        if (db_add_experiencia($nombre, $rol, $comentario)) {
            $mensajeExito = "¡Testimonio publicado correctamente!";
        } else {
            $mensajeError = "Ocurrió un error al guardar el testimonio.";
        }
    }
}

$pageTitle = "Experiencias BTI";
require_once __DIR__ . '/includes/header.php';

$experienciasList = db_get_experiencias();
?>

<!-- Hojas de estilos de FontAwesome para Iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos para el layout de Experiencias */
    .experiencias-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 3rem;
        align-items: start;
        margin-top: 2rem;
        margin-bottom: 4rem;
    }

    @media (max-width: 992px) {
        .experiencias-grid {
            grid-template-columns: 1fr;
            gap: 2.5rem;
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

    /* Tarjetas de Experiencia de Alumnos */
    .experience-card {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px var(--color-shadow);
        transition: var(--transition-smooth);
        position: relative;
    }

    .experience-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border-color: rgba(115, 0, 20, 0.15);
    }

    .experience-author {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .experience-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 2px 8px rgba(115, 0, 20, 0.1);
    }

    .experience-meta {
        display: flex;
        flex-direction: column;
    }

    .experience-name {
        font-weight: 700;
        color: var(--color-primary);
        font-size: 1.05rem;
    }

    .experience-role {
        font-size: 0.85rem;
        color: var(--color-secondary);
        font-weight: 500;
    }

    .experience-quote {
        font-style: italic;
        color: var(--color-text);
        font-size: 1rem;
        line-height: 1.65;
        margin-bottom: 1.25rem;
        position: relative;
    }

    /* Estructura de Aprendizajes y Dificultades */
    .learning-box {
        background-color: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: 12px;
        padding: 2.5rem 2rem;
        box-shadow: 0 4px 20px var(--color-shadow);
    }

    .learning-box h3 {
        font-size: 1.35rem;
        color: var(--color-primary);
        margin-bottom: 1.5rem;
        font-weight: 700;
        border-bottom: 1px solid var(--color-border);
        padding-bottom: 0.75rem;
    }

    .learning-list {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    .learning-item {
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }

    .learning-icon {
        width: 44px;
        height: 44px;
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
        transition: var(--transition-fast);
        box-shadow: 0 2px 6px rgba(115, 0, 20, 0.05);
    }

    .learning-item:hover .learning-icon {
        background-color: var(--color-primary);
        color: #ffffff;
        transform: scale(1.05);
    }

    .learning-icon.difficulty {
        background-color: #fff0f0;
        color: var(--color-accent-red);
    }

    .learning-item:hover .learning-icon.difficulty {
        background-color: var(--color-accent-red);
        color: #ffffff;
    }

    .learning-info h4 {
        font-size: 1.05rem;
        color: var(--color-text);
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .learning-info p {
        font-size: 0.92rem;
        color: var(--color-secondary);
        line-height: 1.55;
    }
</style>

<!-- Contenido Principal -->
<main class="main-content">
    


    <div class="experiencias-grid">
        
        <!-- COLUMNA IZQUIERDA: Testimonios -->
        <div>
            <div class="section-header-custom">
                <h2>Testimonios y Reflexiones</h2>
                <p>Nuestra vivencia personal al capacitar a niños de la institución</p>
            </div>

            <!-- Botón para mostrar formulario -->
            <?php $showForm = ($mensajeExito || $mensajeError); ?>
            <button id="toggleFormBtn" type="button" 
                    onclick="document.getElementById('experiencia-form-container').style.display='block'; this.style.display='none';" 
                    style="background: var(--color-primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-bottom: 1.5rem; display: <?php echo $showForm ? 'none' : 'block'; ?>;">
                <i class="fa-solid fa-plus" style="margin-right: 5px;"></i> Añadir Nuevo Testimonio
            </button>

            <!-- Formulario para agregar testimonio -->
            <div id="experiencia-form-container" class="experience-card" style="background: #fcfcfc; border-style: dashed; padding: 1.5rem; display: <?php echo $showForm ? 'block' : 'none'; ?>;">
                <h3 style="margin-bottom: 1rem; color: var(--color-primary); font-size: 1.15rem;">Añadir tu testimonio</h3>
                <?php if ($mensajeExito): ?>
                    <div style="background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;"><?php echo $mensajeExito; ?></div>
                <?php endif; ?>
                <?php if ($mensajeError): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;"><?php echo $mensajeError; ?></div>
                <?php endif; ?>
                <form method="POST" action="experiencias.php">
                    <input type="hidden" name="accion" value="nueva_experiencia">
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-size: 0.85rem; color: var(--color-secondary); margin-bottom: 0.3rem;">Nombre</label>
                            <input type="text" name="nombre" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 8px; font-family: var(--font-sans);">
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-size: 0.85rem; color: var(--color-secondary); margin-bottom: 0.3rem;">Rol</label>
                            <input type="text" name="rol" placeholder="Ej. Alumno, Docente, Padre" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 8px; font-family: var(--font-sans);">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; color: var(--color-secondary); margin-bottom: 0.3rem;">Tu experiencia o comentario</label>
                        <textarea name="comentario" rows="3" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 8px; resize: vertical; font-family: var(--font-sans);"></textarea>
                    </div>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <button type="submit" style="background: var(--color-primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">Publicar Testimonio</button>
                        <button type="button" onclick="document.getElementById('experiencia-form-container').style.display='none'; document.getElementById('toggleFormBtn').style.display='block';" style="background: transparent; color: var(--color-text); border: 1px solid var(--color-border); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">Cerrar</button>
                    </div>
                </form>
            </div>

            <!-- Listado dinámico de testimonios -->
            <?php foreach ($experienciasList as $exp): 
                $initials = strtoupper(substr($exp['nombre'], 0, 2));
                $parts = explode(' ', trim($exp['nombre']));
                if (count($parts) >= 2) {
                    $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                }
            ?>
            <div class="experience-card">
                <div class="experience-author">
                    <div class="experience-avatar"><?php echo $initials; ?></div>
                    <div class="experience-meta">
                        <span class="experience-name"><?php echo htmlspecialchars($exp['nombre']); ?></span>
                        <span class="experience-role"><?php echo htmlspecialchars($exp['rol']); ?></span>
                    </div>
                </div>
                <p class="experience-quote">
                    "<?php echo nl2br(htmlspecialchars($exp['comentario'])); ?>"
                </p>
                <p style="font-size: 0.85rem; color: var(--color-secondary); font-weight: 500;">
                    <i class="fa-solid fa-quote-left" style="color: var(--color-primary); margin-right: 4px;"></i> Reflexión personal
                </p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- COLUMNA DERECHA: Aprendizajes y Dificultades -->
        <div>
            <div class="section-header-custom">
                <h2>Experiencias del Desarrollo</h2>
                <p>Nuestra bitácora del proyecto de Scratch</p>
            </div>

            <!-- Aprendizajes Obtenidos y Dificultades Superadas -->
            <div class="learning-box">
                <h3>Resumen Académico</h3>
                <div class="learning-list">
                    
                    <!-- Item 1: Aprendizaje -->
                    <div class="learning-item">
                        <div class="learning-icon">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>
                        <div class="learning-info">
                            <h4>Enseñanza Lúdica</h4>
                            <p>Desarrollo de metodologías didácticas divertidas para enseñar lógica y algoritmos mediante el diseño de videojuegos en Scratch a alumnos de 5° y 6° grado.</p>
                        </div>
                    </div>

                    <!-- Item 2: Dificultad Superada -->
                    <div class="learning-item">
                        <div class="learning-icon difficulty">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="learning-info">
                            <h4>Desafíos de Infraestructura y Aula</h4>
                            <p>Superación de dificultades técnicas en las computadoras, cortes de conexión a internet y gestión de la atención del grupo estudiantil durante las clases.</p>
                        </div>
                    </div>

                    <!-- Item 3: Aprendizaje -->
                    <div class="learning-item">
                        <div class="learning-icon">
                            <i class="fa-solid fa-people-group"></i>
                        </div>
                        <div class="learning-info">
                            <h4>Trabajo Colaborativo</h4>
                            <p>Planificación conjunta de materiales y soporte mutuo para guiar a los niños de forma organizada en la resolución de bugs en sus proyectos.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
