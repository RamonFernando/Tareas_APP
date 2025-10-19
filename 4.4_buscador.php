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
            if ($task)
                displayData([$task]);
            else
                echo "\n⚠️  No se encontró ninguna tarea con el ID $id.\n";
            
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
            echo "Ingrese la fecha (YYYY o YYYY-MM o YYYY-MM-DD): ";
            $fecha = trim(fgets(STDIN));

            // regex
            $fullDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha); // YYYY-MM-DD
            $yearAndMonth = preg_match('/^\d{4}-\d{2}$/', $fecha); // YYYY-MM
            $yearDate = preg_match('/^\d{4}$/', $fecha); // YYYY

            // Detectar qué tipo de formato escribió el usuario
            if ($fullDate) {
                // Caso 1: formato completo YYYY-MM-DD → buscar hasta ese mes
                $month = substr($fecha, 0, 7);
                $sql = $conn->prepare("SELECT * FROM tareas WHERE DATE_FORMAT(fecha_caducidad, '%Y-%m') <= ?");
                $sql->bind_param("s", $month);

            } elseif ($yearAndMonth) {
                // Caso 2: formato YYYY-MM → buscar exactamente ese mes
                $sql = $conn->prepare("SELECT * FROM tareas WHERE DATE_FORMAT(fecha_caducidad, '%Y-%m') = ?");
                $sql->bind_param("s", $fecha);

            } elseif ($yearDate) {
                // Caso 3: solo año YYYY → buscar todas las tareas del año
                $sql = $conn->prepare("SELECT * FROM tareas WHERE YEAR(fecha_caducidad) = ?");
                $sql->bind_param("s", $fecha);

            } else {
                // Entrada inválida
                echo "❌  Formato incorrecto. Use uno de los siguientes formatos:\n";
                echo "   - YYYY        → Buscar por año (ej: 2025)\n";
                echo "   - YYYY-MM     → Buscar por mes (ej: 2025-10)\n";
                echo "   - YYYY-MM-DD  → Buscar hasta ese mes (ej: 2025-10-19)\n";
                searchTask();
                break;
            }

            // Ejecutar consulta y mostrar resultados
            $sql->execute();
            $result = $sql->get_result();
            $tasks = $result->fetch_all(MYSQLI_ASSOC);
            // Mostrar resultados
            if (!empty($tasks)) {
                displayData($tasks);
                echo "\n✅ Se han encontrado " . count($tasks) . " coincidencias.\n";
            } else {
                echo "\n⚠️  No se han encontrado tareas para esa fecha.\n";
            }
            
            $sql->close();
            searchTask();
            break;

        case 4:
            echo "¿Desea ver tareas completadas (1)✅ o no completadas (0)❌?: ";
            $completada = trim(fgets(STDIN));

            if (!is_numeric($completada) || ($completada != 1 && $completada != 0)) {
                echo "\n⚠️  Debes introducir un número válido (✅ 1 para completada / ❌ 0 para incompleta)\n";
                return searchTask();
            }

            $completada = intval($completada);
            // Mostrar título informativo antes de los resultados
            echo ($completada === 1)
                ? "\n📋 Mostrando tareas ✅ completadas:"
                : "\n📋 Mostrando tareas ❌ pendientes:";
                
            
            $sql = $conn->prepare("SELECT * FROM tareas WHERE completada = ?");
            $sql->bind_param("i", $completada);
            $sql->execute();
            $result = $sql->get_result();
            $tasks = $result->fetch_all(MYSQLI_ASSOC);
            $sql->close();
            
            displayData($tasks);
            echo ($completada === 1)
                ? "\nHay un total de: " . count($tasks) . "📋 tareas completadas✅.\n"
                : "\nHay un total de: " . count($tasks) . "📋 tareas incompletas❌.\n";
            
            searchTask();
            break;

        case 5:
            echo "↩️  Volviendo al menú principal...\n";
            return;

        default:
            echo "⚠️  Opción no válida.\n";
            searchTask();
    }
}

 // Muestra resultados en el mismo formato que readTask()
function displayData(array $tasks) {
    if (empty($tasks)) {
        echo "⚠️  No se encontraron tareas que coincidan con la búsqueda.\n";
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
