<?php
/**
 * Script para importar la lista de 5to B
 */
require_once __DIR__ . '/includes/db.php';

$alumnos = [
    "Acosta Benitez, Victoria",
    "ALONZO MONTEIRO DE ARAUJO, LAURA ESTHER",
    "Alvarenga Fretes, Oliver Damian",
    "Avalos Britez, Didier Daniel",
    "Balmaceda Ferreira, Fernando Josue",
    "Basaldua Escurra, Liam Gael",
    "Benitez Escurra, Kiara Lujan",
    "Britez Fernandez Sol Fiorella",
    "Brítos Reyes, Araceli Luján",
    "Caballero Gomez, Maria Sol Arami",
    "Cantero Alderete, Thiago Emmanuel",
    "Cardenas Zarate, Thiago Gael",
    "Castellano Vera, Thiago Nahuel",
    "Cristaldo Galindo, Angel Emanuel",
    "Cristaldo Jara, Emma Victoria",
    "Denis Leiva, Santiago Gabriel",
    "Doldán Román, Santino Diosnel",
    "Escurra Paredes, Elvio Jeús",
    "Fernandez Vazquez, Danna Alejandra",
    "Galeano García, Mia Nahiara",
    "Galeano Samudio, Gianna Antonella",
    "Garcia Avalos, Jesus Antonio",
    "García Navarro, Arely Luana",
    "Gimenez Herrera, Genesis Abigail",
    "Gimenez Mendez, Sally Victoria",
    "Gomez Davalos, Antonella Abigail",
    "Gonzalez Amarilla, Leidy Carolina",
    "Gonzalez Zarate, Josías Samuel",
    "Ibañez Leguizamón, Franco Miguel",
    "Jara Da Silva, Lucero Aurora",
    "Lauter Montiel, Charlotte Pietra",
    "López López, Roberto Daniel",
    "López Quiñónez, Cristhofer Daniel",
    "Lopez Rolon, Aylla Nahiara",
    "Martinez Gauto, Katheryn Thais",
    "Meza Marzal, Enzo Benjamin",
    "Molinas Segovia, Erika Lujan",
    "Moreno Martínez, Hugo Ariel",
    "Ocampos Sala, Mia Belén",
    "Ojeda Gimenez, Marthin Gael",
    "Paez Irala, Josias Serafin",
    "Pereira Acevedo, Sofia Micaela",
    "Rodriguez Ibarra, Bernardo Abel",
    "Rojas Ortellado, Mariana Ayleen",
    "Rolon Irala, Fabiani Ezequiel",
    "Salinas Aguirre, Zamira Lujan",
    "Sandoval Ramirez, Aldo Andres",
    "Silvero Ruiz Díaz, Johan Daniel",
    "Tellez Elizeche, Oliver Dadiel",
    "Valderrama López, Gabriel",
    "Velazco Velazquez, Eduardo Nicolás",
    "Vera González, Zoe Magali"
];

$agregados = 0;
foreach ($alumnos as $nombre) {
    // Convertimos todo a Titulo (Ej. ALONZO -> Alonzo) para uniformidad
    $nombreFormateado = mb_convert_case(strtolower($nombre), MB_CASE_TITLE, "UTF-8");
    
    if (db_add_estudiante($nombreFormateado, '5to', 'B')) {
        $agregados++;
    }
}

echo "<h1>¡Importación Exitosa!</h1>";
echo "<p>Se han agregado " . $agregados . " alumnos a 5to Grado, Sección B correctamente.</p>";
echo "<a href='index.php'>Volver al Inicio</a>";
?>
