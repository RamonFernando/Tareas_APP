<?php
    require_once("includes.php");

    // Create
    function createTask($titulo,$descripcion, $fecha_caducidad): bool|mysqli_result{
        
        global $conn;
        
        // 1. Preparamos la consulta para evitar inyeccion de codigo en la BD.
        $sql = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_caducidad) values (?, ?, ?)");
        
        // 2. Enlazamos los parámetros ("sss" = string, string, string), si fuera un entero "i" = integer
        $sql->bind_param("sss", $titulo, $descripcion, $fecha_caducidad);
        
        echo "🆕  Nueva Tarea: \n";
        echo "Título: ";
        $titulo = trim(fgets(STDIN));

        echo "Descripción: ";
        $descripcion = trim(fgets(STDIN));

        echo "Fecha (YYYY-MM-DD): ";
        $fecha_caducidad = trim(fgets(STDIN));

        $result = $sql->execute();
        echo $result
                ? "✅  Tarea creada correctamente.\n"
                : "❌  ERROR: no se pudo crear la tarea.\n";
        $sql->close();
        return $result;
    }

?>