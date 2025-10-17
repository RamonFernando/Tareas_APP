Pasos que sigo para la creacion del proyecto.
1 Crear la Base de datos tareas_db
- CREATE DATABASE tareas_db;
USE tareas_db;

CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    fecha_caducidad DATE,
    completada BOOLEAN DEFAULT FALSE
);
