<?php
require_once __DIR__ . '/includes/db.php';
global $pdo, $db_mode;

echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";

if ($db_mode === 'mysql' && $pdo) {
    try {
        // Encontrar el ID del Grado 90
        $stmt_get_grado = $pdo->prepare("SELECT id FROM grados WHERE nombre LIKE '%90%'");
        $stmt_get_grado->execute();
        $grado_id = $stmt_get_grado->fetchColumn();

        $alumnos_eliminados = 0;

        if ($grado_id) {
            // Eliminar alumnos vinculados a ese grado o que estén en la sección T
            $stmt1 = $pdo->prepare("DELETE FROM estudiantes WHERE grado_id = ? OR seccion = 'T' OR seccion = 't'");
            $stmt1->execute([$grado_id]);
            $alumnos_eliminados = $stmt1->rowCount();
            
            // Eliminar el grado 90 de la tabla de grados
            $stmt2 = $pdo->prepare("DELETE FROM grados WHERE id = ?");
            $stmt2->execute([$grado_id]);
        } else {
            // Si el grado no existe, igual eliminar alumnos en sección T
            $stmt1 = $pdo->prepare("DELETE FROM estudiantes WHERE seccion = 'T' OR seccion = 't'");
            $stmt1->execute();
            $alumnos_eliminados = $stmt1->rowCount();
        }

        echo "<h1 style='color: #17bb52;'>¡Datos de prueba eliminados!</h1>";
        echo "<p>Se eliminaron <strong>$alumnos_eliminados</strong> alumnos de prueba.</p>";
        echo "<p>El Grado 90 y la Sección T ya no aparecerán en el sistema.</p>";

    } catch (Exception $e) {
        echo "<h1 style='color: #e53e3e;'>Error al limpiar la base de datos</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
} else {
    // Modo JSON
    $data = getJsonData();
    $estudiantes = $data['estudiantes'];
    $inicial = count($estudiantes);
    
    // Filtrar los que NO sean de seccion T ni grado 90
    $estudiantes_filtrados = array_filter($estudiantes, function($est) {
        $seccion = strtolower($est['seccion'] ?? '');
        $grado = strtolower($est['grado'] ?? '');
        
        if ($seccion === 't' || strpos($grado, '90') !== false) {
            return false; // Eliminar
        }
        return true; // Conservar
    });
    
    $eliminados = $inicial - count($estudiantes_filtrados);
    
    if ($eliminados > 0) {
        $data['estudiantes'] = array_values($estudiantes_filtrados); // Reindexar
        
        // Guardar el JSON
        $path = getJsonPath();
        if (is_writable($path) || is_writable(dirname($path))) {
            file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo "<h1 style='color: #17bb52;'>¡Datos de prueba eliminados!</h1>";
            echo "<p>Se eliminaron <strong>$eliminados</strong> alumnos de prueba (Modo Archivo Interno).</p>";
            echo "<p>El Grado 90 y la Sección T ya no aparecerán en el sistema.</p>";
        } else {
            echo "<h1 style='color: #e53e3e;'>Error de Permisos</h1>";
            echo "<p>No se puede modificar el archivo interno de alumnos. Verifica los permisos de la carpeta data.</p>";
        }
    } else {
        echo "<h1 style='color: #17bb52;'>Todo limpio</h1>";
        echo "<p>Ya no se encontraron alumnos en el Grado 90 o Sección T, todo está en orden.</p>";
    }
}

echo "<a href='panel_bti.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #730014; color: white; text-decoration: none; border-radius: 5px;'>Volver al Panel</a>";
echo "</div>";
?>
