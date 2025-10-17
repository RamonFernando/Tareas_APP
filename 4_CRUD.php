<?php
    require_once("2_conexion.php");

    // Create
    function createTask($titulo,$descripcion, $fecha_caducidad): bool|mysqli_result{
        
        // Realizamos la conexion a la BD
        global $conn;

        // 1. Preparamos la consulta para evitar inyeccion de codigo en la BD
        $sql = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_caducidad) values (?, ?, ?)");
        
        // 2. Enlazamos los parámetros ("sss" = string, string, string), si fuera un entero "i" = integer
        $sql->bind_param("sss", $titulo, $descripcion, $fecha_caducidad);
        
        // 3. Ejecutamos la consulta
        $result = $sql->execute();
        
        // 4. Cerramos la consulta
        $sql->close();
        
        // 5. Devolvemos el resultado
        return $result;
    }

    // Read
    function readTask(){
    
        global $conn;
        // 1. Hacemos la consulta a la BD
        $sql = $conn->query("SELECT * FROM tareas ORDER BY id DESC");
        
        // 2. Creamos un array para guardar las rows
        $task = array();

        // 3. Recorremos toda las rows de la consulta
        while($row = $sql->fetch_assoc()){  // devolvemos un array asociativo
            $task[] = $row;                 // Añadimos cada fila al array
        }

        // Retorna un array vacío si hay error en la consulta
        if(!$sql) return [];

        // 4. Devolvemos todas las tareas
        return $task;
    }

    // Devuelve un array asociativo de la consulta o null sino existe
    function getTaskById($id): ?array {
        global $conn;

        // Hacemos la consulta a la BD
        $sql = $conn->prepare("SELECT * FROM tareas WHERE id = ?");
        $sql->bind_param("i",$id);
        $sql->execute();

        // Obtenemos los resultados y los guardamos en un array
        $result = $sql->get_result();
        $task = $result->fetch_assoc();

        $sql->close();
        return $task ?: null; // Devuelve un array con la consulta o null si esta vacia
    }

    // Update
    function updateTask($id, $titulo, $descripcion, $fecha, $completada){
        global $conn;
        $sql = $conn->prepare("UPDATE tareas SET titulo = ?, descripcion = ?,
                fecha_caducidad = ?, completada = ? WHERE id = ?");
        $sql->bind_param("sssii",$titulo, $descripcion, $fecha, $completada, $id);
        $result = $sql->execute();
        $sql->close();
        return $result;
    }

    // Delete
    function deleteTask($id){
        global $conn;
        $sql = $conn->prepare("DELETE FROM tareas WHERE id = ?");
        $sql->bind_param("i", $id);
        $result = $sql->execute();
        $sql->close();
        return $result;
    }
    /*
    function deleteTask($id){
        global $conn;
        $sql = $conn->query("DELETE FROM tareas WHERE id = $id");
        return $sql;
    } */
?>