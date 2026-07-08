<?php
$host = 'mysql-1c982f4-bticde2026.e.aivencloud.com';
$port = '23886';
$dbname = 'defaultdb';
$user = 'avnadmin';
$pass = 'AVNS_C8sKdn-qNUE8QgJu0Z3';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Crear base de datos (por si aca) y usarla
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");

    // Ejecutar el sql de crece_bti.sql
    $sqlContent = file_get_contents(__DIR__ . '/crece_bti.sql');
    $statements = explode(';', $sqlContent);
    foreach ($statements as $statement) {
        if (trim($statement)) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                // Ignorar fallos de inserción de datos de prueba por llaves foráneas
            }
        }
    }
    
    echo "Esquema base importado.\n";

    // Insertar grados
    $pdo->exec("INSERT INTO grados (id, nombre) VALUES (1, '5to Grado'), (2, '6to Grado') ON DUPLICATE KEY UPDATE nombre=nombre");

    $list_5c = "Alfonzo Mendoza, Samira Magali
Almiron Ojeda, Danna María
Amarilla Martínez, Paz Ahylen
Arce Mairosa, Blas Héctor Gabriel
Arevalos Ramírez, Juan Alvin Ezequiel
Arzamendia Guillen, Camila Lujan
Ayala García, Alexis Luciano
BAREA LOPEZ, Samirah Jihan
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
CORONEL PEREZ, Santiago Gabriel
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

    $list_6d = "Aguilera Fariña, Daniela Alexandra
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
MAIDANA ROMERO, Dafne Ainara
Mancuello Cabral, Cesar Armando
Martínez Britez, Aylen Abigail
Mendez Santacruz, Yaneth Magali
Ojeda Mendoza, Evelin Sofía
Ortellado Espinola, Fernando Luis
PEÑA PICCO, Paloma Lujan
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

    $list_6c = "Achar Britos, Melanie Abigail
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
GONZALEZ ACOSTA, JAZMIN ABIGAIL
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

    $list_5d = "lcaraz Passerini, Danna Maite
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

    $lists = [
        ['grado' => 1, 'seccion' => 'C', 'data' => explode("\n", $list_5c)],
        ['grado' => 2, 'seccion' => 'D', 'data' => explode("\n", $list_6d)],
        ['grado' => 2, 'seccion' => 'C', 'data' => explode("\n", $list_6c)],
        ['grado' => 1, 'seccion' => 'D', 'data' => explode("\n", $list_5d)],
    ];

    $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, grado_id, seccion) VALUES (?, ?, ?)");

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

    echo "Importación completada. Se importaron $count estudiantes.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
