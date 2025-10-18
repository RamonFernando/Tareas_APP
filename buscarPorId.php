<?php
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
?>