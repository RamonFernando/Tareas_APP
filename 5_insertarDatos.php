<?php
require_once("2_conexion.php");
require_once("includes.php");

// 🔹 Array con las tareas de ejemplo
$tareas = [
    ["Estudiar PHP", "Repasar temas de PHP para FP DAW", "2025-10-20", true],
    ["Comprar pan", "Ir a la panadería a comprar pan fresco", "2025-10-16", false],
    ["Preparar entrega DAW", "Terminar proyecto y subirlo al servidor", "2025-10-25", false],
    ["Preparar entrega C#", "Finalizar proyecto CRUD en C#", "2025-11-25", true],
    ["Estudiar JavaScript", "Practicar arrays, objetos y DOM", "2025-11-10", false],
    ["Repasar HTML", "Revisar etiquetas semánticas y formularios", "2025-09-30", true],
    ["Aprender CSS Grid", "Diseñar layouts con grid-template", "2024-09-20", false],
    ["Hacer backup de la base de datos", "Copia de seguridad del sistema de tareas", "2025-10-05", true],
    ["Practicar MySQL", "Revisar consultas con JOIN y GROUP BY", "2025-10-22", false],
    ["Organizar escritorio", "Limpiar carpetas del proyecto", "2025-10-15", true],
    ["Ver clase de Midudev", "Aprender sobre Fetch API y promesas", "2025-11-12", false],
    ["Escribir documentación", "Actualizar README del proyecto DAW", "2025-12-01", false],
    ["Configurar servidor Apache", "Activar módulos y probar virtual hosts", "2025-10-28", true],
    ["Depurar código PHP", "Corregir warnings y notices", "2025-11-02", false],
    ["Crear formulario de login", "Implementar autenticación con sesiones", "2025-10-21", false],
    ["Validar formularios JS", "Agregar validación de cliente con JavaScript", "2025-12-10", false],
    ["Actualizar portafolio", "Subir proyectos a GitHub Pages", "2023-12-20", true],
    ["Leer sobre PDO", "Comparar PDO vs MySQLi", "2025-11-04", false],
    ["Hacer pruebas unitarias", "Crear tests básicos con PHPUnit", "2025-11-08", false],
    ["Diseñar base de datos", "Modelo entidad-relación para app de tareas", "2026-10-24", true],
    ["Subir código a GitHub", "Commit y push de los últimos cambios", "2025-10-18", true],
    ["Planificar proyecto final", "Definir estructura del proyecto", "2025-09-15", false],
    ["Actualizar dependencias", "Ejecutar composer update y npm install", "2025-11-16", true],
    ["Probar API REST", "Testear endpoints con Postman", "2026-11-22", false],
    ["Descansar", "Tomar un día libre antes de los exámenes", "2025-12-24", false],
];

// 🔹 Sentencias preparadas
$check = $conn->prepare("SELECT COUNT(*) FROM tareas WHERE titulo = ? AND fecha_caducidad = ?");
$insert = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_caducidad, completada) VALUES (?, ?, ?, ?)");

// 🔹 Recorrer e insertar evitando duplicados
foreach ($tareas as $tarea) {
    [$titulo, $descripcion, $fecha, $completada] = $tarea;

    // Verificar si la tarea ya existe (mismo título + fecha)
    $check->bind_param("ss", $titulo, $fecha);
    $check->execute();
    $check->bind_result($existe);
    $check->fetch();
    $check->free_result();

    if ($existe > 0) {
        echo "⚠️  Tarea duplicada (no insertada): $titulo ($fecha)\n";
        continue;
    }

    // Insertar si no existe
    $insert->bind_param("sssi", $titulo, $descripcion, $fecha, $completada);
    if ($insert->execute()) {
        echo "✅ Insertada: $titulo ($fecha)\n";
    } else {
        echo "❌ Error insertando '$titulo': " . $conn->error . "\n";
    }
}

echo "\n🎉 Inserción completada. Total tareas procesadas: " . count($tareas) . "\n";

$check->close();
$insert->close();
$conn->close();
?>
