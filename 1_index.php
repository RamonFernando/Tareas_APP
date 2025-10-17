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

    $option = trim(fgets(STDIN)); // Leer desde teclado por consola

    switch($option){
        case 1:
            // Leer la tarea
            readTask();
        break;
        
        case 2:
            // Crear la tarea
            echo "Título";
            $titulo = trim(fgets(STDIN));
            
            echo "Descripción";
            $description = trim(fgets(STDIN));
            
            echo "Fecha";
            $fecha_caducidad= trim(fgets(STDIN));
            
            $create = createTask($titulo, $descripcion, $fecha_caducidad);
            if($create)
                echo "Tarea creada correctamente.";
            else
                echo "ERROR: no se pudo crear la tarea.";
        break;
        
        case 3:
            // Editar la tarea (Actualizar)
            echo "Id de la tarea a editar: ";
            $id = trim(fgets(STDIN));
            
            echo "Nuevo Título: ";
            $titulo = trim(fgets(STDIN));
            
            echo "Nueva Descripción: ";
            $description = trim(fgets(STDIN));
            
            echo "Nueva Fecha (YYYY/MM/DD): ";
            $fecha_caducidad= trim(fgets(STDIN));
            
            echo "Completada si = 1, no = 0: ";
            $completada = trim(fgets(STDIN));

            $update = updateTask($id, $titulo, $descripcion, $fecha_caducidad, $completada);
            if($update)
                echo "Se ha actualizado la tarea $id correctamente";
            elseif($id == null)
                echo "No se encontrol el $id de la tarea";
            else
                echo "ERROR: no se pudo realizar la actualización.";
        break;

        case 4:
            // Eliminar la tarea
            echo "Id de la tarea a eliminar: ";
            $id = trim(fgets(STDIN));
            
            if(deleteTask($id))
                echo "Se ha eliminado la tarea $id correctamente";
            elseif($id == null)
                echo "Tarea $id no encontrada";
            else
                echo "ERROR: No se ha podido eliminar la tarea $id.";
        break;

        case 5:
            echo "Saliendo del programa...";
            exit;
        
        default:
            echo "Opcion no valida";
    }
    





?>