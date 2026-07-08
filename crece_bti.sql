-- SCHEMA DE BASE DE DATOS: crece_bti
-- Proyecto Integrador - 3° BTI CRECE
-- Guarda este archivo e impórtalo en phpMyAdmin o MySQL Workbench.

CREATE DATABASE IF NOT EXISTS crece_bti CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crece_bti;

-- 1. CREACIÓN DE TABLAS

-- Tabla de Grados
CREATE TABLE IF NOT EXISTS grados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Tabla de Estudiantes
CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    grado_id INT,
    seccion VARCHAR(5) DEFAULT 'A',
    FOREIGN KEY (grado_id) REFERENCES grados(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de Profesores / Docentes
CREATE TABLE IF NOT EXISTS profesores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    materia VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabla de Asistencias (Integrada para Alumnos y Docentes)
CREATE TABLE IF NOT EXISTS asistencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('alumno', 'profesor') NOT NULL,
    estudiante_id INT NULL,
    profesor_id INT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL DEFAULT '07:00:00',
    estado ENUM('Presente', 'Ausente', 'Llegada Tardía', 'Ausencia Justificada') NOT NULL,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (profesor_id) REFERENCES profesores(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de Mensajes de Contacto
CREATE TABLE IF NOT EXISTS mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    asunto VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. INSERCIÓN DE DATOS DE PRUEBA INICIALES

INSERT INTO grados (id, nombre) VALUES 
(1, '5to Grado'), 
(2, '6to Grado')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);



INSERT INTO profesores (id, nombre, materia) VALUES 
(1, 'Prof. Lic. Carlos Ferreira', 'Programación Web'), 
(2, 'Prof. Ing. Andrea Espínola', 'Bases de Datos'), 
(3, 'Prof. Lic. Mabel Rojas', 'Análisis y Diseño'), 
(4, 'Prof. Ing. Gustavo Galeano', 'Redes de Computadoras')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), materia=VALUES(materia);



-- Tabla de Seguimiento (Observaciones y Progreso)
CREATE TABLE IF NOT EXISTS seguimiento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    fecha DATE NOT NULL,
    observacion TEXT NOT NULL,
    progreso VARCHAR(50) NOT NULL,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de Galerias
CREATE TABLE IF NOT EXISTS galerias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    categoriaLabel VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL
) ENGINE=InnoDB;

-- Datos de prueba para Seguimiento
INSERT INTO seguimiento (id, estudiante_id, fecha, observacion, progreso) VALUES 
(1, 1, '2026-06-18', 'Excelente participación en clase de Programación Web.', 'Avanzado'),
(2, 2, '2026-06-18', 'Necesita reforzar conceptos de Bases de Datos.', 'En Proceso')
ON DUPLICATE KEY UPDATE observacion=VALUES(observacion), progreso=VALUES(progreso);

-- Tabla de Experiencias / Testimonios
CREATE TABLE IF NOT EXISTS experiencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(100) NOT NULL,
    comentario TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Datos de prueba para Experiencias
INSERT INTO experiencias (id, nombre, rol, comentario) VALUES 
(1, 'Arnaldo Romero', 'Alumno del 3° BTI', 'Enseñar programación con Scratch a los alumnos del 5° y 6° grado fue una experiencia única que impulsó nuestro crecimiento académico y personal. Al principio era un reto mantener su atención, pero ver cómo aprendían jugando nos ayudó a desarrollar una gran paciencia y confianza.'),
(2, 'Mathias Galeano', 'Alumno del 3° BTI', 'Esta iniciativa nos exigió asumir una gran responsabilidad. Tuvimos que coordinar la preparación de los materiales de clase y guiar de forma colaborativa a los chicos en la lógica de creación de sus propios videojuegos, lo que reforzó nuestros propios conocimientos.'),
(3, 'Joseph Fretez', 'Alumno del 3° BTI', 'Aunque nos enfrentamos a desafíos reales en el aula, como fallas técnicas en las computadoras y problemas de conexión a internet, pudimos salir adelante trabajando en equipo con docentes y compañeros. Fue sumamente gratificante ver el resultado final.')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), rol=VALUES(rol), comentario=VALUES(comentario);
