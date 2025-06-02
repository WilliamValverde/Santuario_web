CREATE DATABASE santuario_web;
USE santuario_web;

-- Comentarios de "Comenta tu visita"
CREATE TABLE comentarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  apellido VARCHAR(100),
  email VARCHAR(100),
  pais VARCHAR(100),
  comentario TEXT,
  estado ENUM('en_espera', 'aprobado', 'rechazado') DEFAULT 'en_espera',
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Eventos del administrador
CREATE TABLE eventos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255),
  descripcion TEXT,
  fecha_evento DATE,
  imagen VARCHAR(255),
  fecha_creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contactos de turistas
CREATE TABLE contactos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  apellido VARCHAR(100),
  email VARCHAR(100),
  fecha_visita DATE,
  mensaje TEXT,
  respondido BOOLEAN DEFAULT FALSE
);

-- Administradores
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);
