<?php
require_once("includes.php");

// Busca los datos por id, titulo, fecha o Estado de la tarea
function searchTask() {
    global $conn;

    echo "\n=========================\n";
    echo " 🔍 BUSCADOR DE TAREAS\n";
    echo "=========================\n";
    echo "1. Buscar por ID\n";
    echo "2. Buscar por Título\n";
    echo "3. Buscar por Fecha de caducidad\n";
    echo "4. Buscar por Estado (completada o no)\n";
    echo "5. Volver al menú principal\n";
    echo "Seleccione una opción: ";

    $option = trim(fgets(STDIN));

    switch ($option) {
        case 1:
            echo "Ingrese el ID de la tarea: ";
            $id = intval(trim(fgets(STDIN)));
            $task = getTaskById($id);
            if ($task) {
                displayData([$task]);
            } else {
                echo "⚠️ No se encontró ninguna tarea con el ID $id.\n";
            }
            searchTask();
            break;

        case 2:
            if(!function_exists('likeParam')){
                function likeParam($param) {
                    $param = trim($param);              // elimina espacios al principio y final
                    $param = addcslashes($param, '%_'); // escapa % y _ para búsquedas literales
                    $param = strtolower($param);        // convierte a minúsculas
                return "%$param%";                          // añade comodines para el LIKE
                }
            }

            echo "Ingrese el título o parte del título: ";
            $titulo = trim(fgets(STDIN));
            $sql = $conn->prepare("SELECT * FROM tareas WHERE LOWER(titulo) LIKE ?");
            $param = likeParam($titulo);
            $sql->bind_param("s", $param);
            $sql->execute();
            $result = $sql->get_result();
            $tasks = $result->fetch_all(MYSQLI_ASSOC);
            $sql->close();
            displayData($tasks);
            searchTask();
            break;

        case 3:
            echo "Ingrese la fecha (YYYY-MM-DD): ";
            $fecha = trim(fgets(STDIN));
            $sql = $conn->prepare("SELECT * FROM tareas WHERE fecha_caducidad = ?");
            $sql->bind_param("s", $fecha);
            $sql->execute();
            $result = $sql->get_result();
            $tasks = $result->fetch_all(MYSQLI_ASSOC);
            $sql->close();
            displayData($tasks);
            searchTask();
            break;

        case 4:
            echo "¿Desea ver tareas completadas (1)✅ o no completadas (0)❌?: ";
            $completada = intval(trim(fgets(STDIN)));

            if($option !== 1 || $option !== 0){
                echo "Debes introducir un caracter numerico (✅ 1 para completada / ❌ 0 para incompleta)";
                return searchTask();
            }

            $sql = $conn->prepare("SELECT * FROM tareas WHERE completada = ?");
            $sql->bind_param("i", $completada);
            $sql->execute();
            $result = $sql->get_result();
            $tasks = $result->fetch_all(MYSQLI_ASSOC);
            $sql->close();
            displayData($tasks);
            searchTask();
            break;

        case 5:
            echo "↩️ Volviendo al menú principal...\n";
            return;

        default:
            echo "⚠️ Opción no válida.\n";
            searchTask();
    }
}

 // Muestra resultados en el mismo formato que readTask()
function displayData(array $tasks) {
    if (empty($tasks)) {
        echo "⚠️ No se encontraron tareas que coincidan con la búsqueda.\n";
        return;
    }

    echo "\n📋 Resultados encontrados:\n";
    foreach ($tasks as $task) {
        echo "------------------------------\n";
        echo "🆔 Id: " . $task['id'] . "\n";
        echo "📌 Título: " . $task['titulo'] . "\n";
        echo "📝 Descripción: " . $task['descripcion'] . "\n";
        echo "📅 Fecha: " . $task['fecha_caducidad'] . "\n";
        echo "📊 Completada: " . $task['completada'] . "\n";
    }
}
?>
