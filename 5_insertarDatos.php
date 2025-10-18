<?php
require_once("2_conexion.php");
require_once("includes.php");

// Insertar tareas de ejemplo
    $insert1 = "INSERT INTO tareas (titulo, descripcion, fecha_caducidad, completada)
        VALUES ('Estudiar PHP', 'Repasar temas de PHP para FP DAW', '2025-10-20', true)";
    $insert2 = "INSERT INTO tareas (titulo, descripcion, fecha_caducidad, completada)
        VALUES ('Comprar pan', 'Ir a la panadería a comprar pan fresco', '2025-10-16', false)";
    $insert3 = "INSERT INTO tareas (titulo, descripcion, fecha_caducidad, completada)
        VALUES ('Preparar entrega DAW', 'Terminar proyecto y subirlo al servidor', '2025-10-25', false)";
    $insert4 = "INSERT INTO tareas (titulo, descripcion, fecha_caducidad, completada)
        VALUES ('Preparar entrega C#', 'Terminar proyecto y subirlo al servidor', '2025-11-25', true)";
?>