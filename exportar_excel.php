<?php
session_start();
if (!isset($_SESSION["bti_admin"]) || $_SESSION["bti_admin"] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php';

// Obtener todas las asistencias
$asistencias = db_get_asistencias();

// Filtros recibidos
$fecha_filtro = $_GET['fecha'] ?? '';
$grado_filtro = $_GET['grado'] ?? '';
$seccion_filtro = $_GET['seccion'] ?? '';

// Filtrar solo las de alumnos y aplicar filtros opcionales
$asistencias_alumnos = array_filter($asistencias, function($a) use ($fecha_filtro, $grado_filtro, $seccion_filtro) {
    if ($a['tipo'] !== 'alumno') return false;
    
    // Si se envía fecha, debe coincidir
    if ($fecha_filtro && $a['fecha'] !== $fecha_filtro) return false;
    
    // Si se envía grado, debe coincidir
    if ($grado_filtro && ($a['grado'] ?? '') !== $grado_filtro) return false;
    
    // Si se envía sección, debe coincidir
    if ($seccion_filtro && ($a['seccion'] ?? 'A') !== $seccion_filtro) return false;

    return true;
});

// Ordenar por fecha descendente, luego por grado y nombre
usort($asistencias_alumnos, function($a, $b) {
    if ($a['fecha'] === $b['fecha']) {
        if (($a['grado'] ?? '') === ($b['grado'] ?? '')) {
            return strcmp($a['nombre'], $b['nombre']);
        }
        return strcmp($a['grado'] ?? '', $b['grado'] ?? '');
    }
    return strcmp($b['fecha'], $a['fecha']); // más reciente primero
});

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Asistencias_BTI_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
echo '<head><meta http-equiv="Content-type" content="text/html;charset=utf-8"></head>';
echo '<body style="font-family: Calibri, Arial, sans-serif;">';
echo '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">';
echo '<tr>
        <th colspan="6" style="font-size: 20px; font-weight: bold; color: #730014; text-align: center; padding: 15px; background-color: #f8fafc; border: 1px solid #000;">
            Reporte de Asistencias BTI
        </th>
      </tr>';
echo '<tr>
        <th width="100" style="background-color: #730014; color: white; font-weight: bold; height: 35px; text-align: center; border: 1px solid #000;">Fecha</th>
        <th width="90" style="background-color: #730014; color: white; font-weight: bold; text-align: center; border: 1px solid #000;">Hora</th>
        <th width="300" style="background-color: #730014; color: white; font-weight: bold; text-align: left; border: 1px solid #000;">Nombre del Alumno</th>
        <th width="90" style="background-color: #730014; color: white; font-weight: bold; text-align: center; border: 1px solid #000;">Grado</th>
        <th width="160" style="background-color: #730014; color: white; font-weight: bold; text-align: center; border: 1px solid #000;">Estado de Asistencia</th>
        <th width="130" style="background-color: #730014; color: white; font-weight: bold; text-align: center; border: 1px solid #000;">Trabajó en Clase</th>
      </tr>';

if (empty($asistencias_alumnos)) {
    echo '<tr><td colspan="6" style="text-align: center; height: 40px; font-style: italic; color: #666; border: 1px solid #000;">No hay datos de asistencia para mostrar con los filtros actuales.</td></tr>';
} else {
    foreach ($asistencias_alumnos as $a) {
        $fecha = date('d/m/Y', strtotime($a['fecha']));
        $hora = isset($a['hora']) ? date('H:i', strtotime($a['hora'])) . ' hs' : '--:-- hs';
        $nombre = htmlspecialchars($a['nombre']);
        $grado_texto = htmlspecialchars($a['grado'] ?? '');
        $seccion_texto = htmlspecialchars($a['seccion'] ?? '');
        $grado = $grado_texto . ($seccion_texto ? ' "' . $seccion_texto . '"' : '');
        $estado = htmlspecialchars($a['estado']);
        $trabajo = (!empty($a['trabajo_clase'])) ? 'Sí' : 'No';
        
        // Asignar colores por estado
        $color_estado = '#000000';
        if ($estado === 'Presente') $color_estado = '#17bb52';
        elseif ($estado === 'Ausente') $color_estado = '#e53e3e';
        elseif ($estado === 'Llegada Tardía') $color_estado = '#dd6b20';
        elseif ($estado === 'Ausencia Justificada') $color_estado = '#3182ce';

        echo "<tr>
                <td style=\"text-align: center; vertical-align: middle; height: 25px; border: 1px solid #ccc;\">{$fecha}</td>
                <td style=\"text-align: center; vertical-align: middle; border: 1px solid #ccc;\">{$hora}</td>
                <td style=\"text-align: left; vertical-align: middle; border: 1px solid #ccc;\">{$nombre}</td>
                <td style=\"text-align: center; vertical-align: middle; border: 1px solid #ccc;\">{$grado}</td>
                <td style=\"text-align: center; vertical-align: middle; color: {$color_estado}; font-weight: bold; border: 1px solid #ccc;\">{$estado}</td>
                <td style=\"text-align: center; vertical-align: middle; border: 1px solid #ccc;\">{$trabajo}</td>
              </tr>";
    }
}

echo '</table>';
echo '</body></html>';
