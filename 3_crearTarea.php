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
     * @param mixed $completada
     * @return bool
     * retorno: Parámetros: $titulo, $descripcion, $fecha_caducidad
     * Devuelve true si la tarea se crea correctamente, false en caso contrario
     */
    function createTask($titulo,$descripcion, $fecha_caducidad, $completada): bool|mysqli_result{
        
        global $conn;
        
        // 1. Preparamos la consulta para evitar inyeccion de codigo en la BD.
        $sql = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_caducidad, completada) values (?, ?, ?, ?)");
        
        // 2. Enlazamos los parámetros ("sss" = string, string, string), si fuera un entero "i" = integer
        $sql->bind_param("sssi", $titulo, $descripcion, $fecha_caducidad, $completada);
        
        // 3. Ejecutamos la consulta y comprobamos que no existe en la BD
        $result = $conn->query("SELECT * FROM tareas WHERE titulo = '$titulo' and fecha_caducidad = '$fecha_caducidad'");
        
        // 4. Comprobamos si la tarea ya existe
        if($result->num_rows > 0){
            echo "❌  ERROR: La tarea ya existe en la base de datos.\n";
            $sql->close();
            return false;
        }
        
        $result = $sql->execute();
        echo $result
                ? "✅  Tarea creada correctamente.\n"
                : "❌  ERROR: no se pudo crear la tarea.\n";
        $sql->close();
        return $result;
    }

?>