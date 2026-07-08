<?php
/**
 * Script para importar la lista de 5to A
 */
require_once __DIR__ . '/includes/db.php';

$alumnos = [
    "Achucarro Cuba, Icker Rodrigo",
    "Acosta Arguello, Gabriela María Luján",
    "Aguilera Velázquez, Meliza Soeli",
    "Alvarenga Cespedes, Marcos Misael",
    "Alvarez Britez, Amalia Cibelle",
    "Amarilla Román, Matheo Samuel",
    "Aranda González, Ruth Fabiola",
    "Báez Velázquez, Pablo Josué",
    "Bareiro Brizuela, Michelli Jazmín",
    "Bavera Enciso, Aaron Jesús",
    "Benítez García, Dylan Matías",
    "Britez Gamarra, Lucía Milagro",
    "Cáceres Cabrera, Melany Aryane",
    "Cáceres Candia, Sofía Luján",
    "Cano Ledesma, Cristel Milena",
    "Coronel Britos, Mía Valentina",
    "Díaz Fernández, Cesar Iam",
    "Duarte Duarte, Thiago Joaquín",
    "Escobar Torres, Isaías Santiago",
    "Espínola Espínola, Thiago Josue",
    "Estigarribia González, Katherine Monserrath",
    "Ferreira Ávalos, Silvia Marisol",
    "Ferreira Castro, Sofía Mariel",
    "Figueredo Báez, Josías Miguel",
    "Flores Zapattini, Paloma Nicolle",
    "Franco Aquino, Milagros Elizabeth",
    "Frutos Sanabria, Victor Aaron",
    "Gamarra Fariña, Lucas Mateo",
    "Giménez Espínola, Samira Nicole",
    "Gimenez García, Jeremías Andrés",
    "Godoy Aguirre, Axel Ariel",
    "Gómez Insaurralde, Jorge Leonardo",
    "Herrera Idoyaga, Alexander de Jesús",
    "Jara Da Silva, Julieta María Saharí",
    "Larroza Garay, Guillermo Gael",
    "Lime Davalos, Sofía Rebeca",
    "Lisboa Ledesma, Juan David",
    "Maciel Ozuna, David Luiz",
    "Melgarejo Pereira, Dylan Santiago",
    "Molas Marecos, Max Missael",
    "Morgalos Martínez, Kael Abraham",
    "Morán Sánchez, Kevin Fabián",
    "Ojeda Giménez, Gabriel Josue",
    "Paredes Rivas, Lucas Paul",
    "Reguera Benítez, Edgar Elías",
    "Rodríguez Cabrera, Cesar Asmir",
    "Rojas Cardozo, Abigail Yeruti",
    "Rotela Nuñez, Hector Josue",
    "Silvero Benítez, Zoe Abigaíl",
    "Talavera Martínez, Alaia Jazmín",
    "Vera Franco, Izán Israel"
];

$agregados = 0;
foreach ($alumnos as $nombre) {
    // Convertimos todo a Titulo (Ej. ALONZO -> Alonzo) para uniformidad
    $nombreFormateado = mb_convert_case(strtolower($nombre), MB_CASE_TITLE, "UTF-8");
    
    if (db_add_estudiante($nombreFormateado, '5to', 'A')) {
        $agregados++;
    }
}

echo "<h1>¡Importación Exitosa!</h1>";
echo "<p>Se han agregado " . $agregados . " alumnos a 5to Grado, Sección A correctamente.</p>";
echo "<a href='index.php'>Volver al Inicio</a>";
?>
