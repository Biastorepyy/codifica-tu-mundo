<?php
/**
 * Script para importar la lista de 6to A
 */
require_once __DIR__ . '/includes/db.php';

$alumnos = [
    "Acosta Florentin, Angie Gabriela",
    "Adorno, Alejandro Miguel",
    "Alarcón Paredes, Igor Nahuel",
    "Ávalos Fretes, Thais Aylen",
    "Báez Cáceres, Perla Celeste",
    "Báez Noguera, Paloma Janice",
    "Báez Rivas, Nahiara Anabel",
    "Bazán Bareiro, Alberto Junior",
    "Bazán González, Mathias Gael",
    "Benítez Britez, Thiago Alexander",
    "Benítez Núñez, Alejandro Nahuel",
    "Benítez Paredes, Yanina Itzel",
    "Bogado Dávalos, Luján Jassiel",
    "Bogarín Rodríguez, Selena Madeleine",
    "Britez Acosta, Sofía Guadalupe",
    "Cabrera Duarte, Jesús Emanuel",
    "Cáceres Duarte, Alan Sebastian",
    "Cohene Sanchez, Aynara Abigail",
    "Cuba Molinas, Fabio Alexander",
    "Duarte Cabrera, Thiago Jesús",
    "Duarte Vera, Sofía Isabella",
    "Escobar Duarte, Adriana Isabela",
    "Espínola Gomez, Fernando Samuel",
    "Fariña Martínez, Amira Isabella",
    "Ferreira González, Lucas David",
    "Franco Martínez, Helem Beatriz",
    "Gamarra Pereira, Valery Gabriela",
    "Gomez Durañona, Santiago Benjamín",
    "Gómez Fernández, Carla Nazareth",
    "González Medina, Ever Sebastian",
    "Idoyaga Ríos, Aranza Abigail",
    "Irala Correa, Jonás Emanuel",
    "Martínez Rojas, Sofía Anahí",
    "Melgarejo Samudio, Melissa Mariel",
    "Pico Lambaré, Michel Alexander",
    "Pintos Enciso, Zahira Gabriela",
    "Portillo Morfín, Elías Daniel",
    "Ramírez Torres, Rocío Aramí",
    "Roa Castillo, Fabio Rafael",
    "Rojas Benitez, Magalí Abigaíl",
    "Rolón Dure, Mónica María Paz",
    "Romero González, Danna Fiorella",
    "Sánchez Muñiz, Pedro Fernando",
    "Segovia Sánchez, Kathia Belinda Aide",
    "Sosa Mendoza, Santiago Nicolás",
    "Vera Villalba, Dahiana Aylen",
    "Villagra Vera, Vanía Abigaíl",
    "Villalba Benítez, Lucas Julián",
    "Villalba Holt, Mathias Benjamín"
];

$agregados = 0;
foreach ($alumnos as $nombre) {
    // Convertimos todo a Titulo (Ej. ALONZO -> Alonzo) para uniformidad
    $nombreFormateado = mb_convert_case(strtolower($nombre), MB_CASE_TITLE, "UTF-8");
    
    if (db_add_estudiante($nombreFormateado, '6to', 'A')) {
        $agregados++;
    }
}

echo "<h1>¡Importación Exitosa!</h1>";
echo "<p>Se han agregado " . $agregados . " alumnos a 6to Grado, Sección A correctamente.</p>";
echo "<a href='index.php'>Volver al Inicio</a>";
?>
