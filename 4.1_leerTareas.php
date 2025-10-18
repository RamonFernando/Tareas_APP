<?php
require_once("includes.php");
function readTask(){
        
        global $conn;
        $sql = $conn->query("SELECT * FROM tareas ORDER BY id ASC");
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
            echo "🆔 Id: " . $task['id'] . "\n";
            echo "📌 Título: " . $task['titulo'] . "\n";
            echo "📝 Descripción: " . $task['descripcion'] . "\n";
            echo "📅 Fecha: " . $task['fecha_caducidad'] . "\n";
            echo "📊 Completada: " . $task['completada'] . "\n";
        }
        return $tasks;
    }
?>