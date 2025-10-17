<?php
    // 2.1 Variables de entorno
    $servername = "localhost";
    $username = "root";
    $password = "";

    // 2.2 Creamos la conexion a la base de datos
    $conn = new mysqli($servername, $username, $password);

    // 2.3 Verificamos que la conexion se realice
    if($conn->connect_error)
        die("Error de conexion: $conn->connect_error");
    // --------------------------------------------------------------------------------------- //
    
    // 2.4 Creamos la base de datos si no existe
    $sql_db = "CREATE DATABASE IF NOT EXISTS tareas_db";

    // Recive por parametro la variable con conexion a la base de datos y la
    // variable de la creacion de la base de datos
    function create_db($conn, $sql_db): bool{
        if($conn->query($sql_db))
            return true;
        else
            return false;
    }

    // 2.5 Ejecucion de la creacion de la BD
    $created_db = create_db($conn, $sql_db);

    // 2.6 Comprobamos si la BD se creo correctamente y mostramos un mensaje
    function showMessageDB($created_db, $conn): void {
        if($created_db)
            echo "Base de datos creada correctamente.";
        else
            echo "ERROR: no se pudo realizar la operacion $conn->error";
    }

    // 2.7 Llamamos a la funcion y mostramos el mensaje al usuario
    showMessageDB( $created_db, $conn);

    // 2.8 Seleccionamos la base de datos (tareas_db)
    $conn->select_db("tareas_db");
?>