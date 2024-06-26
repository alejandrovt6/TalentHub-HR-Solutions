CREATE DATABASE IF NOT EXISTS talenthub;

USE talenthub;

-- Tabla roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(255)
);

-- Tabla empleados
CREATE TABLE empleados (
    DNI VARCHAR(11) PRIMARY KEY,
    contraseña VARCHAR(255),
    email VARCHAR(255),
    nombre VARCHAR(255),
    apellidos VARCHAR(255),
    imagen VARCHAR(255),
    id_rol INT,
    fecha_nacimiento DATE,
    fecha_inicio DATE,
    sueldo DECIMAL(10, 2),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);
