<?php
require_once __DIR__ . '/includes/db.php';

// MySQL Cleanup
if ($db_mode === 'mysql') {
    try {
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("TRUNCATE TABLE asistencias;");
        $pdo->exec("TRUNCATE TABLE seguimiento;");
        $pdo->exec("TRUNCATE TABLE estudiantes;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        echo "MySQL tables truncated.\n";
    } catch (Exception $e) {
        echo "MySQL error: " . $e->getMessage() . "\n";
    }
}

// JSON Cleanup
$dir = __DIR__ . '/data';
if (file_exists($dir . '/asistencia_db.json')) {
    unlink($dir . '/asistencia_db.json');
    echo "JSON file deleted.\n";
}

if (isset($_SESSION['asistencia_db'])) {
    unset($_SESSION['asistencia_db']);
}

echo "Cleanup complete.\n";
