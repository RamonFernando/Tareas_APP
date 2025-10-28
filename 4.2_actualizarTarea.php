<?php
require_once("includes.php");
// Update
    /**
     * Summary of updateTask
     * Actualiza una tarea en la base de datos
     * @global $conn
     * @param mixed $id
     * @return bool
     * retorno: Parámetro: $id → identificador de la tarea que se desea modificar.
     * Tipo de retorno: bool → true si la actualización fue exitosa, false en caso contrario.
     */
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
        
        if ($fecha === '')
            $fecha = $task['fecha_caducidad'];
            // Validamos formato
        else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            echo "⚠️  Formato de fecha no válido. Usa YYYY-MM-DD.\n";
            return false;
        }
        // Comprobamos que la fecha es correcta
        if (!checkdate(substr($fecha, 5, 2), substr($fecha, 8, 2), substr($fecha, 0, 4))) {
            echo "⚠️  La fecha introducida no es correcta.\n";
            return false;
        }

        echo "Completada actualmente (1 = sí✅, 0 = no❌): " . $task['completada'] . "\nNuevo valor (1 o 0): ";
        $completada_task = trim(fgets(STDIN));
        
        // Comprobamos que el usuario introduce los numeros correctos
        if ($completada_task !== '' && $completada_task !== '0' && $completada_task !== '1') {
            echo "⚠️  El valor introducido no es valido, debe ser 1(✅sí) o 0(❌no).\n";
            return false;
        }

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
            : "⚠️  No se encontró el id: ($id) o no han habido cambios.\n";

        $sql->close();
        return $result;
    }
?>