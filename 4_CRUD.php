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
    // Busca la consulta por el id
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
    function updateTask($id){
        global $conn;
        
        $task = getTaskById($id);
        if(!$task) {
            echo "⚠️ No se encontro la tarea con Id $id";
            return false;
        }
        echo "Actualización de la tarea ID $id. Rellenar solo los campos deseados.\n";

        //Informacion
        echo "Título actual:".  $task['titulo'] . "\nNuevo título: ";
        $titulo = trim(fgets(STDIN));
        if ($titulo === '') $titulo = $task['titulo'];

        echo "Descripción actual:" . $task['descripcion'] . "\nNueva descripción: ";
        $descripcion = trim(fgets(STDIN));
        if ($descripcion === '') $descripcion = $task['descripcion'];

        echo "Fecha actual: " . $task['fecha_caducidad'] . "\nNueva fecha (YYYY-MM-DD): ";
        $fecha = trim(fgets(STDIN));
        if ($fecha === '') $fecha = $task['fecha_caducidad'];

        echo "Completada actualmente (1 = sí, 0 = no): {$task['completada']}\nNuevo valor (1 o 0): ";
        $completada_task = trim(fgets(STDIN));
        ($completada_task === '')
            ? $completada = $task['completada']
            : $completada = intval($completada_task);
        
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
        echo ($sql->affected_rows > 0)
            ? "✅ Actualización realizada correctamente\n"
            : "⚠️ No se encontró el id: ($id) o ha ocurrido un error al actualizar.\n";

        $sql->close();
        return $result;
    }

    // Delete
    function deleteTask($id){
        global $conn;
        // Verificar si la tarea existe
        $task = getTaskById($id);
        if (!$task) {
            echo "⚠️ No se encontró la tarea con ID $id.\n";
            return false;
        }

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
        echo ($sql->affected_rows > 0)
            ? "✅ Tarea eliminada correctamente\n"
            : "⚠️ Tarea no encontrada o ya eliminada\n";

        $sql->close();
        return $result;
    }
?>