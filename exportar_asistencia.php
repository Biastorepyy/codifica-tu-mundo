<?php
/**
 * Script: Exportar Asistencia a Excel Estilizado (.xls / HTML)
 * Proyecto Integrador - 3° BTI CRECE
 * 
 * Genera un archivo HTML formateado que Excel abre directamente
 * con colores institucionales, encabezados, badges y resumen estadístico.
 */

require_once __DIR__ . '/includes/db.php';

$asistencias = db_get_asistencias();

// ── Obtener parámetros de filtro ────────────────────────────────────────
$tipo  = $_GET['tipo']  ?? 'todos';
$grado = $_GET['grado'] ?? 'todos';
$fecha = $_GET['fecha'] ?? '';

// ── Filtrar ─────────────────────────────────────────────────────────────
$filtrados = [];
foreach ($asistencias as $item) {
    $matchTipo  = $tipo  === 'todos' || $item['tipo'] === $tipo;
    $matchGrado = $grado === 'todos' || (isset($item['grado']) && $item['grado'] === $grado);
    $matchFecha = empty($fecha) || $item['fecha'] === $fecha;
    if ($matchTipo && $matchGrado && $matchFecha) {
        $filtrados[] = $item;
    }
}

// ── Ordenar por fecha descendente ────────────────────────────────────────
usort($filtrados, fn($a, $b) => strcmp($b['fecha'], $a['fecha']));

// ── Estadísticas de resumen ──────────────────────────────────────────────
$stats = ['Presente' => 0, 'Ausente' => 0, 'Llegada Tardía' => 0, 'Ausencia Justificada' => 0];
foreach ($filtrados as $r) {
    $e = $r['estado'] ?? '';
    if (isset($stats[$e])) $stats[$e]++;
}
$total = count($filtrados);

// ── Etiquetas de filtro para el título ────────────────────────────────────
$labelTipo  = $tipo  === 'todos' ? 'Todos' : ($tipo === 'alumno' ? 'Alumnos' : 'Docentes');
$labelGrado = $grado === 'todos' ? 'Todos' : $grado . ' Grado';
$labelFecha = !empty($fecha) ? (function($f){ $p=explode('-',$f); return "{$p[2]}/{$p[1]}/{$p[0]}"; })($fecha) : 'Todas las fechas';
$fechaGen   = date('d/m/Y H:i');

// ── Cabeceras HTTP ────────────────────────────────────────────────────────
$filename = 'reporte_asistencia_' . date('Ymd_His') . '.xls';
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// ── Función de color para el estado ──────────────────────────────────────
function estadoStyle(string $estado): string {
    return match($estado) {
        'Presente'            => 'background:#e6f6ec;color:#137a3a;border:1px solid #b2dfcc;font-weight:700;border-radius:4px;',
        'Ausente'             => 'background:#fce8e6;color:#c0392b;border:1px solid #f5b7b1;font-weight:700;',
        'Llegada Tardía'      => 'background:#fff8ec;color:#d68910;border:1px solid #f9d79b;font-weight:700;',
        'Ausencia Justificada'=> 'background:#ebf4ff;color:#1a5276;border:1px solid #aed6f1;font-weight:700;',
        default               => 'background:#f2f2f2;color:#555;',
    };
}

// ── Icono emoji por estado ────────────────────────────────────────────────
function estadoIcon(string $estado): string {
    return match($estado) {
        'Presente'             => '✓ ',
        'Ausente'              => '✗ ',
        'Llegada Tardía'       => '⏰ ',
        'Ausencia Justificada' => '📋 ',
        default                => '',
    };
}

// ── HTML del documento Excel ──────────────────────────────────────────────
echo <<<HTML
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--[if gte mso 9]>
<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
<x:Name>Asistencias</x:Name>
<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>
<![endif]-->
<style>
  body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
  table { border-collapse: collapse; width: 100%; }
  td, th { padding: 8px 12px; vertical-align: middle; }

  /* ── Encabezado institucional ── */
  .hdr-inst {
    background: #730014;
    color: #ffffff;
    font-size: 15pt;
    font-weight: bold;
    letter-spacing: 1px;
    text-align: left;
    padding: 14px 18px;
  }
  .hdr-sub {
    background: #4a0010;
    color: #f5c6cc;
    font-size: 9pt;
    padding: 5px 18px 8px;
    text-align: left;
    font-style: italic;
  }

  /* ── Fila de filtros activos ── */
  .filter-row {
    background: #f9f0f2;
    color: #730014;
    font-size: 9pt;
    padding: 6px 18px;
    border-bottom: 2px solid #730014;
  }

  /* ── Resumen estadístico ── */
  .stats-row td {
    background: #fff8f0;
    font-size: 10pt;
    border: 1px solid #e0ccc0;
    text-align: center;
    font-weight: 600;
    padding: 10px 8px;
  }
  .stats-label {
    font-size: 8pt;
    font-weight: normal;
    color: #888;
    display: block;
  }

  /* ── Cabecera de la tabla ── */
  .th-main {
    background: #730014;
    color: #ffffff;
    font-weight: bold;
    font-size: 10pt;
    text-align: left;
    border: 1px solid #5a000f;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* ── Filas de datos ── */
  .row-even { background: #ffffff; }
  .row-odd  { background: #fdf5f7; }
  .td-base  { border: 1px solid #e8d5d8; font-size: 10pt; color: #2d3748; }
  .td-name  { font-weight: 600; color: #1a202c; }
  .td-rol-alumno  { color: #6b21a8; font-weight: 600; font-size: 9pt; }
  .td-rol-docente { color: #0e4f8c; font-weight: 600; font-size: 9pt; }

  /* ── Pie de página ── */
  .footer-row td {
    background: #f2f2f2;
    color: #999;
    font-size: 8pt;
    padding: 8px 12px;
    border-top: 2px solid #ddd;
    text-align: center;
    font-style: italic;
  }
</style>
</head>
<body>
<table>

  <!-- ════ ENCABEZADO INSTITUCIONAL ════ -->
  <tr>
    <td class="hdr-inst" colspan="5">
      🏫&nbsp; Reporte de Asistencias — 3° BTI CRECE
    </td>
  </tr>
  <tr>
    <td class="hdr-sub" colspan="5">
      Centro Regional de Educación &nbsp;·&nbsp; Bachillerato Técnico en Informática &nbsp;·&nbsp; Ciudad del Este
    </td>
  </tr>

  <!-- ════ FILTROS ACTIVOS ════ -->
  <tr>
    <td class="filter-row" colspan="5">
      <b>Filtros aplicados:</b>&nbsp;
      Tipo: <b>{$labelTipo}</b> &nbsp;|&nbsp;
      Grado: <b>{$labelGrado}</b> &nbsp;|&nbsp;
      Fecha: <b>{$labelFecha}</b> &nbsp;|&nbsp;
      Generado: <b>{$fechaGen}</b>
    </td>
  </tr>

  <!-- ════ FILA VACÍA DE SEPARACIÓN ════ -->
  <tr><td colspan="5" style="padding:4px;background:#f9f0f2;"></td></tr>

  <!-- ════ ESTADÍSTICAS RESUMIDAS ════ -->
  <tr class="stats-row">
    <td style="background:#e6f6ec;border:1px solid #b2dfcc;color:#137a3a;text-align:center;padding:10px 8px;font-weight:700;font-size:11pt;">
      ✓ {$stats['Presente']}
      <span class="stats-label">Presentes</span>
    </td>
    <td style="background:#fce8e6;border:1px solid #f5b7b1;color:#c0392b;text-align:center;padding:10px 8px;font-weight:700;font-size:11pt;">
      ✗ {$stats['Ausente']}
      <span class="stats-label">Ausentes</span>
    </td>
    <td style="background:#fff8ec;border:1px solid #f9d79b;color:#d68910;text-align:center;padding:10px 8px;font-weight:700;font-size:11pt;">
      ⏰ {$stats['Llegada Tardía']}
      <span class="stats-label">Llegada Tardía</span>
    </td>
    <td style="background:#ebf4ff;border:1px solid #aed6f1;color:#1a5276;text-align:center;padding:10px 8px;font-weight:700;font-size:11pt;">
      📋 {$stats['Ausencia Justificada']}
      <span class="stats-label">Justificados</span>
    </td>
    <td style="background:#f2f2f2;border:1px solid #ddd;color:#444;text-align:center;padding:10px 8px;font-weight:700;font-size:11pt;">
      {$total}
      <span class="stats-label">Total</span>
    </td>
  </tr>

  <!-- ════ FILA VACÍA ════ -->
  <tr><td colspan="5" style="padding:6px;"></td></tr>

  <!-- ════ ENCABEZADO DE COLUMNAS ════ -->
  <tr>
    <th class="th-main" style="width:100px;">📅 Fecha</th>
    <th class="th-main" style="width:220px;">👤 Nombre Completo</th>
    <th class="th-main" style="width:90px;">🎓 Rol</th>
    <th class="th-main" style="width:140px;">📚 Grado / Especialidad</th>
    <th class="th-main" style="width:160px;">📊 Estado de Asistencia</th>
  </tr>

HTML;

// ── Filas de datos ───────────────────────────────────────────────────────
if (empty($filtrados)) {
    echo '<tr><td colspan="5" style="text-align:center;color:#999;padding:24px;font-style:italic;border:1px solid #eee;">No hay registros con los filtros aplicados.</td></tr>';
} else {
    foreach ($filtrados as $i => $row) {
        $rowClass = ($i % 2 === 0) ? 'row-even' : 'row-odd';
        $rol      = $row['tipo'] === 'alumno' ? 'Alumno' : 'Docente';
        $rolClass = $row['tipo'] === 'alumno' ? 'td-rol-alumno' : 'td-rol-docente';
        $gradoEsp = $row['tipo'] === 'alumno'
            ? (($row['grado'] ?? '') . ' Grado')
            : ($row['materia'] ?? 'Especialidad');

        // Formatear fecha
        $parts        = explode('-', $row['fecha'] ?? '');
        $fechaFormato = count($parts) === 3
            ? "{$parts[2]}/{$parts[1]}/{$parts[0]}"
            : ($row['fecha'] ?? '');

        $estado      = $row['estado'] ?? '';
        $estadoStyle = estadoStyle($estado);
        $estadoIcon  = estadoIcon($estado);
        $estadoTxt   = htmlspecialchars($estadoIcon . $estado);

        echo "<tr class=\"{$rowClass}\">";
        echo "  <td class=\"td-base\" style=\"text-align:center;font-weight:600;color:#444;\">{$fechaFormato}</td>";
        echo "  <td class=\"td-base td-name\">" . htmlspecialchars($row['nombre'] ?? '') . "</td>";
        echo "  <td class=\"td-base {$rolClass}\" style=\"text-align:center;\">{$rol}</td>";
        echo "  <td class=\"td-base\" style=\"color:#4a5568;\">" . htmlspecialchars($gradoEsp) . "</td>";
        echo "  <td class=\"td-base\" style=\"{$estadoStyle}text-align:center;\">{$estadoTxt}</td>";
        echo "</tr>\n";
    }
}

// ── Pie de página ─────────────────────────────────────────────────────────
echo <<<HTML

  <!-- ════ PIE DE PÁGINA ════ -->
  <tr><td colspan="5" style="padding:4px;background:#f9f0f2;"></td></tr>
  <tr>
    <td class="footer-row" colspan="5">
      Documento generado automáticamente por el Sistema de Gestión CRECE &nbsp;·&nbsp; {$fechaGen} &nbsp;·&nbsp; Total de registros: {$total}
    </td>
  </tr>

</table>
</body>
</html>
HTML;
exit();
