<?php
require_once("includes.php");

/**
 * Summary of readTask
 * Lee todas las tareas almacenadas en la base de datos
 * @global $conn
 * @return array<array|bool|null>
 * retorno: devuelve un array asociativo con todas las tareas almacenadas.
 * Si no hay tareas o se produce un error, devuelve un array vacío.
 */
function readTask(){
        
        global $conn;
        $sql = $conn->query("SELECT * FROM tareas ORDER BY id ASC");
        $tasks = array();

        if(!$sql) { // Retorna un array vacío si hay error en la consulta
            echo "❌  ERROR en la consulta $conn->error";
            return [];
        };

        // Mostramos resultados
        while($row = $sql->fetch_assoc())
            $tasks[] = $row;
        
        if(empty($tasks)){ // Comprobamos si el array esta vacio
            echo "⚠️  No hay tareas registradas";
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