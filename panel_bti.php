<?php
session_start();
if (!isset($_SESSION["bti_admin"]) || $_SESSION["bti_admin"] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php';

// Procesar POSTs para Testimonios y Galería (Patrón PRG)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_experiencia_id'])) {
        $id = (int)$_POST['eliminar_experiencia_id'];
        if (db_delete_experiencia($id)) {
            $_SESSION['flash_msg'] = "Testimonio eliminado correctamente.";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_msg'] = "Error al eliminar testimonio.";
            $_SESSION['flash_type'] = "error";
        }
        header("Location: panel_bti.php");
        exit;
    }
    
    if (isset($_POST['eliminar_galeria_id'])) {
        $id = (int)$_POST['eliminar_galeria_id'];
        if (db_delete_galeria($id)) {
            $_SESSION['flash_msg'] = "Imagen eliminada correctamente.";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_msg'] = "Error al eliminar imagen.";
            $_SESSION['flash_type'] = "error";
        }
        header("Location: panel_bti.php");
        exit;
    }

    if (isset($_POST['importar_lista'])) {
        $grado = trim($_POST['grado']);
        $seccion = trim($_POST['seccion']);
        $lista = trim($_POST['lista_alumnos']);
        
        if (!empty($grado) && !empty($seccion) && !empty($lista)) {
            $alumnos = explode("\n", $lista);
            $agregados = 0;
            foreach ($alumnos as $nombre) {
                $nombre = trim($nombre);
                if (!empty($nombre)) {
                    $nombreFormateado = mb_convert_case(strtolower($nombre), MB_CASE_TITLE, "UTF-8");
                    if (db_add_estudiante($nombreFormateado, $grado, $seccion)) {
                        $agregados++;
                    }
                }
            }
            $_SESSION['flash_msg'] = "Se agregaron $agregados alumnos a $grado Grado, Sección $seccion correctamente.";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_msg'] = "Todos los campos son obligatorios para importar alumnos.";
            $_SESSION['flash_type'] = "error";
        }
        header("Location: panel_bti.php");
        exit;
    }

    if (isset($_POST['subir_imagen']) && isset($_FILES['imagen'])) {
        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = $_POST['categoria'] ?? 'clases';
        $descripcion = trim($_POST['descripcion'] ?? '');
        $grado = $_POST['grado'] ?? null;
        $seccion = $_POST['seccion'] ?? null;
        $fecha = date('Y-m-d');
        
        // Validaciones básicas
        if (empty($titulo) || empty($grado) || empty($seccion)) {
            $_SESSION['flash_msg'] = "Por favor, completa todos los campos requeridos (Título, Grado y Sección).";
            $_SESSION['flash_type'] = "error";
        } elseif ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_msg'] = "Ocurrió un error al subir la imagen.";
            $_SESSION['flash_type'] = "error";
        } else {
            $tmpName = $_FILES['imagen']['tmp_name'];
            $fileName = basename($_FILES['imagen']['name']);
            
            $uniqueName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '', $fileName);
            
            $uploadDir = __DIR__ . '/assets/img/galeria/';
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }
            $destPath = $uploadDir . $uniqueName;
            
            if (move_uploaded_file($tmpName, $destPath)) {
                $rutaRelativa = 'assets/img/galeria/' . $uniqueName;
                
                if (db_add_galeria($titulo, $descripcion, $rutaRelativa, $categoria, $fecha, $grado, $seccion)) {
                    $_SESSION['flash_msg'] = "¡Imagen subida y publicada correctamente en la galería!";
                    $_SESSION['flash_type'] = "success";
                } else {
                    $_SESSION['flash_msg'] = "La imagen se subió, pero no pudo guardarse en la base de datos.";
                    $_SESSION['flash_type'] = "error";
                }
            } else {
                $_SESSION['flash_msg'] = "No se pudo mover el archivo subido al directorio de destino.";
                $_SESSION['flash_type'] = "error";
            }
        }
        header("Location: panel_bti.php");
        exit;
    }
}

// Extraer mensajes flash
$flash_msg = '';
$flash_type = '';
if (isset($_SESSION['flash_msg'])) {
    $flash_msg = $_SESSION['flash_msg'];
    $flash_type = $_SESSION['flash_type'];
    unset($_SESSION['flash_msg']);
    unset($_SESSION['flash_type']);
}

$pageTitle = "Panel BTI";
require_once __DIR__ . "/includes/header.php";
?>
<main class="main-content">
    <div class="section-header">
        <h1 class="section-title">Panel de Administración BTI</h1>
        <p class="section-description">Bienvenido al panel. Desde aquí puedes gestionar alumnos, asistencias y observar su progreso.</p>
    </div>

    <?php if ($flash_msg): ?>
        <?php 
        $bg = $flash_type === 'error' ? '#f8d7da' : '#e6f6ec';
        $color = $flash_type === 'error' ? '#721c24' : '#17bb52';
        $border = $flash_type === 'error' ? '#e53e3e' : '#17bb52';
        ?>
        <div style="background-color: <?php echo $bg; ?>; border: 1px solid <?php echo $border; ?>; color: <?php echo $color; ?>; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;" id="panel-flash-msg">
            <?php echo $flash_type === 'error' ? '❌' : '✓'; ?> <?php echo htmlspecialchars($flash_msg); ?>
        </div>
        <script>
            setTimeout(() => {
                const banner = document.getElementById('panel-flash-msg');
                if (banner) banner.style.display = 'none';
            }, 4000);
        </script>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 2rem;">
        
        <a href="asistencia.php" style="text-decoration: none; color: inherit;">
            <div style="background-color: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 20px var(--color-shadow); text-align: center; transition: transform 0.3s;">
                <h3 style="color: var(--color-primary); margin-bottom: 0.5rem;">Control de Asistencia</h3>
                <p style="color: var(--color-secondary); font-size: 0.9rem;">Registrar y consultar asistencias diarias de alumnos y docentes.</p>
            </div>
        </a>


        <a href="logout.php" style="text-decoration: none; color: inherit;">
            <div style="background-color: #fce8e6; border: 1px solid #e53e3e; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 20px rgba(229, 62, 62, 0.1); text-align: center; transition: transform 0.3s;">
                <h3 style="color: #e53e3e; margin-bottom: 0.5rem;">Cerrar Sesión</h3>
                <p style="color: #c53030; font-size: 0.9rem;">Terminar sesión administrativa de forma segura.</p>
            </div>
        </a>

    </div>

    <!-- Importación Masiva de Alumnos -->
    <div style="margin-top: 4rem; background-color: #f7fafc; padding: 2rem; border-radius: 12px; border: 1px solid var(--color-border); box-shadow: 0 4px 15px var(--color-shadow);">
        <h2 style="color: var(--color-primary); margin-bottom: 1rem; border-bottom: 2px solid var(--color-border); padding-bottom: 0.5rem;">Carga Masiva de Alumnos</h2>
        <p style="color: var(--color-text); margin-bottom: 1.5rem;">Pega la lista de alumnos (uno por línea) para agregarlos a un grado y sección específicos. Es mucho más rápido que subirlos uno a uno.</p>
        
        <form method="POST" style="display: grid; gap: 1.5rem; max-width: 600px;">
            <input type="hidden" name="importar_lista" value="1">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Grado (ej. 5to, 6to)</label>
                    <input type="text" name="grado" required placeholder="Ej: 5to" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Sección (ej. A, B)</label>
                    <input type="text" name="seccion" required placeholder="Ej: A" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Lista de Alumnos (Pega la lista aquí)</label>
                <textarea name="lista_alumnos" required rows="10" placeholder="García, Juan&#10;López, María&#10;..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: monospace; resize: vertical;"></textarea>
            </div>
            
            <button type="submit" style="background-color: var(--color-primary); color: white; padding: 1rem; border: none; border-radius: 6px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: background-color 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                Importar Lista
            </button>
        </form>
    </div>

    <!-- Subir Imagen a Galería -->
    <div style="margin-top: 4rem; background-color: #f7fafc; padding: 2rem; border-radius: 12px; border: 1px solid var(--color-border); box-shadow: 0 4px 15px var(--color-shadow);">
        <h2 style="color: var(--color-primary); margin-bottom: 1rem; border-bottom: 2px solid var(--color-border); padding-bottom: 0.5rem;">Subir Nueva Imagen a Galería</h2>
        <form method="POST" enctype="multipart/form-data" style="display: grid; gap: 1.5rem; max-width: 600px;">
            <input type="hidden" name="subir_imagen" value="1">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Título de la imagen</label>
                    <input type="text" name="titulo" required placeholder="Ej: Presentación Final" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Categoría</label>
                    <select name="categoria" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
                        <option value="clases">Clases</option>
                        <option value="defensas">Defensa</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Grado</label>
                    <select name="grado" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
                        <option value="" disabled selected>Seleccione Grado</option>
                        <option value="5">5° Grado</option>
                        <option value="6">6° Grado</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Sección</label>
                    <select name="seccion" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
                        <option value="" disabled selected>Seleccione Sección</option>
                        <option value="A">Sección A</option>
                        <option value="B">Sección B</option>
                        <option value="C">Sección C</option>
                        <option value="D">Sección D</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Descripción (opcional)</label>
                <input type="text" name="descripcion" placeholder="Breve descripción" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Archivo de imagen</label>
                <input type="file" name="imagen" accept="image/*" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px; background-color: #ffffff;">
            </div>
            
            <button type="submit" style="background-color: var(--color-primary); color: white; padding: 1rem; border: none; border-radius: 6px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: background-color 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                Subir Imagen
            </button>
        </form>
    </div>

    <!-- Gestión de Testimonios -->
    <div style="margin-top: 4rem;">
        <h2 style="color: var(--color-primary); margin-bottom: 1rem; border-bottom: 2px solid var(--color-border); padding-bottom: 0.5rem;">Gestión de Testimonios (Experiencias)</h2>
        
        <?php
        $experienciasList = db_get_experiencias();
        
        if (empty($experienciasList)) {
            echo "<div style='background-color: #f7fafc; padding: 2rem; text-align: center; border-radius: 8px; border: 1px dashed var(--color-border);'>";
            echo "<p style='color: var(--color-secondary); font-weight: 500;'>No hay testimonios registrados actualmente.</p>";
            echo "</div>";
        } else {
            echo "<div style='display: grid; gap: 1rem;'>";
            foreach ($experienciasList as $exp) {
                echo "<div style='background: #fff; border: 1px solid var(--color-border); border-radius: 8px; padding: 1rem; display: flex; justify-content: space-between; align-items: center;'>";
                echo "<div>";
                echo "<strong style='color: var(--color-primary);'>" . htmlspecialchars($exp['nombre']) . "</strong> <span style='color: var(--color-secondary); font-size: 0.85rem;'>(" . htmlspecialchars($exp['rol']) . ")</span>";
                echo "<p style='margin: 0.5rem 0 0 0; font-size: 0.9rem; color: var(--color-text);'>" . htmlspecialchars(substr($exp['comentario'], 0, 80)) . "...</p>";
                echo "</div>";
                
                echo "<form method='POST' style='margin: 0;' onsubmit=\"return confirm('¿Estás seguro de que quieres eliminar este testimonio?');\">";
                echo "<input type='hidden' name='eliminar_experiencia_id' value='" . $exp['id'] . "'>";
                echo "<button type='submit' style='background: #e53e3e; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-weight: bold;'>Eliminar</button>";
                echo "</form>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <!-- Gestión de Galería -->
    <div style="margin-top: 4rem;">
        <h2 style="color: var(--color-primary); margin-bottom: 1rem; border-bottom: 2px solid var(--color-border); padding-bottom: 0.5rem;">Gestión de Galería</h2>
        
        <?php
        $galeriaList = db_get_galerias();
        
        if (empty($galeriaList)) {
            echo "<div style='background-color: #f7fafc; padding: 2rem; text-align: center; border-radius: 8px; border: 1px dashed var(--color-border);'>";
            echo "<p style='color: var(--color-secondary); font-weight: 500;'>No hay imágenes en la galería actualmente.</p>";
            echo "</div>";
        } else {
            echo "<div style='display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;'>";
            foreach ($galeriaList as $img) {
                echo "<div style='background: #fff; border: 1px solid var(--color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;'>";
                echo "<img src='" . htmlspecialchars($img['imagen']) . "' style='width: 100%; height: 120px; object-fit: cover;'>";
                echo "<div style='padding: 1rem; flex: 1;'>";
                echo "<strong style='color: var(--color-primary); font-size: 0.9rem;'>" . htmlspecialchars($img['titulo']) . "</strong>";
                echo "</div>";
                echo "<form method='POST' style='margin: 0; padding: 0 1rem 1rem 1rem;' onsubmit=\"return confirm('¿Estás seguro de que quieres eliminar esta imagen?');\">";
                echo "<input type='hidden' name='eliminar_galeria_id' value='" . $img['id'] . "'>";
                echo "<button type='submit' style='background: #e53e3e; color: white; border: none; padding: 0.5rem; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 0.8rem;'>Eliminar</button>";
                echo "</form>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</main>
<style>
    /* Efecto hover suave para tarjetas */
    main.main-content a > div:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px var(--color-shadow);
        border-color: var(--color-primary);
    }
</style>
<?php
require_once __DIR__ . "/includes/footer.php";
?>
