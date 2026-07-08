<?php
session_start();
if (!isset($_SESSION["bti_admin"]) || $_SESSION["bti_admin"] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/includes/db.php";

$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
    if ($_POST["action"] === "guardar_seguimiento") {
        $estudiante_id = $_POST["estudiante_id"];
        $fecha = $_POST["fecha"];
        $observacion = trim($_POST["observacion"]);
        $progreso = $_POST["progreso"];
        
        if ($estudiante_id && $fecha && $observacion && $progreso) {
            db_add_seguimiento($estudiante_id, $fecha, $observacion, $progreso);
            $successMsg = "Observaci�n guardada correctamente.";
        }
    }
}

$estudiantes = db_get_estudiantes();
$seguimientos = db_get_seguimientos();

$pageTitle = "Observaciones y Progreso";
require_once __DIR__ . "/includes/header.php";
?>
<main class="main-content">
    
    <div class="section-header" style="position: relative;">
        <a href="panel_bti.php" class="btn btn-secondary" style="position: absolute; left: 0; top: 0; padding: 0.5rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; width: auto; background-color: #f1f5f9; color: var(--color-secondary); border-color: #e2e8f0;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Volver al Panel
        </a>
        <h1 class="section-title" style="padding-top: 2rem;">Observaciones y Progreso</h1>
        <p class="section-description">Registra observaciones acad�micas y actualiza el nivel de progreso de los alumnos.</p>
    </div>

    <?php if (!empty($successMsg)): ?>
        <div style="background-color: #e6f6ec; border: 1px solid #17bb52; color: #17bb52; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;" id="success-banner">
            ? <?php echo htmlspecialchars($successMsg); ?>
        </div>
        <script>
            setTimeout(() => {
                const banner = document.getElementById("success-banner");
                if (banner) banner.style.display = "none";
            }, 4000);
        </script>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        
        <!-- Formulario -->
        <section style="background-color: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 20px var(--color-shadow); align-self: start;">
            <h2 style="color: var(--color-primary); font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">A�adir Registro</h2>
            <form action="panel_observaciones.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                <input type="hidden" name="action" value="guardar_seguimiento">
                
                <div>
                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-secondary); margin-bottom: 0.5rem; display: block;">Alumno:</label>
                    <select name="estudiante_id" required style="width: 100%; padding: 0.65rem; border: 1px solid var(--color-border); border-radius: 6px; outline: none; background: #fff;">
                        <option value="">Seleccione un alumno...</option>
                        <?php foreach($estudiantes as $est): ?>
                            <option value="<?php echo $est["id"]; ?>"><?php echo htmlspecialchars($est["nombre"] . " (" . $est["grado"] . ")"); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-secondary); margin-bottom: 0.5rem; display: block;">Fecha:</label>
                    <input type="date" name="fecha" required value="<?php echo date("Y-m-d"); ?>" style="width: 100%; padding: 0.65rem; border: 1px solid var(--color-border); border-radius: 6px; outline: none;">
                </div>

                <div>
                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-secondary); margin-bottom: 0.5rem; display: block;">Nivel de Progreso:</label>
                    <select name="progreso" required style="width: 100%; padding: 0.65rem; border: 1px solid var(--color-border); border-radius: 6px; outline: none; background: #fff;">
                        <option value="Inicial">Inicial</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Logrado">Logrado</option>
                        <option value="Avanzado">Avanzado</option>
                    </select>
                </div>

                <div>
                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-secondary); margin-bottom: 0.5rem; display: block;">Observaci�n / Comentario:</label>
                    <textarea name="observacion" rows="4" required style="width: 100%; padding: 0.65rem; border: 1px solid var(--color-border); border-radius: 6px; outline: none; resize: vertical;" placeholder="Ingrese las observaciones aqu�..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem; width: 100%; justify-content: center;">Guardar Registro</button>
            </form>
        </section>

        <!-- Historial -->
        <section style="background-color: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 20px var(--color-shadow);">
            <h2 style="color: var(--color-primary); font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Historial de Seguimiento</h2>
            
            <div style="overflow-x: auto; max-height: 600px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--color-border); color: var(--color-secondary); font-size: 0.85rem; text-transform: uppercase;">Fecha</th>
                            <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--color-border); color: var(--color-secondary); font-size: 0.85rem; text-transform: uppercase;">Alumno</th>
                            <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--color-border); color: var(--color-secondary); font-size: 0.85rem; text-transform: uppercase;">Progreso</th>
                            <th style="text-align: left; padding: 0.75rem; border-bottom: 2px solid var(--color-border); color: var(--color-secondary); font-size: 0.85rem; text-transform: uppercase;">Observaci�n</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($seguimientos)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--color-secondary);">No hay registros a�n.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($seguimientos as $seg): 
                                $badgeColor = "#e2e8f0"; $textColor = "#4a5568";
                                switch($seg["progreso"]) {
                                    case "Inicial": $badgeColor = "#fce8e6"; $textColor = "#e53e3e"; break;
                                    case "En Proceso": $badgeColor = "#fffaf0"; $textColor = "#dd6b20"; break;
                                    case "Logrado": $badgeColor = "#e6f6ec"; $textColor = "#17bb52"; break;
                                    case "Avanzado": $badgeColor = "#ebf8ff"; $textColor = "#3182ce"; break;
                                }
                            ?>
                            <tr style="border-bottom: 1px solid var(--color-border);">
                                <td style="padding: 0.75rem; font-size: 0.9rem;"><strong><?php echo date("d/m/Y", strtotime($seg["fecha"])); ?></strong></td>
                                <td style="padding: 0.75rem; font-size: 0.9rem;"><?php echo htmlspecialchars($seg["nombre"]); ?></td>
                                <td style="padding: 0.75rem;">
                                    <span style="background-color: <?php echo $badgeColor; ?>; color: <?php echo $textColor; ?>; padding: 0.25rem 0.6rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">
                                        <?php echo htmlspecialchars($seg["progreso"]); ?>
                                    </span>
                                </td>
                                <td style="padding: 0.75rem; font-size: 0.9rem; color: #4a5568; max-width: 300px; word-wrap: break-word;">
                                    <?php echo nl2br(htmlspecialchars($seg["observacion"])); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>
<style>
@media (max-width: 992px) {
    div[style*="grid-template-columns: 1fr 2fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
<?php
require_once __DIR__ . "/includes/footer.php";
?>
