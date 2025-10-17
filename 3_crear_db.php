<?php
    require_once("2_conexion.php");

    // 3.1 Creamos la tabla tareas
    $sql_table = "CREATE TABLE IF NOT EXISTS tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    fecha_caducidad DATE,
    completada BOOLEAN DEFAULT FALSE
)";

    // Recive por parametro la variable con la conexion a la base de datos y
    // la variable con la tabla (tareas)
    function create_table($conn, $sql_table){
        if($conn->query($sql_table))
            return true;
        else
            return false;
    }

    // 3.2 Ejecutar la creacion de la tabla
    $create_table = create_table($conn, $sql_table);

    // 3.3 Comprueba si se creo la tabla correctamente y muestra un mensaje
    function showMessageTable($create_table, $conn){
        if($create_table)
            echo "\nTabla creada correctamente.";
        else
            echo "ERROR: no se pudo realizar la operacion $conn->error";
    }

    // 3.4 Mostramos el mensaje al usuario
    showMessageTable($create_table, $conn);

    // 3.5 Cerramos la conexion
    $conn->close();
?>