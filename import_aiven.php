<?php
require_once __DIR__ . '/includes/db.php';

$list_5a = "Achucarro Cuba, Icker Rodrigo
Acosta Arguello, Gabriela María Luján
Aguilera Velázquez, Meliza Soeli
Alvarenga Cespedes, Marcos Misael
Alvarez Britez, Amalia Cibelle
Amarilla Román, Matheo Samuel
Aranda González, Ruth Fabiola
Báez Velázquez, Pablo Josué
Bareiro Brizuela, Michelli Jazmín
Bavera Enciso, Aaron Jesús
Benítez García, Dylan Matías
Britez Gamarra, Lucía Milagro
Cáceres Cabrera, Melany Aryane
Cáceres Candia, Sofía Luján
Cano Ledesma, Cristel Milena
Coronel Britos, Mía Valentina
Díaz Fernández, Cesar Iam
Duarte Duarte, Thiago Joaquín
Escobar Torres, Isaías Santiago
Espínola Espínola, Thiago Josue
Estigarribia González, Katherine Monserrath
Ferreira Ávalos, Silvia Marisol
Ferreira Castro, Sofía Mariel
Figueredo Báez, Josías Miguel
Flores Zapattini, Paloma Nicolle
Franco Aquino, Milagros Elizabeth
Frutos Sanabria, Victor Aaron
Gamarra Fariña, Lucas Mateo
Giménez Espínola, Samira Nicole
Gimenez García, Jeremías Andrés
Godoy Aguirre, Axel Ariel
Gómez Insaurralde, Jorge Leonardo
Herrera Idoyaga, Alexander de Jesús
Jara Da Silva, Julieta María Saharí
Larroza Garay, Guillermo Gael
Lime Davalos, Sofía Rebeca
Lisboa Ledesma, Juan David
Maciel Ozuna, David Luiz
Melgarejo Pereira, Dylan Santiago
Molas Marecos, Max Missael
Morgalos Martínez, Kael Abraham
Morán Sánchez, Kevin Fabián
Ojeda Giménez, Gabriel Josue
Paredes Rivas, Lucas Paul
Reguera Benítez, Edgar Elías
Rodríguez Cabrera, Cesar Asmir
Rojas Cardozo, Abigail Yeruti
Rotela Nuñez, Hector Josue
Silvero Benítez, Zoe Abigaíl
Talavera Martínez, Alaia Jazmín
Vera Franco, Izán Israel";

$list_5b = "Acosta Benitez, Victoria
ALONZO MONTEIRO DE ARAUJO, LAURA ESTHER
Alvarenga Fretes, Oliver Damian
Avalos Britez, Didier Daniel
Balmaceda Ferreira, Fernando Josue
Basaldua Escurra, Liam Gael
Benitez Escurra, Kiara Lujan
Britez Fernandez Sol Fiorella
Brítos Reyes, Araceli Luján
Caballero Gomez, Maria Sol Arami
Cantero Alderete, Thiago Emmanuel
Cardenas Zarate, Thiago Gael
Castellano Vera, Thiago Nahuel
Cristaldo Galindo, Angel Emanuel
Cristaldo Jara, Emma Victoria
Denis Leiva, Santiago Gabriel
Doldán Román, Santino Diosnel
Escurra Paredes, Elvio Jeús
Fernandez Vazquez, Danna Alejandra
Galeano García, Mia Nahiara
Galeano Samudio, Gianna Antonella
Garcia Avalos, Jesus Antonio
García Navarro, Arely Luana
Gimenez Herrera, Genesis Abigail
Gimenez Mendez, Sally Victoria
Gomez Davalos, Antonella Abigail
Gonzalez Amarilla, Leidy Carolina
Gonzalez Zarate, Josías Samuel
Ibañez Leguizamón, Franco Miguel
Jara Da Silva, Lucero Aurora
Lauter Montiel, Charlotte Pietra
López López, Roberto Daniel
López Quiñónez, Cristhofer Daniel
Lopez Rolon, Aylla Nahiara
Martinez Gauto, Katheryn Thais
Meza Marzal, Enzo Benjamin
Molinas Segovia, Erika Lujan
Moreno Martínez, Hugo Ariel
Ocampos Sala, Mia Belén
Ojeda Gimenez, Marthin Gael
Paez Irala, Josias Serafin
Pereira Acevedo, Sofia Micaela
Rodriguez Ibarra, Bernardo Abel
Rojas Ortellado, Mariana Ayleen
Rolon Irala, Fabiani Ezequiel
Salinas Aguirre, Zamira Lujan
Sandoval Ramirez, Aldo Andres
Silvero Ruiz Díaz, Johan Daniel
Tellez Elizeche, Oliver Dadiel
Valderrama López, Gabriel
Velazco Velazquez, Eduardo Nicolás
Vera González, Zoe Magali";

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

$list_6a = "Acosta Florentin, Angie Gabriela
Adorno, Alejandro Miguel
Alarcón Paredes, Igor Nahuel
Ávalos Fretes, Thais Aylen
Báez Cáceres, Perla Celeste
Báez Noguera, Paloma Janice
Báez Rivas, Nahiara Anabel
Bazán Bareiro, Alberto Junior
Bazán González, Mathias Gael
Benítez Britez, Thiago Alexander
Benítez Núñez, Alejandro Nahuel
Benítez Paredes, Yanina Itzel
Bogado Dávalos, Luján Jassiel
Bogarín Rodríguez, Selena Madeleine
Britez Acosta, Sofía Guadalupe
Cabrera Duarte, Jesús Emanuel
Cáceres Duarte, Alan Sebastian
Cohene Sanchez, Aynara Abigail
Cuba Molinas, Fabio Alexander
Duarte Cabrera, Thiago Jesús
Duarte Vera, Sofía Isabella
Escobar Duarte, Adriana Isabela
Espínola Gomez, Fernando Samuel
Fariña Martínez, Amira Isabella
Ferreira González, Lucas David
Franco Martínez, Helem Beatriz
Gamarra Pereira, Valery Gabriela
Gomez Durañona, Santiago Benjamín
Gómez Fernández, Carla Nazareth
González Medina, Ever Sebastian
Idoyaga Ríos, Aranza Abigail
Irala Correa, Jonás Emanuel
Martínez Rojas, Sofía Anahí
Melgarejo Samudio, Melissa Mariel
Pico Lambaré, Michel Alexander
Pintos Enciso, Zahira Gabriela
Portillo Morfín, Elías Daniel
Ramírez Torres, Rocío Aramí
Roa Castillo, Fabio Rafael
Rojas Benitez, Magalí Abigaíl
Rolón Dure, Mónica María Paz
Romero González, Danna Fiorella
Sánchez Muñiz, Pedro Fernando
Segovia Sánchez, Kathia Belinda Aide
Sosa Mendoza, Santiago Nicolás
Vera Villalba, Dahiana Aylen
Villagra Vera, Vanía Abigaíl
Villalba Benítez, Lucas Julián
Villalba Holt, Mathias Benjamín";

$list_6b = "Aguirre Cabrera, Hugo David
Alfonzo Duarte, Facundo Joaquin
Alviso Céspedes, Milagros Milena
Aranda González, Armando Daniel
Ayala Cárdenas, Erica Mariana
Benítez Mancia, Veronica Abigail
Benítez Sánchez, Fide Alexander
Bobadilla Coronel, Bruno Manuel
Bogado Balbuena, Iván Tadeo
Britez Melgarejo, Thiago Nahuel
Cano Sánchez, Matías Benjamín
Cardozo Soto, Luciana Magalí
Castillo Armoa, Micaela Rubí
Colman Mora, Alisson Gabriela
Fernandez Vera, Alejandro Aquiles
Ferreira Bogado, Mirella Aylén
Franco Fleitas, Isabela Jeruti
Frutos Sanabria, Victor Daniel
Giménez Ayala, Sofia Isabella
Giménez Iglesias, Suri Nicol
Giménez Vera, Samuel Edgar
González Almada, Derlis Gustavo Emmanuel
González Espínola, Josías Daniel
Hermosilla Vera, Danna Abigail
Leguizamón Martínez, Julieta Maite
López Arevalos, Mathias Emanuel
Martínez González, Milena Abigail
Martínez Nuñez, Katherin Jazmin
Medina Torres, Elias Josué
Morán Sánchez, Sofia Magdalena
Ojeda Gonzalez, Paz Thainara
Ojeda Pereira, Danna Nicole
Olmedo Morinigo, Vanina Guadalupe
Ovelar Nuñez, Lucas Tadeo
Pérez Alvarenga, Dylan Josué
Pires González, Murilo Vinicius
Prieto Achucarro, Dylhan David
Prieto Sostoa, Thiago Nahuel
Recalde Aquino, Sofia Isabel
Recalde Rios, Arianne Valentina
Rojas Cardozo, Anahi Paloma
Rojas Méndez, Sofia Milagros
Sosa Báez, Melanie Licebt
Toledo Ayala, Alex Daniel
Toledo Mora, Victoria Alejandra
Torales González, Isaías Eduardo
Trinidad Rojas, Danna Valentina
Uldera Ramos, Genesis Rocio
Valdez Ibarra, Marcelo Alejandro
Vega Godoy, Judy Fiomara
Vera Frutos, Kevin Ivan
Villar González, Luis Fernando
Vázquez Ramírez, Raissa Janire
Zarza Rivas, Alvaro David";

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
    ['grado' => 1, 'seccion' => 'A', 'data' => explode("\n", $list_5a)],
    ['grado' => 1, 'seccion' => 'B', 'data' => explode("\n", $list_5b)],
    ['grado' => 1, 'seccion' => 'C', 'data' => explode("\n", $list_5c)],
    ['grado' => 1, 'seccion' => 'D', 'data' => explode("\n", $list_5d)],
    ['grado' => 2, 'seccion' => 'A', 'data' => explode("\n", $list_6a)],
    ['grado' => 2, 'seccion' => 'B', 'data' => explode("\n", $list_6b)],
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
            $nameFormateado = mb_convert_case(strtolower($name), MB_CASE_TITLE, "UTF-8");
            $data['estudiantes'][] = [
                'id' => $nextId++,
                'nombre' => $nameFormateado,
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
                $nameFormateado = mb_convert_case(strtolower($name), MB_CASE_TITLE, "UTF-8");
                $stmt->execute([$nameFormateado, $g, $s]);
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
                $nameFormateado = mb_convert_case(strtolower($name), MB_CASE_TITLE, "UTF-8");
                $stmt->execute([$nameFormateado, $g, $s]);
                $count++;
            }
        }
    }
    echo "3. MySQL Nube (Aiven) creado e importado con $count alumnos.<br>\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
