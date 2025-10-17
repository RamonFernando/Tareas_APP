<?php
    include("2_conexion.php");
    // require_once("tareas_db");
    // $result = $conn->query("SELECT * FROM tareas ORDER BY id DESC");

    function mostrarMenu() {
        echo "\n=========================\n";
        echo "📋 GESTOR DE TAREAS\n";
        echo "=========================\n";
        echo "1. Listar tareas\n";
        echo "2. Crear nueva tarea\n";
        echo "3. Editar tarea\n";
        echo "4. Eliminar tarea\n";
        echo "5. Salir\n";
        echo "Seleccione una opción: ";
    }
    mostrarMenu();





?>