<?php

include_once "../config/config.php";
include_once "../includes/cors.php";

session_start();
header("Content-Type: application/json");

try {
    //Consultamos todos las tareas con el id del proyecto correspondiente
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT u.avatar, u.nombre, u.apellidos, u.id FROM usuario u JOIN proyecto_usuario pu ON u.id = pu.idUsuario WHERE pu.idProyecto = :idProyecto");
    $stmt->bindParam(':idProyecto', $_SESSION["idProyectoIniciado"], PDO::PARAM_INT);

    // Ejecutamos la consulta
    $stmt->execute();

    // Obtenemos los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Enviamos el JSON al js para que lo renderice
    echo json_encode($result);
} catch (PDOException $e) {
    $_SESSION["error"]="Error de conexión";
    header("location:../views/dashboard.php");
}
