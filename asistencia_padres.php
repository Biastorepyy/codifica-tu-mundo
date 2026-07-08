<?php
/**
 * Página de Asistencia para Padres
 * Proyecto Integrador - 3° BTI CRECE
 */

$pageTitle = "Asistencia Alumnos";
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

// Obtener la lista de estudiantes para el dropdown
$estudiantes = db_get_estudiantes();

$grados_unicos = [];
$secciones_unicas = [];
foreach ($estudiantes as $est) {
    if (!empty($est['grado']) && !in_array($est['grado'], $grados_unicos)) {
        $grados_unicos[] = $est['grado'];
    }
    if (!empty($est['seccion']) && !in_array($est['seccion'], $secciones_unicas)) {
        $secciones_unicas[] = $est['seccion'];
    }
}
sort($grados_unicos);
sort($secciones_unicas);

// Si se seleccionó un estudiante, filtrar su historial
$estudiante_id = isset($_GET['estudiante_id']) ? (int)$_GET['estudiante_id'] : 0;
$historial_alumno = [];

if ($estudiante_id > 0) {
    $todas_asistencias = db_get_asistencias();
    foreach ($todas_asistencias as $a) {
        if ($a['tipo'] === 'alumno' && $a['ref_id'] == $estudiante_id) {
            $historial_alumno[] = $a;
        }
    }
    
    // Ordenar por fecha y hora descendente
    usort($historial_alumno, function($a, $b) {
        $datetimeA = strtotime($a['fecha'] . ' ' . ($a['hora'] ?? '00:00:00'));
        $datetimeB = strtotime($b['fecha'] . ' ' . ($b['hora'] ?? '00:00:00'));
        if ($datetimeA === $datetimeB) {
            return $b['id'] <=> $a['id'];
        }
        return $datetimeB <=> $datetimeA;
    });
}
?>

<main class="page-main-content">
    <div class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        
        <!-- Formulario de Selección -->
        <div class="attendance-card premium-filter-card" style="max-width: 850px; margin: 0 auto 3rem auto; padding: 3.5rem 3rem;">
            
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h1 style="color: var(--color-primary); font-size: 2.4rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -0.5px;">Consulta de Asistencia</h1>
                <p style="color: var(--color-secondary); font-size: 1.05rem;">Busca el nombre del alumno para ver su historial detallado de asistencia y participación.</p>
            </div>

            <form method="GET" action="asistencia_padres.php" class="form-group" style="display: flex; gap: 1.25rem; align-items: flex-end; margin-bottom: 0; flex-wrap: wrap; background: #ffffff; padding: 1.5rem; border-radius: 12px; border: 1px solid var(--color-border); box-shadow: 0 2px 10px rgba(0,0,0,0.02);">

                <!-- Búsqueda por Nombre -->
                <div class="filter-group" style="flex: 2; position: relative; min-width: 280px;">
                    <label for="estudiante_search" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; vertical-align: text-bottom;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        Buscar Alumno
                    </label>
                    <div style="position: relative;">
                        <input type="text" id="estudiante_search" class="premium-input search-input-icon" placeholder="Ej. Carlos Mendoza..." autocomplete="off">
                        <input type="hidden" name="estudiante_id" id="estudiante_id" value="<?php echo htmlspecialchars($estudiante_id > 0 ? (string)$estudiante_id : ''); ?>" required>
                    </div>
                    
                    <!-- Dropdown -->
                    <div id="estudiantes_dropdown" class="custom-dropdown" style="display: none;">
                        <?php foreach ($estudiantes as $est): ?>
                            <div class="dropdown-item" 
                                 data-id="<?php echo htmlspecialchars($est['id']); ?>" 
                                 data-name="<?php echo htmlspecialchars(strtolower($est['nombre'] . ' ' . $est['grado'])); ?>"
                                 data-grado="<?php echo htmlspecialchars($est['grado']); ?>"
                                 data-seccion="<?php echo htmlspecialchars($est['seccion'] ?? 'A'); ?>">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <strong><?php echo htmlspecialchars($est['nombre']); ?></strong>
                                    <span class="badge-status badge-Presente" style="font-size: 0.65rem; padding: 0.15rem 0.5rem; background: #f1f5f9; color: var(--color-gray);">
                                        <?php echo htmlspecialchars($est['grado'] . ' "' . ($est['seccion'] ?? 'A') . '")'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div id="no_results" class="dropdown-item" style="display: none; color: var(--color-gray); pointer-events: none; text-align: center; padding: 1rem;">
                            No se encontraron coincidencias.
                        </div>
                    </div>
                <!-- Selector de Grado -->
                <div class="filter-group" style="flex: 1; min-width: 120px;">
                    <label for="filtro_grado" class="form-label">Grado</label>
                    <div class="select-wrapper">
                        <select id="filtro_grado" class="premium-input select-icon">
                            <option value="">Todos</option>
                            <?php foreach ($grados_unicos as $g): ?>
                                <option value="<?php echo htmlspecialchars($g); ?>"><?php echo htmlspecialchars($g); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Selector de Sección -->
                <div class="filter-group" style="flex: 1; min-width: 120px;">
                    <label for="filtro_seccion" class="form-label">Sección</label>
                    <div class="select-wrapper">
                        <select id="filtro_seccion" class="premium-input select-icon">
                            <option value="">Todas</option>
                            <?php foreach ($secciones_unicas as $s): ?>
                                <option value="<?php echo htmlspecialchars($s); ?>"><?php echo htmlspecialchars($s); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <!-- Botón -->
                <div class="filter-group" style="flex: 0 0 auto;">
                    <button type="submit" id="submit_btn" class="btn btn-primary premium-btn" style="margin-bottom: 0;" <?php echo $estudiante_id > 0 ? '' : 'disabled'; ?>>
                        Consultar Asistencia
                    </button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('estudiante_search');
                const hiddenInput = document.getElementById('estudiante_id');
                const dropdown = document.getElementById('estudiantes_dropdown');
                const items = dropdown.querySelectorAll('.dropdown-item:not(#no_results)');
                const noResults = document.getElementById('no_results');
                const submitBtn = document.getElementById('submit_btn');
                const filtroGrado = document.getElementById('filtro_grado');
                const filtroSeccion = document.getElementById('filtro_seccion');
                
                // Pre-fill the search input if an ID is already selected
                const currentId = hiddenInput.value;
                if (currentId) {
                    const selectedItem = document.querySelector(`.dropdown-item[data-id="${currentId}"]`);
                    if (selectedItem) {
                        searchInput.value = selectedItem.querySelector('strong').innerText;
                    }
                }
                
                function checkFilters() {
                    if (filtroGrado.value !== '' && filtroSeccion.value !== '') {
                        searchInput.disabled = false;
                        searchInput.placeholder = "Ej. Carlos Mendoza...";
                    } else {
                        searchInput.disabled = true;
                        searchInput.placeholder = "Selecciona Grado y Sección...";
                        searchInput.value = '';
                        hiddenInput.value = '';
                        submitBtn.disabled = true;
                        dropdown.style.display = 'none';
                    }
                }
                
                // Inicializar estado de filtros
                checkFilters();

                function filterDropdown() {
                    const query = searchInput.value.toLowerCase().trim();
                    const gradoVal = filtroGrado.value;
                    const seccionVal = filtroSeccion.value;
                    let hasMatches = false;

                    const tableRows = document.querySelectorAll('.student-table-row');

                    items.forEach(item => {
                        const name = item.getAttribute('data-name');
                        const grado = item.getAttribute('data-grado');
                        const seccion = item.getAttribute('data-seccion');
                        
                        const matchesText = name.includes(query);
                        const matchesGrado = gradoVal === '' || grado === gradoVal;
                        const matchesSeccion = seccionVal === '' || seccion === seccionVal;

                        if (matchesText && matchesGrado && matchesSeccion) {
                            item.style.display = 'block';
                            hasMatches = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Update table rows if the table exists
                    if (tableRows.length > 0) {
                        let tableHasMatches = false;
                        tableRows.forEach(row => {
                            const name = row.getAttribute('data-name');
                            const grado = row.getAttribute('data-grado');
                            const seccion = row.getAttribute('data-seccion');
                            
                            const matchesText = name.includes(query);
                            const matchesGrado = gradoVal === '' || grado === gradoVal;
                            const matchesSeccion = seccionVal === '' || seccion === seccionVal;

                            if (matchesText && matchesGrado && matchesSeccion) {
                                row.style.display = '';
                                tableHasMatches = true;
                            } else {
                                row.style.display = 'none';
                            }
                        });
                        
                        const tableNoResults = document.getElementById('table_no_results');
                        if (tableNoResults) {
                            tableNoResults.style.display = tableHasMatches ? 'none' : 'block';
                        }
                    }

                    noResults.style.display = hasMatches ? 'none' : 'block';
                }

                // Show dropdown on focus
                searchInput.addEventListener('focus', function() {
                    dropdown.style.display = 'block';
                    filterDropdown();
                });

                // Filter on input changes
                searchInput.addEventListener('input', function() {
                    dropdown.style.display = 'block';
                    hiddenInput.value = ''; // Clear selected ID when typing
                    submitBtn.disabled = true;
                    filterDropdown();
                });
                
                filtroGrado.addEventListener('change', function() {
                    checkFilters();
                    if (!searchInput.disabled) {
                        dropdown.style.display = 'block';
                        filterDropdown();
                    }
                });

                filtroSeccion.addEventListener('change', function() {
                    checkFilters();
                    if (!searchInput.disabled) {
                        dropdown.style.display = 'block';
                        filterDropdown();
                    }
                });
                
                // Hide dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.style.display = 'none';
                        // Re-validate: if input text doesn't match a selected item, clear it
                        if (!hiddenInput.value) {
                            searchInput.value = '';
                        }
                    }
                });

                // Select item
                items.forEach(item => {
                    item.addEventListener('click', function() {
                        searchInput.value = this.querySelector('strong').innerText;
                        hiddenInput.value = this.getAttribute('data-id');
                        
                        dropdown.style.display = 'none';
                        submitBtn.disabled = false;
                    });
                });
            });
        </script>

        <!-- Resultados -->
        <?php if ($estudiante_id > 0): ?>
            <div class="attendance-card">
                <h3 style="margin-bottom: 1.5rem; color: var(--color-primary); border-bottom: 2px solid var(--color-border); padding-bottom: 0.5rem;">
                    Historial de <?php 
                        $nombre_est = "Estudiante no encontrado";
                        foreach ($estudiantes as $est) {
                            if ($est['id'] == $estudiante_id) {
                                $nombre_est = $est['nombre'];
                                break;
                            }
                        }
                        echo htmlspecialchars($nombre_est); 
                    ?>
                </h3>
                
                <?php if (empty($historial_alumno)): ?>
                    <div id="table_no_results" class="empty-state text-center" style="padding: 3rem;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-gray); margin-bottom: 1rem;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <p>No hay registros de asistencia para este estudiante.</p>
                    </div>
                <?php else: ?>
                    <!-- Added table_no_results div for JS logic when no rows match filter but some exist overall -->
                    <div id="table_no_results" class="empty-state text-center" style="padding: 3rem; display: none;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-gray); margin-bottom: 1rem;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <p>No se encontraron registros que coincidan con la búsqueda.</p>
                    </div>
                    <div style="overflow-x: auto;" id="table_container">
                        <table class="attendance-table custom-scroll">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora de Registro</th>
                                    <th>Grado/Sección</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historial_alumno as $reg): ?>
                                    <?php 
                                        $badgeClass = '';
                                        $estadoLabel = $reg['estado'];
                                        switch($reg['estado']) {
                                            case 'Presente': $badgeClass = 'badge-Presente'; break;
                                            case 'Ausente': $badgeClass = 'badge-Ausente'; break;
                                            case 'Llegada Tardía': $badgeClass = 'badge-Llegada-Tardia'; break;
                                            case 'Ausencia Justificada': $badgeClass = 'badge-Ausencia-Justificada'; break;
                                        }
                                    ?>
                                    <tr class="student-table-row" data-name="<?php echo htmlspecialchars(strtolower($nombre_est ?? '')); ?>" data-grado="<?php echo htmlspecialchars($reg['grado'] ?? ''); ?>" data-seccion="<?php echo htmlspecialchars($reg['seccion'] ?? ''); ?>">
                                        <td>
                                            <strong><?php echo date('d/m/Y', strtotime($reg['fecha'])); ?></strong>
                                        </td>
                                        <td>
                                            <?php 
                                                // Mostrar hora si existe, de lo contrario mostrar N/A o un guión
                                                echo isset($reg['hora']) ? date('H:i', strtotime($reg['hora'])) . ' hs' : '--:-- hs'; 
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($reg['grado'] ?? ''); ?>
                                        </td>
                                        <td>
                                            <span class="badge-status <?php echo $badgeClass; ?>">
                                                <?php echo htmlspecialchars($estadoLabel); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
    </div>
</main>

<style>
/* Títulos de Sección */
.page-main-content {
    background-color: var(--color-bg);
    min-height: 60vh;
}.attendance-card {
    background-color: #ffffff;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px var(--color-shadow);
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.attendance-table th {
    text-align: left;
    padding: 1rem;
    background-color: var(--color-light);
    color: var(--color-secondary);
    font-weight: 600;
    border-bottom: 2px solid var(--color-border);
}

.attendance-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--color-border);
    color: var(--color-text);
    vertical-align: middle;
}

.attendance-table tr:hover {
    background-color: rgba(248, 250, 252, 0.5);
}

.badge-status {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 0.6rem;
    border-radius: 50px;
    display: inline-block;
}
.badge-Presente { background-color: #e6f6ec; color: #17bb52; }
.badge-Ausente { background-color: #fce8e6; color: #e53e3e; }
.badge-Llegada-Tardia { background-color: #fffaf0; color: #dd6b20; }
.badge-Ausencia-Justificada { background-color: #ebf8ff; color: #3182ce; }

.premium-input {
    width: 100%;
    padding: 0.65rem 0.85rem;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    font-family: var(--font-sans);
    font-size: 0.95rem;
    transition: var(--transition-fast);
}
.premium-input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* Custom Scrollbar */
.custom-scroll::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.custom-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 8px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Premium Filter Aesthetics */
.premium-filter-card {
    background: linear-gradient(145deg, #ffffff, #f8fafc);
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    border-radius: 16px;
}

.filter-group .form-label {
    font-weight: 700;
    color: var(--color-secondary);
    display: flex;
    align-items: center;
    margin-bottom: 0.6rem;
    font-size: 0.9rem;
}

/* Custom Select Wrapper for elegant arrows */
.select-wrapper {
    position: relative;
}
.select-wrapper::after {
    content: "▼";
    font-size: 0.7rem;
    color: var(--color-primary);
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}
.select-icon {
    appearance: none;
    padding-right: 2.5rem;
    cursor: pointer;
    background-color: #ffffff;
}

/* Search input enhancement */
.search-input-icon {
    background-color: #ffffff;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
}

.premium-btn {
    padding: 0.75rem 1.75rem;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
    transition: all 0.3s ease;
}
.premium-btn:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
}
.premium-btn:disabled {
    background-color: #cbd5e1;
    border-color: #cbd5e1;
    box-shadow: none;
    transform: none;
    cursor: not-allowed;
}

/* Custom Dropdown Styles */
.custom-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: white;
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    z-index: 1000;
    padding: 0.5rem;
    animation: fadeInDown 0.2s ease-out;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.dropdown-item {
    padding: 0.85rem 1rem;
    cursor: pointer;
    border-radius: 8px;
    margin-bottom: 2px;
    transition: all 0.2s ease;
}
.dropdown-item:last-child {
    margin-bottom: 0;
}
.dropdown-item:hover {
    background: #f1f5f9;
    padding-left: 1.25rem;
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
