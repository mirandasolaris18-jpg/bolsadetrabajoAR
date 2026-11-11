-- Base de Datos: bolsa_gador

CREATE DATABASE IF NOT EXISTS bolsa_gador CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bolsa_gador;

-- Tabla: usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'administrador') DEFAULT 'usuario',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: ofertas_laborales
CREATE TABLE IF NOT EXISTS ofertas_laborales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    ciudad VARCHAR(100) DEFAULT 'Oruro',
    modalidad ENUM('presencial', 'remoto', 'mixto') DEFAULT 'presencial',
    salario DECIMAL(10, 2) NULL,
    estado ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: postulaciones
CREATE TABLE IF NOT EXISTS postulaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    oferta_id INT NOT NULL,
    usuario_id INT NOT NULL,
    archivo_cv VARCHAR(255) NULL,
    comentario TEXT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (oferta_id) REFERENCES ofertas_laborales(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar administrador inicial (contraseña: admin123)
INSERT INTO usuarios (nombre, correo, clave, rol) VALUES 
('Administrador GADOR', 'admin@gador.gob.bo', '$2y$10$e7W5vE994n.Jc3QZ5U5X8.x3E7W.w7aQ5kY7r9N.U.X8m/0J5h.6O', 'administrador')
ON DUPLICATE KEY UPDATE id=id;
