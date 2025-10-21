<?php
require_once("includes.php");

 // Delete
    /**
     * Summary of deleteTask
     * Elimina una tarea de la base de datos
     * @global $conn
     * @param mixed $id
     * @return bool
     * retorno: Parámetro: $id → identificador de la tarea que se desea eliminar.
     * Devuelve true si la tarea se elimina correctamente, false en caso contrario
     */
    function deleteTask($id){
        global $conn;
        // Verificar si la tarea existe
        $task = getTaskById($id);
        if (!$task) {
            echo "⚠️  No se encontró la tarea con ID $id.\n";
            return false;
        }

        // Preguntar al usuario antes de eliminar
        echo "¿Estás seguro de que deseas eliminar la tarea con ID $id? (s/n): ";
        $answer = trim(fgets(STDIN));

        if (strtolower($answer) !== 's') {
            echo "❌  Eliminación cancelada.\n";
            return false; // No elimina la tarea
        }

        $sql = $conn->prepare("DELETE FROM tareas WHERE id = ?");
        $sql->bind_param("i", $id);
        $result = $sql->execute();

        // Comprobamos si el registro fue eliminado
        echo ($sql->affected_rows > 0)
            ? "✅  Tarea eliminada correctamente\n"
            : "⚠️  Tarea no encontrada o ya eliminada\n";

        $sql->close();
        return $result;
    }
?>