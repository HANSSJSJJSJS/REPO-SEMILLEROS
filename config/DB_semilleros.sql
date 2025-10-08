-- Crear base de datos
CREATE DATABASE IF NOT EXISTS proyecto_semi;
USE proyecto_semi;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('ADMIN','LIDER','APRENDIZ') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

-- Tabla Semilleros
CREATE TABLE Semilleros (
    semillero_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lider_id INT,
    FOREIGN KEY (lider_id) REFERENCES Usuarios(usuario_id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla Proyectos
CREATE TABLE Proyectos (
    proyecto_id INT AUTO_INCREMENT PRIMARY KEY,
    semillero_id INT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('EN EJECUCIÓN','FINALIZADO','PENDIENTE') DEFAULT 'PENDIENTE',
    FOREIGN KEY (semillero_id) REFERENCES Semilleros(semillero_id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla Documentos
CREATE TABLE Documentos (
    documento_id INT AUTO_INCREMENT PRIMARY KEY,
    proyecto_id INT,
    tipo_documento ENUM('INFORME','PRESENTACION','REPORTE') NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    archivo_pdf LONGBLOB,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES Proyectos(proyecto_id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- Fin del script
USE proyecto_semi;

-- Insertar usuarios de prueba para cada rol
-- Todas las contraseñas son: Admin123

-- Usuario ADMIN
INSERT INTO Usuarios (nombre, email, contraseña, rol, activo) VALUES 
('Administrador Principal', 'admin@proyecto.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN', 1);

-- Usuario LIDER
INSERT INTO Usuarios (nombre, email, contraseña, rol, activo) VALUES 
('Juan Pérez - Líder', 'lider@proyecto.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'LIDER', 1);

-- Usuario APRENDIZ
INSERT INTO Usuarios (nombre, email, contraseña, rol, activo) VALUES 
('María González - Aprendiz', 'aprendiz@proyecto.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'APRENDIZ', 1);

-- Insertar un semillero de ejemplo (opcional)
INSERT INTO Semilleros (nombre, descripcion, lider_id) VALUES 
('Semillero de Innovación', 'Semillero dedicado a proyectos de innovación tecnológica', 2);

-- Insertar un proyecto de ejemplo (opcional)
INSERT INTO Proyectos (semillero_id, nombre, descripcion, fecha_inicio, estado) VALUES 
(1, 'Sistema de Gestión', 'Desarrollo de sistema de gestión para semilleros', CURDATE(), 'EN EJECUCIÓN');

-- Nota: Todas las contraseñas están encriptadas con password_hash()
-- Contraseña de prueba para todos los usuarios: Admin123