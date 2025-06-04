CREATE DATABASE IF NOT EXISTS sistema_alimentos;
USE sistema_alimentos;

CREATE TABLE IF NOT EXISTS alimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    categoria ENUM('comida', 'bebida', 'objeto') NOT NULL,
    estado ENUM('disponible', 'faltante') DEFAULT 'disponible',
    fecha_inventario DATE NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);