<?php

include_once "../config/config.php";
include_once "../includes/cors.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $proyectname = $_POST["proyectname"];
    $fecha = new DateTime(); // Obtiene la fecha y hora actual
    $now = $fecha->format("Y-m-d H:i:s"); // Formatea correctamente
    $rol = "creador";

    if (!empty($proyectname)) {
        try {
            //Creamos un nuevo proyecto y lo añadimos a la tabla proyecto
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO proyecto (nombre, fecha, creador) VALUES (:nombre, :fecha, :creador)");
            $stmt->bindParam(':nombre', $proyectname, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $now, PDO::PARAM_STR);
            $stmt->bindParam(':creador', $_SESSION["nombreUsuario"], PDO::PARAM_STR);

            // Ejecutamos la consulta
            $stmt->execute();

            $lastInsertId = $pdo->lastInsertId();

            //Creamos un nuevo registro en la tabla proyecto_usuario
            $stmt = $pdo->prepare("INSERT INTO proyecto_usuario (idUsuario, idProyecto, rol) VALUES (:idUsuario, :idProyecto, :rol)");
            $stmt->bindParam(':idUsuario', $_SESSION["idUsuario"], PDO::PARAM_STR);
            $stmt->bindParam(':idProyecto', $lastInsertId, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $stmt->execute();

            //Creamos un nuevo registro en la tabla chat
            $stmt = $pdo->prepare("INSERT INTO chat (idProyecto) VALUES (:idProyecto)");
            $stmt->bindParam(':idProyecto', $lastInsertId, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $stmt->execute();
            header("location:../views/dashboard.php");
            $_SESSION["success"] = "¡Proyecto creado con éxito!";
        } catch (PDOException $e) {
            // echo "Error de conexión: " . $e->getMessage();
            $_SESSION["error"]="Error de conexión";
            header("location:../views/dashboard.php");
        }
    }else{
        $_SESSION["error"]="El campo nombre es obligatorio";
        header("location:../views/dashboard.php");
    }
}
