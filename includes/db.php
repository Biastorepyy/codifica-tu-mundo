<?php
/**
 * Componente modular: Conexión Híbrida a Base de Datos
 * Proyecto Integrador - 3° BTI CRECE
 * 
 * Este script intenta conectarse a una base de datos MySQL (por defecto en XAMPP).
 * Si no está disponible o no existe, realiza un fallback automático a almacenamiento JSON local.
 */

// Establecer la zona horaria a Paraguay (donde se usa el sistema)
date_default_timezone_set('America/Asuncion');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'crece_bti';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';

$pdo = null;
$db_mode = 'json'; // Modo por defecto en caso de fallo

try {
    // Conexión PDO con un timeout corto para que el fallback sea inmediato si MySQL está apagado
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 2
    ]);
    $db_mode = 'mysql';
} catch (PDOException $e) {
    $pdo = null;
    $db_mode = 'json';
}

// ── AUXILIARES ALMACENAMIENTO JSON ─────────────────────────────────────

function getJsonPath() {
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    $localPath = $dir . '/asistencia_db.json';
    if (!is_writable(dirname($localPath)) && !is_writable($localPath)) {
        return '/tmp/asistencia_db.json';
    }
    return $localPath;
}

function getJsonData() {
    $path = getJsonPath();
    if (file_exists($path)) {
        $content = file_get_contents($path);
        $data = json_decode($content, true);
    }
    
    // Datos iniciales por defecto si no existe el JSON
    $defaultData = [
        "estudiantes" => [
        ],
        "profesores" => [
            ["id" => 1, "nombre" => "Prof. Lic. Carlos Ferreira", "materia" => "Programación Web"],
            ["id" => 2, "nombre" => "Prof. Ing. Andrea Espínola", "materia" => "Bases de Datos"],
            ["id" => 3, "nombre" => "Prof. Lic. Mabel Rojas", "materia" => "Análisis y Diseño"],
            ["id" => 4, "nombre" => "Prof. Ing. Gustavo Galeano", "materia" => "Redes de Computadoras"]
        ],
        "asistencias" => [
        ],
        "galerias" => [
            // SEEDING DATA FOR GALERIA
            [ "id" => 1, "titulo" => "Primera clase", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto1.jpeg", "categoria" => "clases", "categoriaLabel" => "Clases", "fecha" => "2026-07-06" ],
            [ "id" => 2, "titulo" => "Programación inicial", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto2.jpeg", "categoria" => "clases", "categoriaLabel" => "Clases", "fecha" => "2026-07-06" ],
            [ "id" => 3, "titulo" => "Muestra de Scratch", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto3.jpeg", "categoria" => "clases", "categoriaLabel" => "Clases", "fecha" => "2026-07-06" ],
            [ "id" => 4, "titulo" => "Lógica y algoritmos", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto4.jpeg", "categoria" => "clases", "categoriaLabel" => "Clases", "fecha" => "2026-07-06" ],
            [ "id" => 5, "titulo" => "Creando interfaces", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto5.jpeg", "categoria" => "clases", "categoriaLabel" => "Clases", "fecha" => "2026-07-06" ],
            [ "id" => 6, "titulo" => "Testing de juegos", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto6.jpeg", "categoria" => "clases", "categoriaLabel" => "Clases", "fecha" => "2026-07-06" ],
            [ "id" => 7, "titulo" => "Preparación para defensa", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto7.jpeg", "categoria" => "defensas", "categoriaLabel" => "Defensa", "fecha" => "2026-07-06" ],
            [ "id" => 8, "titulo" => "Defensa del proyecto", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto8.jpeg", "categoria" => "defensas", "categoriaLabel" => "Defensa", "fecha" => "2026-07-06" ],
            [ "id" => 9, "titulo" => "Presentación en feria", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto9.jpeg", "categoria" => "defensas", "categoriaLabel" => "Defensa", "fecha" => "2026-07-06" ],
            [ "id" => 10, "titulo" => "Interacción con alumnos", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto10.jpeg", "categoria" => "defensas", "categoriaLabel" => "Defensa", "fecha" => "2026-07-06" ],
            [ "id" => 11, "titulo" => "Evaluación docente", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto11.jpeg", "categoria" => "defensas", "categoriaLabel" => "Defensa", "fecha" => "2026-07-06" ],
            [ "id" => 12, "titulo" => "Cierre y premiación", "descripcion" => "Actividades desarrolladas por los estudiantes del 3° BTI.", "imagen" => "assets/img/galeria/foto12.jpeg", "categoria" => "defensas", "categoriaLabel" => "Defensa", "fecha" => "2026-07-06" ]
        ],
        "experiencias" => [
        ]
    ];
    
    if (isset($data) && $data) {
        if (!isset($data['galerias']) || empty($data['galerias'])) {
            $data['galerias'] = $defaultData['galerias'];
            saveJsonData($data);
        }
        if (!isset($data['experiencias'])) {
            $data['experiencias'] = $defaultData['experiencias'];
            saveJsonData($data);
        }
        return $data;
    }
    
    saveJsonData($defaultData);
    return $defaultData;
}

function saveJsonData($data) {
    $path = getJsonPath();
    @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}


// ── MÉTODOS DE ABSTRACCIÓN DE BASE DE DATOS (CRUD) ──────────────────────

// Obtener Estudiantes
function db_get_estudiantes($filtroGrado = null, $filtroSeccion = null) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $sql = "SELECT e.id, e.nombre, e.seccion, g.nombre as grado FROM estudiantes e JOIN grados g ON e.grado_id = g.id";
            $params = [];
            $whereClauses = [];
            
            if ($filtroGrado) {
                $gradoNombre = (stripos($filtroGrado, 'grado') === false) ? $filtroGrado . ' Grado' : $filtroGrado;
                $whereClauses[] = "g.nombre = ?";
                $params[] = $gradoNombre;
            }
            if ($filtroSeccion) {
                $whereClauses[] = "e.seccion = ?";
                $params[] = $filtroSeccion;
            }
            
            if (!empty($whereClauses)) {
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            $result = $stmt->fetchAll();
            // Limpiar " Grado" del nombre para la UI de forma genérica
            foreach ($result as &$row) {
                $row['grado'] = trim(str_ireplace(' Grado', '', $row['grado']));
            }
            return $result;
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    $data = getJsonData();
    $estudiantes = $data['estudiantes'];
    
    // Filtrar JSON si es necesario
    if ($filtroGrado || $filtroSeccion) {
        $estudiantes = array_filter($estudiantes, function($est) use ($filtroGrado, $filtroSeccion) {
            $match = true;
            if ($filtroGrado && $est['grado'] !== $filtroGrado) $match = false;
            // Manejar compatibilidad hacia atrás si un estudiante antiguo no tiene sección
            $sec = $est['seccion'] ?? 'A';
            if ($filtroSeccion && $sec !== $filtroSeccion) $match = false;
            return $match;
        });
    }
    
    return array_values($estudiantes);
}

// Obtener Profesores
function db_get_profesores() {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->query("SELECT id, nombre, materia FROM profesores");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Fallback
        }
    }
    $data = getJsonData();
    return $data['profesores'];
}

// Obtener Asistencias
function db_get_asistencias() {
    global $pdo, $db_mode;
    
    // Auto-create column in mysql if it doesn't exist just in case
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $pdo->exec("ALTER TABLE asistencias ADD COLUMN trabajo_clase TINYINT(1) DEFAULT 0");
        } catch (PDOException $e) {
            // Already exists or can't add
        }
    }
    
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $sql = "
                SELECT 
                    a.id, 
                    a.tipo, 
                    a.fecha, 
                    a.hora,
                    a.estado,
                    a.trabajo_clase,
                    CASE 
                        WHEN a.tipo = 'alumno' THEN a.estudiante_id 
                        ELSE a.profesor_id 
                    END AS ref_id,
                    CASE 
                        WHEN a.tipo = 'alumno' THEN e.nombre 
                        ELSE p.nombre 
                    END AS nombre,
                    CASE 
                        WHEN a.tipo = 'alumno' THEN REPLACE(g.nombre, ' Grado', '')
                        ELSE NULL 
                    END AS grado,
                    CASE 
                        WHEN a.tipo = 'profesor' THEN p.materia 
                        ELSE NULL 
                    END AS materia,
                    CASE
                        WHEN a.tipo = 'alumno' THEN e.seccion
                        ELSE NULL
                    END AS seccion
                FROM asistencias a
                LEFT JOIN estudiantes e ON a.estudiante_id = e.id
                LEFT JOIN grados g ON e.grado_id = g.id
                LEFT JOIN profesores p ON a.profesor_id = p.id
            ";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Fallback
        }
    }
    $data = getJsonData();
    return $data['asistencias'];
}

// Registrar Alumno
function db_add_estudiante($nombre, $grado, $seccion = 'A') {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            // Obtener ID del grado correspondiente
            $gradoNombre = (stripos($grado, 'grado') === false) ? $grado . ' Grado' : $grado;
            $stmt = $pdo->prepare("SELECT id FROM grados WHERE nombre = ?");
            $stmt->execute([$gradoNombre]);
            $gradoId = $stmt->fetchColumn();
            
            if (!$gradoId) {
                // Si por alguna razón no existe el grado, insertarlo
                $stmt = $pdo->prepare("INSERT INTO grados (nombre) VALUES (?)");
                $stmt->execute([$gradoNombre]);
                $gradoId = $pdo->lastInsertId();
            }

            // Comprobar si existe la columna seccion (por si acaso la migración no corrió)
            $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, grado_id, seccion) VALUES (?, ?, ?)");
            return $stmt->execute([$nombre, $gradoId, $seccion]);
        } catch (PDOException $e) {
            // Fallback (podría fallar si la columna no existe en bd vieja, en ese caso usar fallback json temporalmente)
        }
    }
    $data = getJsonData();
    $newId = count($data['estudiantes']) > 0 ? max(array_column($data['estudiantes'], 'id')) + 1 : 1;
    $data['estudiantes'][] = [
        "id" => $newId,
        "nombre" => $nombre,
        "grado" => $grado,
        "seccion" => $seccion
    ];
    saveJsonData($data);
    return true;
}

// Registrar Profesor
function db_add_profesor($nombre, $materia) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO profesores (nombre, materia) VALUES (?, ?)");
            return $stmt->execute([$nombre, $materia]);
        } catch (PDOException $e) {
            // Fallback
        }
    }
    $data = getJsonData();
    $newId = count($data['profesores']) > 0 ? max(array_column($data['profesores'], 'id')) + 1 : 1;
    $data['profesores'][] = [
        "id" => $newId,
        "nombre" => $nombre,
        "materia" => $materia
    ];
    saveJsonData($data);
    return true;
}

// Guardar Asistencias
function db_save_asistencias($tipo, $fecha, $asistencias, $trabajo = []) {
    global $pdo, $db_mode;
    
    // Auto-create column in mysql if it doesn't exist
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $pdo->exec("ALTER TABLE asistencias ADD COLUMN trabajo_clase TINYINT(1) DEFAULT 0");
        } catch (PDOException $e) { }
    }
    
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $pdo->beginTransaction();
            
            // Eliminar registros existentes para ese tipo y fecha
            if ($tipo === 'alumno') {
                $stmt = $pdo->prepare("DELETE FROM asistencias WHERE tipo = 'alumno' AND fecha = ?");
                $stmt->execute([$fecha]);
                
                // Insertar los nuevos registros
                $hora = date('H:i:s');
                $stmt = $pdo->prepare("INSERT INTO asistencias (tipo, estudiante_id, fecha, hora, estado, trabajo_clase) VALUES ('alumno', ?, ?, ?, ?, ?)");
                foreach ($asistencias as $refId => $estado) {
                    $trabajoVal = isset($trabajo[$refId]) ? 1 : 0;
                    $stmt->execute([(int)$refId, $fecha, $hora, $estado, $trabajoVal]);
                }
            } else {
                $stmt = $pdo->prepare("DELETE FROM asistencias WHERE tipo = 'profesor' AND fecha = ?");
                $stmt->execute([$fecha]);
                
                // Insertar los nuevos registros
                $hora = date('H:i:s');
                $stmt = $pdo->prepare("INSERT INTO asistencias (tipo, profesor_id, fecha, hora, estado, trabajo_clase) VALUES ('profesor', ?, ?, ?, ?, ?)");
                foreach ($asistencias as $refId => $estado) {
                    $trabajoVal = isset($trabajo[$refId]) ? 1 : 0;
                    $stmt->execute([(int)$refId, $fecha, $hora, $estado, $trabajoVal]);
                }
            }
            
            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            // Fallback
        }
    }
    
    // Modo JSON Fallback
    $data = getJsonData();
    
    // Eliminar previos
    $data['asistencias'] = array_filter($data['asistencias'], function($item) use ($tipo, $fecha) {
        return !($item['tipo'] === $tipo && $item['fecha'] === $fecha);
    });
    $data['asistencias'] = array_values($data['asistencias']);
    
    $nextId = count($data['asistencias']) > 0 ? max(array_column($data['asistencias'], 'id')) + 1 : 1;
    
    foreach ($asistencias as $refId => $estado) {
        $trabajoVal = isset($trabajo[$refId]) ? 1 : 0;
        
        if ($tipo === 'alumno') {
            $estudiante = null;
            foreach ($data['estudiantes'] as $est) {
                if ($est['id'] == $refId) { $estudiante = $est; break; }
            }
            if ($estudiante) {
                $data['asistencias'][] = [
                    "id" => $nextId++,
                    "tipo" => "alumno",
                    "ref_id" => (int)$refId,
                    "nombre" => $estudiante['nombre'],
                    "grado" => $estudiante['grado'],
                    "seccion" => $estudiante['seccion'] ?? 'A',
                    "fecha" => $fecha,
                    "hora" => date('H:i:s'),
                    "estado" => $estado,
                    "trabajo_clase" => $trabajoVal
                ];
            }
        } else {
            $profesor = null;
            foreach ($data['profesores'] as $prof) {
                if ($prof['id'] == $refId) { $profesor = $prof; break; }
            }
            if ($profesor) {
                $data['asistencias'][] = [
                    "id" => $nextId++,
                    "tipo" => "profesor",
                    "ref_id" => (int)$refId,
                    "nombre" => $profesor['nombre'],
                    "materia" => $profesor['materia'],
                    "fecha" => $fecha,
                    "hora" => date('H:i:s'),
                    "estado" => $estado,
                    "trabajo_clase" => $trabajoVal
                ];
            }
        }
    }
    saveJsonData($data);
    return true;
}

// Guardar Mensaje de Contacto
function db_add_mensaje($nombre, $email, $asunto, $mensaje) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            // Asegurarnos de que la tabla existe
            $pdo->exec("CREATE TABLE IF NOT EXISTS mensajes_contacto (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                asunto VARCHAR(100) NOT NULL,
                mensaje TEXT NOT NULL,
                fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB");
            
            $stmt = $pdo->prepare("INSERT INTO mensajes_contacto (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$nombre, $email, $asunto, $mensaje]);
        } catch (PDOException $e) {
            // Fallback to JSON
        }
    }
    
    // Fallback JSON
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    $path = $dir . '/mensajes_contacto.json';
    $data = [];
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true) ?: [];
    }
    $newId = count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1;
    $data[] = [
        "id" => $newId,
        "nombre" => $nombre,
        "email" => $email,
        "asunto" => $asunto,
        "mensaje" => $mensaje,
        "fecha_envio" => date('Y-m-d H:i:s')
    ];
    @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return true;
}

// Obtener Seguimientos
function db_get_seguimientos($estudiante_id = null) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            if ($estudiante_id) {
                $stmt = $pdo->prepare("SELECT s.id, s.estudiante_id, e.nombre, s.fecha, s.observacion, s.progreso FROM seguimiento s LEFT JOIN estudiantes e ON s.estudiante_id = e.id WHERE s.estudiante_id = ? ORDER BY s.fecha DESC");
                $stmt->execute([(int)$estudiante_id]);
            } else {
                $stmt = $pdo->query("SELECT s.id, s.estudiante_id, e.nombre, s.fecha, s.observacion, s.progreso FROM seguimiento s LEFT JOIN estudiantes e ON s.estudiante_id = e.id ORDER BY s.fecha DESC");
            }
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    // Fallback JSON
    $dir = __DIR__ . '/../data';
    $path = $dir . '/seguimiento.json';
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true) ?: [];
    } else {
        $data = [];
    }
    
    // Unir con nombres de estudiantes para el frontend
    $estudiantes = db_get_estudiantes();
    $est_map = [];
    foreach ($estudiantes as $est) {
        $est_map[$est['id']] = $est['nombre'];
    }
    
    $result = [];
    foreach ($data as $row) {
        if ($estudiante_id && $row['estudiante_id'] != $estudiante_id) continue;
        $row['nombre'] = $est_map[$row['estudiante_id']] ?? 'Desconocido';
        $result[] = $row;
    }
    
    usort($result, function($a, $b) {
        return strtotime($b['fecha']) - strtotime($a['fecha']);
    });
    
    return $result;
}

// Registrar Seguimiento
function db_add_seguimiento($estudiante_id, $fecha, $observacion, $progreso) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS seguimiento (
                id INT AUTO_INCREMENT PRIMARY KEY,
                estudiante_id INT NOT NULL,
                fecha DATE NOT NULL,
                observacion TEXT NOT NULL,
                progreso VARCHAR(50) NOT NULL,
                FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE
            ) ENGINE=InnoDB");
            
            $stmt = $pdo->prepare("INSERT INTO seguimiento (estudiante_id, fecha, observacion, progreso) VALUES (?, ?, ?, ?)");
            return $stmt->execute([(int)$estudiante_id, $fecha, $observacion, $progreso]);
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    // Fallback JSON
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    $path = $dir . '/seguimiento.json';
    $data = [];
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true) ?: [];
    }
    $newId = count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1;
    $data[] = [
        "id" => $newId,
        "estudiante_id" => (int)$estudiante_id,
        "fecha" => $fecha,
        "observacion" => $observacion,
        "progreso" => $progreso
    ];
    @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return true;
}

// ── CRUD PARA GALERÍA ────────────────────────────────────────────────

// Obtener elementos de la galería
function db_get_galerias() {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM galerias ORDER BY fecha DESC, id DESC");
            $res = $stmt->fetchAll();
            return $res;
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    $data = getJsonData();
    if (!isset($data['galerias'])) return [];
    
    // Ordenar descendente
    $g = $data['galerias'];
    usort($g, function($a, $b) {
        return $b['id'] <=> $a['id'];
    });
    return $g;
}

// Agregar elemento a la galería
function db_add_galeria($titulo, $descripcion, $imagen, $categoria, $fecha) {
    global $pdo, $db_mode;
    $categoriaLabel = ($categoria === 'defensas') ? 'Defensa' : 'Clases';
    
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->query("CREATE TABLE IF NOT EXISTS galerias (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(255) NOT NULL,
                descripcion TEXT NOT NULL,
                imagen VARCHAR(255) NOT NULL,
                categoria VARCHAR(50) NOT NULL,
                categoriaLabel VARCHAR(50) NOT NULL,
                fecha DATE NOT NULL
            ) ENGINE=InnoDB");
            
            $stmt = $pdo->prepare("INSERT INTO galerias (titulo, descripcion, imagen, categoria, categoriaLabel, fecha) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$titulo, $descripcion, $imagen, $categoria, $categoriaLabel, $fecha]);
            return true;
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    $data = getJsonData();
    if (!isset($data['galerias'])) $data['galerias'] = [];
    
    $newId = count($data['galerias']) > 0 ? max(array_column($data['galerias'], 'id')) + 1 : 1;
    $item = [
        'id'             => $newId,
        'titulo'         => $titulo,
        'descripcion'    => $descripcion,
        'imagen'         => $imagen,
        'categoria'      => $categoria,
        'categoriaLabel' => $categoriaLabel,
        'fecha'          => $fecha
    ];
    $data['galerias'][] = $item;
    saveJsonData($data);
    return true;
}

// Obtener Experiencias
function db_get_experiencias() {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            // Revisa si existe la tabla
            $stmt = $pdo->query("SHOW TABLES LIKE 'experiencias'");
            if ($stmt->rowCount() > 0) {
                $stmt = $pdo->query("SELECT * FROM experiencias ORDER BY id DESC");
                return $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            // Fallback
        }
    }
    $data = getJsonData();
    return array_reverse($data['experiencias'] ?? []); // Mostrar más nuevos primero
}

// Agregar Experiencia
function db_add_experiencia($nombre, $rol, $comentario) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $pdo->query("CREATE TABLE IF NOT EXISTS experiencias (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                rol VARCHAR(100) NOT NULL,
                comentario TEXT NOT NULL,
                fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB");
            $stmt = $pdo->prepare("INSERT INTO experiencias (nombre, rol, comentario) VALUES (?, ?, ?)");
            return $stmt->execute([$nombre, $rol, $comentario]);
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    $data = getJsonData();
    if (!isset($data['experiencias'])) $data['experiencias'] = [];
    $newId = count($data['experiencias']) > 0 ? max(array_column($data['experiencias'], 'id')) + 1 : 1;
    $data['experiencias'][] = [
        "id" => $newId,
        "nombre" => $nombre,
        "rol" => $rol,
        "comentario" => $comentario
    ];
    saveJsonData($data);
    return true;
}

// Eliminar Experiencia
function db_delete_experiencia($id) {
    global $pdo, $db_mode;
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->prepare("DELETE FROM experiencias WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    $data = getJsonData();
    if (isset($data['experiencias'])) {
        foreach ($data['experiencias'] as $key => $exp) {
            if ($exp['id'] == $id) {
                unset($data['experiencias'][$key]);
                $data['experiencias'] = array_values($data['experiencias']);
                saveJsonData($data);
                return true;
            }
        }
    }
    return false;
}

// Eliminar Galería
function db_delete_galeria($id) {
    global $pdo, $db_mode;
    
    // Primero, obtener la ruta de la imagen para borrarla del servidor
    $imagenRuta = '';
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->prepare("SELECT imagen FROM galerias WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) $imagenRuta = $row['imagen'];
        } catch (PDOException $e) { }
    } else {
        $data = getJsonData();
        if (isset($data['galerias'])) {
            foreach ($data['galerias'] as $g) {
                if ($g['id'] == $id) {
                    $imagenRuta = $g['imagen'];
                    break;
                }
            }
        }
    }

    // Intentar borrar archivo físico
    if (!empty($imagenRuta)) {
        $fullPath = __DIR__ . '/../' . $imagenRuta;
        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    // Borrar registro de BD
    if ($db_mode === 'mysql' && $pdo) {
        try {
            $stmt = $pdo->prepare("DELETE FROM galerias WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Fallback
        }
    }
    
    $data = getJsonData();
    if (isset($data['galerias'])) {
        foreach ($data['galerias'] as $key => $g) {
            if ($g['id'] == $id) {
                unset($data['galerias'][$key]);
                $data['galerias'] = array_values($data['galerias']);
                saveJsonData($data);
                return true;
            }
        }
    }
    return false;
}
