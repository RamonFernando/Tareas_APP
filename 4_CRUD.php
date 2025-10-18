<?php
    require_once("2_conexion.php");

    // Create
    function createTask($titulo,$descripcion, $fecha_caducidad): bool|mysqli_result{
        
        global $conn;

        // 1. Preparamos la consulta para evitar inyeccion de codigo en la BD
        $sql = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_caducidad) values (?, ?, ?)");
        
        // 2. Enlazamos los parámetros ("sss" = string, string, string), si fuera un entero "i" = integer
        $sql->bind_param("sss", $titulo, $descripcion, $fecha_caducidad);
        
        $result = $sql->execute();
        $sql->close();
        return $result;
    }

    // Read
    function readTask(){
        
        global $conn;
        $sql = $conn->query("SELECT * FROM tareas ORDER BY id DESC");
        $tasks = array();

        if(!$sql) { // Retorna un array vacío si hay error en la consulta
            echo "❌ ERROR en la consulta $conn->error";
            return [];
        };

        // Mostramos resultados
        while($row = $sql->fetch_assoc())
            $tasks[] = $row;
        
        if(empty($tasks)){ // Comprobamos si el array esta vacio
            echo "⚠️ No hay tareas registradas";
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

        // Preguntar al usuario antes de eliminar
        echo "¿Estás seguro de que deseas actualizar la tarea con ID $id? (s/n): ";
        $answer = trim(fgets(STDIN));

        if (strtolower($answer) !== 's') {
            echo "❌ Actualización cancelada.\n";
            return false; // No actualiza
        }

        $sql = $conn->prepare("UPDATE tareas SET titulo = ?, descripcion = ?,
                fecha_caducidad = ?, completada = ? WHERE id = ?");
        $sql->bind_param("sssii",$titulo, $descripcion, $fecha, $completada, $id);
        $result = $sql->execute();

        // Comprobamos si la actualización se realizo correctamente
        ($sql->affected_rows > 0) ?
            "✅ Actualización realizada correctamente" :
            "⚠️ No se encontró el id: ($id) o ha ocurrido un error al actualizar.";
        
            $sql->close();
        return $result;
    }

    // Delete
    function deleteTask($id){
        global $conn;

        // Preguntar al usuario antes de eliminar
        echo "¿Estás seguro de que deseas eliminar la tarea con ID $id? (s/n): ";
        $answer = trim(fgets(STDIN));

        if (strtolower($answer) !== 's') {
            echo "❌ Eliminación cancelada.\n";
            return false; // No elimina la tarea
        }

        $sql = $conn->prepare("DELETE FROM tareas WHERE id = ?");
        $sql->bind_param("i", $id);
        $result = $sql->execute();

        // Comprobamos si el registro fue eliminado
        ($sql->affected_rows > 0) ?
            "✅ Tarea eliminada correctamente" :
            "⚠️ Tarea no encontrado o eliminada";

        $sql->close();
        return $result;
    }
?>