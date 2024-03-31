CREATE DATABASE IF NOT EXISTS talenthub;

USE talenthub;

-- Tabla roles
CREATE TABLE roles (
    id_rol INT PRIMARY KEY,
    descripcion VARCHAR(255)
);

-- Tabla empleados
CREATE TABLE empleados (
    matricula_empleado INT PRIMARY KEY,
    contraseña VARCHAR(255),
    email VARCHAR(255),
    nombre VARCHAR(255),
    apellidos VARCHAR(255),
    imagen VARCHAR(255),
    id_rol INT,
    edad INT,
    fecha_inicio DATE,
    antiguedad INT,
    sueldo DECIMAL(10, 2),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);
