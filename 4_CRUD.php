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
        $tasks = array();

        // Retorna un array vacío si hay error en la consulta
        if(!$sql) {
            echo "ERROR en la consulta $conn->error";
            return [];
        };

        // Mostramos resultados
        while($row = $sql->fetch_assoc())
            $tasks[] = $row;

        // Comprobamos si el array esta vacio
        if(empty($tasks)){
            echo "No hay tareas registradas";
            return [];
        }

        // Mostramos resultados
        foreach($tasks as $task){
            echo "------------------------------\n";
            echo "Id: " . $task['id'] . "\n";
            echo "Título: " . $task['titulo'] . "\n";
            echo "Descripción: " . $task['descripcion'] . "\n";
            echo "Fecha: " . $task['fecha_caducidad'] . "\n";
            echo "Completada: " . $task['completada'] . "\n";
        }
        
        return $tasks;
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