<?php
/**
 * Página: Gestión de Asistencias (Alumnos y Profesores)
 * Proyecto Integrador - 3° BTI CRECE
 */
session_start();
if (!isset($_SESSION["bti_admin"]) || $_SESSION["bti_admin"] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php';

$successMsg = "";

// Extraer mensaje flash si existe
if (isset($_SESSION['flash_msg'])) {
    $successMsg = $_SESSION['flash_msg'];
    unset($_SESSION['flash_msg']);
}

// Procesar POSTs (Patrón Post/Redirect/Get)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'registrar_estudiante') {
            $nombre = trim($_POST['nombre']);
            $grado = $_POST['grado'] ?? '';
            $seccion = $_POST['seccion'] ?? 'A';
            if (!empty($nombre)) {
                db_add_estudiante($nombre, $grado, $seccion);
                $_SESSION['flash_msg'] = "Alumno registrado con éxito.";
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
        }
        
        elseif ($action === 'registrar_profesor') {
            $nombre = trim($_POST['nombre']);
            $materia = trim($_POST['materia']);
            if (!empty($nombre) && !empty($materia)) {
                db_add_profesor($nombre, $materia);
                $_SESSION['flash_msg'] = "Profesor registrado con éxito.";
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
        }
        
        elseif ($action === 'guardar_asistencia') {
            $tipo = $_POST['tipo'];
            $fecha = $_POST['fecha'];
            $asistencias = $_POST['asistencia'] ?? [];
            $trabajo = $_POST['trabajo'] ?? [];
            db_save_asistencias($tipo, $fecha, $asistencias, $trabajo);
            $_SESSION['flash_msg'] = "Asistencia guardada correctamente.";
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}

$estudiantes_list_php = db_get_estudiantes();
$grados_unicos = [];
$secciones_unicas = ['A', 'B', 'C', 'D'];
foreach ($estudiantes_list_php as $est) {
    if (!empty($est['grado']) && !in_array($est['grado'], $grados_unicos)) {
        $grados_unicos[] = $est['grado'];
    }
    if (!empty($est['seccion']) && !in_array($est['seccion'], $secciones_unicas)) {
        $secciones_unicas[] = $est['seccion'];
    }
}
sort($grados_unicos);
sort($secciones_unicas);
// Fallback
if (empty($grados_unicos)) $grados_unicos = ['5to', '6to'];

$pageTitle = "Registro de Asistencia";
require_once __DIR__ . '/includes/header.php';
?><style>
/* Estilos adicionales premium para la sección de asistencia */
.attendance-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

@media (max-width: 992px) {
    .attendance-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    /* Responsive Table para Móviles */
    .attendance-table, .attendance-table tbody, .attendance-table tr, .attendance-table td {
        display: block;
        width: 100%;
    }
    .attendance-table thead {
        display: none; /* Ocultamos los títulos de columna porque el formato cambia a tarjetas */
    }
    .attendance-table tr {
        margin-bottom: 1.25rem;
        border: 1px solid var(--color-border);
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        background-color: #ffffff;
    }
    .attendance-table td {
        border: none;
        padding: 0;
    }
    .status-group {
        display: grid !important;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    .status-label {
        width: 100%;
        padding: 0.7rem 0.25rem;
        font-size: 0.75rem;
        box-sizing: border-box;
    }
    
    .list-container {
        border: none !important;
        border-radius: 0;
    }
}

/* Contenedor de lista y Scrollbar personalizado */
.list-container {
    border: 1px solid var(--color-border);
    border-radius: 8px;
}

.custom-scroll::-webkit-scrollbar {
    width: 6px;
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

.attendance-card {
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
    padding: 0.75rem 1rem;
    background-color: #f7fafc;
    color: var(--color-secondary);
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--color-border);
}

.attendance-table td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--color-border);
    vertical-align: middle;
}

.attendance-row:hover {
    background-color: #fafbfd;
}

/* Radio buttons convertidos en botones de píldora premium sin envoltura */
.status-group {
    display: flex;
    flex-wrap: wrap; /* Permitimos wrap para pantallas pequeñas */
    gap: 0.35rem;
}

.status-label {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.35rem 0.6rem;
    border-radius: 50px;
    border: 1px solid var(--color-border);
    cursor: pointer;
    transition: var(--transition-fast);
    user-select: none;
    text-align: center;
    white-space: nowrap;
    display: inline-block;
}

.status-label:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
    background-color: var(--color-primary-light);
}

.status-radio {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

/* Colores y estilos al estar activo */
/* Presente: Verde */
.status-radio[value="Presente"]:checked + .status-label {
    background-color: #e6f6ec;
    color: #17bb52;
    border-color: #17bb52;
    box-shadow: 0 2px 6px rgba(23, 187, 82, 0.15);
}
/* Ausente: Rojo */
.status-radio[value="Ausente"]:checked + .status-label {
    background-color: #fce8e6;
    color: #e53e3e;
    border-color: #e53e3e;
    box-shadow: 0 2px 6px rgba(229, 62, 62, 0.15);
}
/* Llegada Tardía: Naranja */
.status-radio[value="Llegada Tardía"]:checked + .status-label {
    background-color: #fffaf0;
    color: #dd6b20;
    border-color: #dd6b20;
    box-shadow: 0 2px 6px rgba(221, 107, 32, 0.15);
}
/* Ausencia Justificada: Azul */
.status-radio[value="Ausencia Justificada"]:checked + .status-label {
    background-color: #ebf8ff;
    color: #3182ce;
    border-color: #3182ce;
    box-shadow: 0 2px 6px rgba(49, 130, 206, 0.15);
}

/* Formulario flotante tabulado con indicador estilo Aranduka */
.admin-tabs {
    display: flex;
    border-bottom: 2px solid var(--color-border);
    margin-bottom: 1.5rem;
}

.admin-tab-btn {
    flex: 1;
    padding: 0.75rem;
    text-align: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--color-secondary);
    background: none;
    border: none;
    cursor: pointer;
    transition: var(--transition-fast);
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    position: relative;
}

.admin-tab-btn::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: var(--color-primary);
    transition: var(--transition-fast);
    transform: translateX(-50%);
}

.admin-tab-btn.active::after {
    width: 80%;
}

.admin-tab-btn.active {
    color: var(--color-primary);
}

/* Badges de historial */
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
    font-size: 0.9rem;
    outline: none;
    transition: var(--transition-fast);
    background-color: #ffffff;
}
.premium-input:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(115, 0, 20, 0.08);
}

/* Selector Premium */
.premium-select {
    padding: 0.45rem 1.8rem 0.45rem 0.8rem;
    border-radius: 6px;
    border: 1px solid var(--color-border);
    outline: none;
    font-size: 0.88rem;
    color: var(--color-secondary);
    background-color: #ffffff;
    cursor: pointer;
    font-family: var(--font-sans);
    transition: var(--transition-fast);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg fill='%234a5568' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 1.25rem;
}
.premium-select:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(115, 0, 20, 0.08);
}
</style>

<main class="main-content">

    <!-- Botón Volver -->
    <div style="margin-bottom: 1.5rem;">
        <a href="panel_bti.php" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; background-color: #f1f5f9; color: var(--color-secondary); border-color: #e2e8f0; border-radius: 8px; width: fit-content;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Volver al Panel
        </a>
    </div>

    <!-- Encabezado de la Sección -->
    <div class="section-header">
        <h1 class="section-title" id="attendance-main-title">Registro de Asistencia</h1>
        <p class="section-description">Control de presencia diario de alumnos y docentes del BTI.</p>
    </div>

    <!-- Mensajes de éxito -->
    <?php if (!empty($successMsg)): ?>
        <div style="background-color: #e6f6ec; border: 1px solid #17bb52; color: #17bb52; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;" id="success-banner">
            ✓ <?php echo htmlspecialchars($successMsg); ?>
        </div>
        <script>
            setTimeout(() => {
                const banner = document.getElementById('success-banner');
                if (banner) banner.style.display = 'none';
            }, 4000);
        </script>
    <?php endif; ?>

    <?php
    $grado_seleccionado = $_GET['grado'] ?? null;
    $seccion_seleccionada = $_GET['seccion'] ?? null;
    $tipo_vista = $_GET['tipo'] ?? null;
    $es_profesor = ($tipo_vista === 'profesores');
    ?>

    <?php if (!$es_profesor): ?>
        <h2 style="color: var(--color-primary); margin-bottom: 1.5rem; font-size: 2.5rem; font-weight: 900; text-align: center; text-transform: uppercase; letter-spacing: 1px; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">Asistencia de Alumnos</h2>
    <?php else: ?>
        <div style="margin-bottom: 1.5rem;">
            <h2 style="color: var(--color-primary);">Asistencia de Docentes</h2>
            <div style="margin-top: 1rem;">
                <a href="asistencia.php" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.2rem; font-size: 0.9rem; border-radius: 6px; background-color: var(--color-primary); color: white; text-decoration: none; font-weight: 600; box-shadow: 0 4px 10px rgba(115,0,20,0.2); transition: transform 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Cambiar a Alumnos
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="attendance-grid">
            
            <!-- REGISTRO DE ASISTENCIA DIARIA -->
            <section class="attendance-card">
                <h2 style="color: var(--color-primary); font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; text-align: center;">Registro de Asistencia Diaria</h2>
                
                <form action="asistencia.php" method="POST" id="form-asistencia">
                    <input type="hidden" name="action" value="guardar_asistencia">
                    
                    <input type="hidden" id="reg-tipo" name="tipo" value="<?php echo $es_profesor ? 'profesor' : 'alumno'; ?>">
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; align-items: center; justify-content: center; background-color: #f8fafc; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--color-border); font-size: 0.85rem;">
                        <span style="font-weight: 600; color: var(--color-secondary); margin-right: 0.5rem;">Filtros:</span>
                        <!-- Selector de Fecha -->
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span class="filter-label" style="font-size: 0.75rem;">Fecha:</span>
                            <input type="date" name="fecha" id="reg-fecha" class="premium-input" style="padding: 0.25rem 0.5rem; width: auto; font-size: 0.8rem;" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <?php if (!$es_profesor): ?>
                            <!-- Selector de Grado -->
                            <div style="display: flex; align-items: center; gap: 0.5rem;" id="reg-grado-wrapper">
                                <span class="filter-label" style="font-size: 0.75rem;">Grado:</span>
                                <select id="reg-grado" name="grado_filtro" class="premium-input premium-select" style="padding: 0.25rem 1.5rem 0.25rem 0.5rem; width: auto; font-size: 0.8rem; background-size: 1rem;" required>
                                    <?php foreach ($grados_unicos as $g): ?>
                                        <option value="<?php echo htmlspecialchars($g); ?>"><?php echo htmlspecialchars($g); ?> Grado</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Selector de Sección -->
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span class="filter-label" style="font-size: 0.75rem;">Sección:</span>
                                <select id="reg-seccion" name="seccion_filtro" class="premium-input premium-select" style="padding: 0.25rem 1.5rem 0.25rem 0.5rem; width: auto; font-size: 0.8rem; background-size: 1rem;" required>
                                    <?php foreach ($secciones_unicas as $s): ?>
                                        <option value="<?php echo htmlspecialchars($s); ?>" <?php echo $s === 'A' ? 'selected' : ''; ?>>Sección <?php echo htmlspecialchars($s); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="color: var(--color-primary); font-size: 1.1rem; margin: 0; font-weight: 700;">Lista del Curso</h3>
                        <?php if (!$es_profesor): ?>
                        <button type="button" id="btn-exportar-excel" class="btn btn-secondary" style="width: auto; padding: 0.5rem 1rem; background-color: #17bb52; color: white; border: none; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; border-radius: 6px; font-size: 0.85rem; box-shadow: 0 2px 8px rgba(23,187,82,0.2); cursor: pointer; transition: transform 0.2s;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            Exportar Excel
                        </button>
                        <?php endif; ?>
                    </div>

                    <!-- Lista de Personas -->
                    <div class="list-container" style="padding-right: 4px;">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th style="width: 350px;">Asistencia</th>
                                </tr>
                            </thead>
                            <tbody id="lista-personas">
                                <!-- Se carga dinámicamente con JS -->
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 1.5rem; text-align: right;">
                        <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.75rem 2rem;">
                            ✓ Guardar Asistencia
                        </button>
                    </div>
                </form>
            </section>

            <!-- AGREGAR NUEVOS ALUMNOS / PROFESORES -->
            <aside class="attendance-card" style="align-self: start;">
                <div class="admin-tabs">
                    <?php if ($es_profesor): ?>
                        <button class="admin-tab-btn active" id="tab-profesores">Nuevo Docente</button>
                    <?php else: ?>
                        <button class="admin-tab-btn active" id="tab-alumnos">Nuevo Alumno</button>
                    <?php endif; ?>
                </div>

                <?php if ($es_profesor): ?>
                    <!-- Formulario Profesor -->
                    <div id="form-profesor-container">
                        <form action="asistencia.php?tipo=profesores" method="POST">
                            <input type="hidden" name="action" value="registrar_profesor">
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div>
                                    <label class="filter-label" style="margin-bottom: 0.4rem; display: block;">Nombre Completo del Docente:</label>
                                    <input type="text" name="nombre" class="premium-input" placeholder="Ej. Prof. Hugo Rojas" required>
                                </div>
                                <div>
                                    <label class="filter-label" style="margin-bottom: 0.4rem; display: block;">Asignatura / Materia:</label>
                                    <input type="text" name="materia" class="premium-input" placeholder="Ej. Programación Móvil" required>
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem;">
                                    Registrar Docente
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <!-- Formulario Estudiante -->
                    <div id="form-estudiante-container">
                        <form action="asistencia.php" method="POST">
                            <input type="hidden" name="action" value="registrar_estudiante">
                            <input type="hidden" id="new-estudiante-grado" name="grado" value="5to">
                            <input type="hidden" id="new-estudiante-seccion" name="seccion" value="B">
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div>
                                    <label class="filter-label" style="margin-bottom: 0.4rem; display: block;">Nombre Completo del Alumno:</label>
                                    <input type="text" name="nombre" class="premium-input" placeholder="Ej. Juan Pérez" required>
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem;">
                                    Registrar Alumno en esta aula
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </aside>

        </div>




</main>

<script>
// Base de datos inyectada desde PHP (via abstraction functions)
const db = <?php
    $db_js = [
        'estudiantes' => db_get_estudiantes(),
        'profesores'  => db_get_profesores(),
        'asistencias' => db_get_asistencias()
    ];
    echo json_encode($db_js, JSON_UNESCAPED_UNICODE);
?>;

document.addEventListener('DOMContentLoaded', () => {
    // Referencias DOM
    const regTipo = document.getElementById('reg-tipo');
    const regGrado = document.getElementById('reg-grado');
    const regGradoWrapper = document.getElementById('reg-grado-wrapper');
    const regFecha = document.getElementById('reg-fecha');
    const listaPersonas = document.getElementById('lista-personas');

    // Cargar alumnos o profesores según selecciones del formulario
    function renderListaRegistro() {
        const tipo = regTipo ? regTipo.value : 'alumno';
        const grado = regGrado ? regGrado.value : null;
        const regSeccion = document.getElementById('reg-seccion');
        const seccion = regSeccion ? regSeccion.value : null;
        const regFecha = document.getElementById('reg-fecha');
        const fecha = regFecha ? regFecha.value : new Date().toISOString().split('T')[0];
        
        if (!listaPersonas) return;
        listaPersonas.innerHTML = '';
        
        // Obtener asistencias existentes para esta fecha y tipo
        const asistenciasExistentes = db.asistencias.filter(a => a.tipo === tipo && a.fecha === fecha);
        
        // Update hidden inputs for new student form
        const newEstGrado = document.getElementById('new-estudiante-grado');
        const newEstSeccion = document.getElementById('new-estudiante-seccion');
        if (newEstGrado) newEstGrado.value = grado;
        if (newEstSeccion) newEstSeccion.value = seccion;
        
        let lista = [];
        if (tipo === 'alumno') {
            if (regGradoWrapper) regGradoWrapper.style.display = 'flex';
            lista = db.estudiantes.filter(e => {
                let matchGrado = grado ? e.grado === grado : true;
                let estSeccion = e.seccion || 'A';
                let matchSeccion = seccion ? estSeccion === seccion : true;
                return matchGrado && matchSeccion;
            });
        } else {
            if (regGradoWrapper) regGradoWrapper.style.display = 'none';
            lista = db.profesores;
        }

        if (lista.length === 0) {
            listaPersonas.innerHTML = `<tr><td colspan="2" style="text-align: center; color: var(--color-secondary); padding: 2rem;">No hay registros cargados.</td></tr>`;
            return;
        }

        lista.forEach(persona => {
            // Buscar si ya tiene asistencia registrada para este día
            const registro = asistenciasExistentes.find(a => a.ref_id === persona.id);
            const estadoActivo = registro ? registro.estado : 'Presente'; // Por defecto Presente
            const trabajoActivo = registro ? registro.trabajo_clase : false;
            const seccionTexto = tipo === 'alumno' ? (' - Secc. ' + (persona.seccion || 'A')) : '';

            const tr = document.createElement('tr');
            tr.className = 'attendance-row';
            
            tr.innerHTML = `
                <td>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--color-primary-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                            ${persona.nombre.charAt(0)}
                        </div>
                        <div>
                            <strong style="color: var(--color-text); font-size: 0.95rem;">${persona.nombre}</strong>
                            <span style="display: block; font-size: 0.78rem; color: var(--color-secondary);">
                                ${tipo === 'alumno' ? (persona.grado + ' Grado' + seccionTexto) : persona.materia}
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="status-group">
                        <label>
                            <input type="radio" name="asistencia[${persona.id}]" value="Presente" class="status-radio" ${estadoActivo === 'Presente' ? 'checked' : ''}>
                            <span class="status-label">Presente</span>
                        </label>
                        <label>
                            <input type="radio" name="asistencia[${persona.id}]" value="Ausente" class="status-radio" ${estadoActivo === 'Ausente' ? 'checked' : ''}>
                            <span class="status-label">Ausente</span>
                        </label>
                    </div>
                    ${tipo === 'alumno' ? `
                    <div style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px dashed var(--color-border); display: flex; align-items: center; justify-content: center;">
                        <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.75rem; font-weight: 600; color: var(--color-text); cursor: pointer;">
                            <input type="checkbox" name="trabajo[${persona.id}]" value="1" style="accent-color: var(--color-primary); width: 14px; height: 14px;" ${trabajoActivo ? 'checked' : ''}>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary);"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            Trabajó en clase
                        </label>
                    </div>` : ''}
                </td>
            `;
            listaPersonas.appendChild(tr);
        });
    }

    // Listeners de cambios
    if (regTipo) regTipo.addEventListener('change', renderListaRegistro);
    if (regGrado) regGrado.addEventListener('change', renderListaRegistro);
    if (regFecha) regFecha.addEventListener('change', renderListaRegistro);

    // Cargas iniciales
    renderListaRegistro();

    // Re-render when filters change
    if (regGrado) regGrado.addEventListener('change', renderListaRegistro);
    const regSeccion = document.getElementById('reg-seccion');
    if (regSeccion) regSeccion.addEventListener('change', renderListaRegistro);
    if (regFecha) regFecha.addEventListener('change', renderListaRegistro);

    // Exportar a Excel
    const btnExportar = document.getElementById('btn-exportar-excel');
    if (btnExportar) {
        btnExportar.addEventListener('click', function() {
            const fecha = document.getElementById('reg-fecha')?.value || '';
            const grado = document.getElementById('reg-grado')?.value || '';
            const seccion = document.getElementById('reg-seccion')?.value || '';
            window.open(`exportar_excel.php?fecha=${fecha}&grado=${grado}&seccion=${seccion}`, '_blank');
        });
    }
});

// Cambiar de Pestaña para carga
function switchTab(tipo) {
    const tabAlumnos = document.getElementById('tab-alumnos');
    const tabProfesores = document.getElementById('tab-profesores');
    const formEstudiante = document.getElementById('form-estudiante-container');
    const formProfesor = document.getElementById('form-profesor-container');

    if (tipo === 'alumno') {
        tabAlumnos.classList.add('active');
        tabProfesores.classList.remove('active');
        formEstudiante.style.display = 'block';
        formProfesor.style.display = 'none';
    } else {
        tabAlumnos.classList.remove('active');
        tabProfesores.classList.add('active');
        formEstudiante.style.display = 'none';
        formProfesor.style.display = 'block';
    }
}
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
