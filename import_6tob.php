<?php
/**
 * Script para importar la lista de 6to B
 */
require_once __DIR__ . '/includes/db.php';

$alumnos = [
    "Aguirre Cabrera, Hugo David",
    "Alfonzo Duarte, Facundo Joaquin",
    "Alviso Céspedes, Milagros Milena",
    "Aranda González, Armando Daniel",
    "Ayala Cárdenas, Erica Mariana",
    "Benítez Mancia, Veronica Abigail",
    "Benítez Sánchez, Fide Alexander",
    "Bobadilla Coronel, Bruno Manuel",
    "Bogado Balbuena, Iván Tadeo",
    "Britez Melgarejo, Thiago Nahuel",
    "Cano Sánchez, Matías Benjamín",
    "Cardozo Soto, Luciana Magalí",
    "Castillo Armoa, Micaela Rubí",
    "Colman Mora, Alisson Gabriela",
    "Fernandez Vera, Alejandro Aquiles",
    "Ferreira Bogado, Mirella Aylén",
    "Franco Fleitas, Isabela Jeruti",
    "Frutos Sanabria, Victor Daniel",
    "Giménez Ayala, Sofia Isabella",
    "Giménez Iglesias, Suri Nicol",
    "Giménez Vera, Samuel Edgar",
    "González Almada, Derlis Gustavo Emmanuel",
    "González Espínola, Josías Daniel",
    "Hermosilla Vera, Danna Abigail",
    "Leguizamón Martínez, Julieta Maite",
    "López Arevalos, Mathias Emanuel",
    "Martínez González, Milena Abigail",
    "Martínez Nuñez, Katherin Jazmin",
    "Medina Torres, Elias Josué",
    "Morán Sánchez, Sofia Magdalena",
    "Ojeda Gonzalez, Paz Thainara",
    "Ojeda Pereira, Danna Nicole",
    "Olmedo Morinigo, Vanina Guadalupe",
    "Ovelar Nuñez, Lucas Tadeo",
    "Pérez Alvarenga, Dylan Josué",
    "Pires González, Murilo Vinicius",
    "Prieto Achucarro, Dylhan David",
    "Prieto Sostoa, Thiago Nahuel",
    "Recalde Aquino, Sofia Isabel",
    "Recalde Rios, Arianne Valentina",
    "Rojas Cardozo, Anahi Paloma",
    "Rojas Méndez, Sofia Milagros",
    "Sosa Báez, Melanie Licebt",
    "Toledo Ayala, Alex Daniel",
    "Toledo Mora, Victoria Alejandra",
    "Torales González, Isaías Eduardo",
    "Trinidad Rojas, Danna Valentina",
    "Uldera Ramos, Genesis Rocio",
    "Valdez Ibarra, Marcelo Alejandro",
    "Vega Godoy, Judy Fiomara",
    "Vera Frutos, Kevin Ivan",
    "Villar González, Luis Fernando",
    "Vázquez Ramírez, Raissa Janire",
    "Zarza Rivas, Alvaro David"
];

$agregados = 0;
foreach ($alumnos as $nombre) {
    // Convertimos todo a Titulo (Ej. ALONZO -> Alonzo) para uniformidad
    $nombreFormateado = mb_convert_case(strtolower($nombre), MB_CASE_TITLE, "UTF-8");
    
    if (db_add_estudiante($nombreFormateado, '6to', 'B')) {
        $agregados++;
    }
}

echo "<h1>¡Importación Exitosa!</h1>";
echo "<p>Se han agregado " . $agregados . " alumnos a 6to Grado, Sección B correctamente.</p>";
echo "<a href='index.php'>Volver al Inicio</a>";
?>
