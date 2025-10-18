<?php
include("2_conexion.php");
require_once("4_CRUD.php");

function mostrarMenu() {
    echo "\n=========================\n";
    echo " 📋 GESTOR DE TAREAS\n";
    echo "=========================\n";
    echo "1. Listar tareas\n";
    echo "2. Crear nueva tarea\n";
    echo "3. Editar tarea\n";
    echo "4. Eliminar tarea\n";
    echo "5. Salir\n";
    echo "Seleccione una opción: ";
}

while (true) {
    mostrarMenu();
    $option = trim(fgets(STDIN)); // Leer opción desde teclado

    switch ($option) {
        case 1:
            // Listar tareas
            readTask();
            break;

        case 2:
            // Crear tarea
            echo "Título: ";
            $titulo = trim(fgets(STDIN));

            echo "Descripción: ";
            $descripcion = trim(fgets(STDIN));

            echo "Fecha (YYYY-MM-DD): ";
            $fecha_caducidad = trim(fgets(STDIN));

            $create = createTask($titulo, $descripcion, $fecha_caducidad);
            echo $create
                ? "✅ Tarea creada correctamente.\n"
                : "❌ ERROR: no se pudo crear la tarea.\n";
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
            echo "❎ Saliendo del programa...\n";
            exit;

        default:
            echo "⚠️ Opción no válida. Intente de nuevo.\n";
            break;
    }
}
?>
