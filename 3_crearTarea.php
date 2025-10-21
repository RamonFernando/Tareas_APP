<?php
    require_once("includes.php");

    // Create
    /**
     * Summary of createTask
     * crear una nueva tarea
     * @global $conn
     * @param mixed $titulo
     * @param mixed $descripcion
     * @param mixed $fecha_caducidad
     * @return bool
     * retorno: Parámetros: $titulo, $descripcion, $fecha_caducidad
     * Devuelve true si la tarea se crea correctamente, false en caso contrario
     */
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