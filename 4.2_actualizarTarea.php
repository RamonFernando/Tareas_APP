<?php
require_once("includes.php");
// Update
    function updateTask($id){
        global $conn;
        
        $task = getTaskById($id);
        if(!$task) {
            echo "⚠️  No se encontro la tarea con Id $id";
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

        echo "Completada actualmente (1 = sí✅, 0 = no❌): " . $task['completada'] . "\nNuevo valor (1 o 0): ";
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
            ? "✅  Actualización realizada correctamente\n"
            : "⚠️  No se encontró el id: ($id) o ha ocurrido un error al actualizar.\n";

        $sql->close();
        return $result;
    }
?>