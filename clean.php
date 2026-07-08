<?php
session_start();
if (!isset($_SESSION["bti_admin"]) || $_SESSION["bti_admin"] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php';
global $pdo, $db_mode;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar'])) {
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $pdo->exec("TRUNCATE TABLE asistencias");
            $msg = "Base de datos MySQL vaciada con éxito.";
        } catch (PDOException $e) {
            $msg = "Error MySQL: " . $e->getMessage();
        }
    } else {
        $path = getJsonPath();
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $data = json_decode($content, true);
            if (isset($data['asistencias'])) {
                $data['asistencias'] = [];
                file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $msg = "Datos JSON vaciados con éxito.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Limpiar Sistema - BTI</title>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); text-align: center; max-width: 400px; }
        .btn-danger { background-color: #e53e3e; color: white; border: none; padding: 1rem 2rem; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 1rem; margin-top: 1rem; transition: background 0.3s; }
        .btn-danger:hover { background-color: #c53030; }
        .msg { background: #e6f6ec; color: #17bb52; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color: #730014; margin-top: 0;">Limpiar Sistema BTI</h2>
        <p style="color: #64748b; margin-bottom: 2rem;">Utiliza este botón para borrar de forma permanente todas las asistencias registradas hasta ahora. Ideal para borrar datos de prueba.</p>
        
        <?php if (isset($msg)) echo "<div class='msg'>✓ $msg</div>"; ?>

        <form method="POST" onsubmit="return confirm('¿ESTÁS 100% SEGURO? Esta acción no se puede deshacer y borrará TODAS las asistencias.');">
            <input type="hidden" name="borrar" value="1">
            <button type="submit" class="btn-danger">🗑️ Borrar Todas las Asistencias</button>
        </form>
        
        <div style="margin-top: 2rem;">
            <a href="panel_bti.php" style="color: #2563eb; text-decoration: none; font-weight: 600;">← Volver al Panel</a>
        </div>
    </div>
</body>
</html>
