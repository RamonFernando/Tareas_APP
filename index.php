<?php
require_once("1_conexion.php");
require_once("includes.php");


function mostrarMenu() {
    echo "\n=========================\n";
    echo " 📋 GESTOR DE TAREAS\n";
    echo "=========================\n";
    echo "1. 📜  Listar tareas\n";
    echo "2. ✏️   Crear nueva tarea\n";
    echo "3. 🛠️   Editar tarea\n";
    echo "4. 🗑️   Eliminar tarea\n";
    echo "5. 🔍  Buscar tarea\n";
    echo "6. 🚪  Salir\n";
    echo "👉  Seleccione una opción: ";
}

while (true) {
    mostrarMenu();
    $option = trim(fgets(STDIN)); // Leer opción desde teclado

    switch ($option) {
        case 1:
            // Listar tareas
            readTask();
            echo "📋  Cantidad de tareas registradas: " . count(readTask()) . "🧮\n";
            break;

        case 2:
            // Crear tarea
            $titulo = "";
            $descripcion = "";
            $fecha_caducidad = "";
            createTask($titulo, $descripcion, $fecha_caducidad);
            
            break;

        case 3:
            // Actualizar tarea
            echo "Ingrese el ID de la tarea a actualizar: ";
            $id = intval(trim(fgets(STDIN)));
            updateTask($id);
            
            break;

        case 4:
            // Eliminar tarea
            echo "ID de la tarea a eliminar: ";
            $id = intval(trim(fgets(STDIN)));
            deleteTask($id);

            break;
        case 5:
            // Buscar
            searchTask();
            break;
        case 6:
            echo "❎  Saliendo del programa...\n";
            exit;

        default:
            echo "⚠️  Opción no válida. Intente de nuevo.\n";
            break;
    }
}
?>
