<?php
require_once __DIR__ . '/includes/db.php';

$list_5c = "Alcaraz Passerini, Danna Maite
Acosta Benítez, Brenda Abigail
Aguilar Fleitas, Benjamín
Areco Irala, Lizeth Abigail
Arguello Cabrera, Cristofer Daniel
Britez Álvarez, Bruno Benjamín
Britos Molinas, Mary Yolanda
Burgos Gavilán, Kathia Fernanda
Colina Aguilera, Jimena Ariet
Cuellar Zárate, Alex Vicente
Enciso Aveiro, Melody Abigail
Fernández Medina, Thiago Gabriel
Fernández Ramírez, Milagro Monserratth
Galeano Moray, Jadiyi Mariae
Galván González, Arianny Monserrat
Gauto Oviedo, Ana Paula
Gavilán Figueredo, Yamiro Ailen
Giménez Giménez, Emma Abigail
González Amarilla, Luana Jazmin
López Espínola, Bianca Ayelen
López Ocampo, Bastian Damián
López Villalba, Sol Maite
Martínez Báez, Michel Gael
Martínez Espinoza, Mathías Emmanuel
Medina Cardozo, Alejandro Natanael
Medina Denis, Pía Abigail
Mendoza Cáceres, Josue Orlando
Ocampo Villaverde, Rosa Ainara Danielle
Ortellado Candia, Neri Alexander
Ortiz Ferreira, Willian David
Penayo Agüero, Camila Victoria
Pintos Cabaña, Kiara Abigail
Recalde González, Elías Gael
Samudio Dimitry, Diego
Samudio Larrosa, Abigail Ailen
Sánchez Venialvos, Iker Santiago
Siguero Namandú, Axel Nicolás
Sosa Espínola, Bryan Eduardo
Sosa Zárate, Mauricio Gael
Vázquez Miranda, Zoe Nicol
Vera Duarte, Andrea Abigail";

$list_5d = "Achar Britos, Melanie Abigail
Amarilla Arias, Dalton Kadan
Arce Mairoza, Xiomara Abigail
Beaumont, Camila Juliet
Benitez Ruiz Diaz, Diego Eduardo
Britez Vargas, Lizzeth Adilen
Caceres Ojeda, Zoe Nahiara
Cañete Cristaldo, Oscar Andrés
Centurión Bogado, Cecilia Luján
Chamorro Benítez, Giuliana Aylen
Duarte Molas, Miara Dahianne
Escobar Perez, Jeremias Moises
Escurra Lusberg, Brihana Nicole
Ferreira Ortigoza, Andrés Jeremias
Garcia Zaracho, Jorge Junior
González Acosta, Jazmin Abigail
Gonzalez Medina, Mathias Enmanuel
González Ojeda, Milena Anahí
Ibarra Brizuela, Bastian Jeremias
Julian García, Omar Zahir
Martinez Irala, Victoria Jazmin
Martínez Vazquez, Matheo De Jesús
Medina Franco, Adriana Eloys
Mendez Vera, Sahily Milagros
Mendoza Fernández, Darío Alexander
Molinas Peralta, Aitana Lizeth
Mora Ramirez, Nicolas Adrian
Nuñez Rojas, Ian Carlos
Olmedo Dávalos, Delcy Abbygail
Olmedo Vargas, Milagros Maylem
Peña Ledezma, Sophia Arantza
Ramirez Barrios, Lucas Gabriel
Ramirez Caballero, Magali
Riveros Godoy, Dylan David
Riveros Sandoval, Ruth Noemi
Rodriguez Britez, Ever Fabricio
Salinas Garay, Jazmin Monserrath
Sosa Benitez, Kimberly Gabriela
Vargas Martínez, Sofia Clarisse
Velazquez Gallardo, Luana Araceli
Verza Oviedo, Vitor Manuel
Zaracho Fernández, Marian Gissel";

$list_6c = "Aguilera Fariña, Daniela Alexandra
Aguilar Grance, Robin Giovani
Altamirano Lopez, Elias Miguel
Augusto Centurion, Daynin Melissa
Avalos Chamorro, Tadeo Aaron
Bobadilla Franco, Dulce Jazmin
Cespedes Lesme, Ada Carolina
Cohene Espinola, Thiago Alexander
Espinola Garcia, Maisa Margarita
Fernandez Ramirez, Diego Daniel
Ferreira Pereira, Ricardo Josue
Franco Ayala, Veronica Jazmin
Fretes Gaona, Misael Ezequiel
Gimenez, Juana Micaela
González Carballo, Alejandra Beatriz
González Idoyaga, Elias Daniel
Leiva Ortellado, Ruth Daniela
Lopez Pintos, Lucas Sebastian
Maidana Romero, Dafne Ainara
Mancuello Cabral, Cesar Armando
Martínez Britez, Aylen Abigail
Mendez Santacruz, Yaneth Magali
Ojeda Mendoza, Evelin Sofía
Ortellado Espinola, Fernando Luis
Peña Picco, Paloma Lujan
Peralta Ortiz, Ricardo Ezequiel
Pilonetto Saad, Axel
Ramirez Torales, Luz Marina
Roa Carballo, Katia Beatriz
Ruiz Diaz Castillo, Samira Aylen
Sanabria Cardozo, Angel Iván
Sanchez Lezcano, Alma Abigail
Sanchez Ramirez, Roger Tadeo
Talavera Lopez, Mia Valentina
Testi Sanchez, Giorgio Ezequiel
Torales Ríos, Gabriela Ailin
Venialgo Patiño, Antonella
Venialgo Sanchez, Ruben Fernando
Villaverde Acuña, Denis Joaquin
Zarate Aguilera, Alcides Miguel";

$list_6d = "Alfonzo Mendoza, Samira Magali
Almiron Ojeda, Danna María
Amarilla Martínez, Paz Ahylen
Arce Mairosa, Blas Héctor Gabriel
Arevalos Ramírez, Juan Alvin Ezequiel
Arzamendia Guillen, Camila Lujan
Ayala García, Alexis Luciano
Barea Lopez, Samirah Jihan
Barreto López, Debanhi Ayelen Francys
Caballero Arguello, Solara Beatriz
Caballero Ruiz, Sofía Abigail
Cabañas Garay, Hanna Cristel
Cáceres Agüero, Jilhian Kendra Nicol
Carballo Molas, Álvaro Josue
Cardozo Fernández, Emily Mary Paz
Cardozo Quiroga, Alma Noemi
Castillo Armoa, Facundo Farid
Cespedes Duarte, Alejandro Agustín
Cespedes Rodas, Maximiliano Miguel
Coronel Perez, Santiago Gabriel
Duarte Vega, Enzo Santiago
Espinoza Espínola, Luz Camila
Fariña Baez, Roger Daniel
Fernández Cardozo, Fiorella Guadalupe
Fernández Medina, Yeruti Ailen
Fonseca Ruiz Díaz, Estrella Abigail
Galeano, Yovanni Mateo
Galeano Cristaldo, Ivan Rodrigo
Garay Pintos, Anthony José
Godoy Vallejos, Carlos Javier
González Galeano, Oscar Josías
Gutierrez Lezcano, Paloma Beatriz
Leguizamon Britez, Tomás Leonardo
López Sánchez, Fabricio Adrián
Mareco Fariña, Alani Andrea
Mendez Baez, Kelly Amambay
Mendoza Benítez, Sofía Belén
Mendoza Ortigoza, Hector Francisco
Rivas Ríos, Thais Martina
Roman Quintana, Igor Fabricio
Rotela Cardozo, Lucas Ramon
Salinas Montiel, María Mercedes
Samudio Flores, Ronal Rodrigo
Santacruz Rodríguez, Erica Valentina
Segovia Segovia, Misael Alejandro
Uruñaga Vera, Lucas Gabriel
Vazquez Torales, Belinda Abigail
Vera Chamorro, Aaron Alejandro
Villar Candia, Kimberly Abigail
Yegros Fretes, Kenny Esteban
Zapata Rojas, César Isaac";

$lists = [
    ['grado' => 1, 'seccion' => 'C', 'data' => explode("\n", $list_5c)],
    ['grado' => 1, 'seccion' => 'D', 'data' => explode("\n", $list_5d)],
    ['grado' => 2, 'seccion' => 'C', 'data' => explode("\n", $list_6c)],
    ['grado' => 2, 'seccion' => 'D', 'data' => explode("\n", $list_6d)],
];

// Helper para ejecutar el esquema SQL
function execute_sql_schema($pdo) {
    $sqlContent = @file_get_contents(__DIR__ . '/crece_bti.sql');
    if ($sqlContent) {
        $statements = explode(';', $sqlContent);
        foreach ($statements as $statement) {
            if (trim($statement)) {
                try {
                    $pdo->exec($statement);
                } catch (PDOException $e) {
                    // Ignorar fallos si la tabla ya existe o restricciones de llaves foráneas
                }
            }
        }
    }
}

// 1. IMPORTAR AL ARCHIVO JSON LOCAL (POR SI SE USA FALLBACK)
$data = getJsonData();
$data['estudiantes'] = [];

$nextId = 1;
foreach ($lists as $list) {
    $g = $list['grado'] == 1 ? '5to' : '6to';
    $s = $list['seccion'];
    foreach ($list['data'] as $name) {
        $name = trim($name);
        if (!empty($name)) {
            $data['estudiantes'][] = [
                'id' => $nextId++,
                'nombre' => $name,
                'grado' => $g,
                'seccion' => $s
            ];
        }
    }
}
saveJsonData($data);
echo "1. JSON local actualizado con " . ($nextId - 1) . " alumnos.<br>\n";

// 2. IMPORTAR A MYSQL LOCAL (localhost - XAMPP)
try {
    // Conectar sin base de datos especificada para crearla si no existe
    $local_pdo_init = new PDO("mysql:host=localhost;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 2
    ]);
    $local_pdo_init->exec("CREATE DATABASE IF NOT EXISTS `crece_bti` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $local_pdo_init = null;

    // Conectar a la base de datos crece_bti
    $local_pdo = new PDO("mysql:host=localhost;dbname=crece_bti;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 2
    ]);

    // Crear tablas del esquema
    execute_sql_schema($local_pdo);
    
    // Insertar grados
    $local_pdo->exec("INSERT INTO grados (id, nombre) VALUES (1, '5to Grado'), (2, '6to Grado') ON DUPLICATE KEY UPDATE nombre=nombre");

    // Truncar estudiantes
    $local_pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $local_pdo->exec("TRUNCATE TABLE estudiantes;");
    $local_pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    $stmt = $local_pdo->prepare("INSERT INTO estudiantes (nombre, grado_id, seccion) VALUES (?, ?, ?)");
    $count = 0;
    foreach ($lists as $list) {
        $g = $list['grado'];
        $s = $list['seccion'];
        foreach ($list['data'] as $name) {
            $name = trim($name);
            if (!empty($name)) {
                $stmt->execute([$name, $g, $s]);
                $count++;
            }
        }
    }
    echo "2. MySQL Local (localhost) creado e importado con $count alumnos.<br>\n";
} catch (Exception $e) {
    echo "2. MySQL Local (localhost) no disponible o falló: " . $e->getMessage() . "<br>\n";
}

// 3. IMPORTAR A MYSQL NUBE (Aiven)
try {
    $aiven_host = 'mysql-1c982f4-bticde2026.e.aivencloud.com';
    $aiven_port = '23886';
    $aiven_name = 'defaultdb';
    $aiven_user = 'avnadmin';
    $aiven_pass = 'AVNS_C8sKdn-qNUE8QgJu0Z3';
    
    $aiven_pdo = new PDO("mysql:host=$aiven_host;port=$aiven_port;dbname=$aiven_name;charset=utf8mb4", $aiven_user, $aiven_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 4
    ]);

    // Crear tablas del esquema en Aiven si no existen
    execute_sql_schema($aiven_pdo);
    
    // Insertar grados
    $aiven_pdo->exec("INSERT INTO grados (id, nombre) VALUES (1, '5to Grado'), (2, '6to Grado') ON DUPLICATE KEY UPDATE nombre=nombre");

    // Truncar estudiantes
    $aiven_pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $aiven_pdo->exec("TRUNCATE TABLE estudiantes;");
    $aiven_pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    $stmt = $aiven_pdo->prepare("INSERT INTO estudiantes (nombre, grado_id, seccion) VALUES (?, ?, ?)");
    $count = 0;
    foreach ($lists as $list) {
        $g = $list['grado'];
        $s = $list['seccion'];
        foreach ($list['data'] as $name) {
            $name = trim($name);
            if (!empty($name)) {
                $stmt->execute([$name, $g, $s]);
                $count++;
            }
        }
    }
    echo "3. MySQL Nube (Aiven) creado e importado con $count alumnos.<br>\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
