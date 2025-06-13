<?php

include_once "../config/config.php";
include_once "../includes/cors.php";

session_start();
header("Content-Type: application/json");

try {
    //Consultamos todos los proyectos con el id iniciado
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT proyecto.nombre, idProyecto FROM `proyecto_usuario` JOIN `proyecto` ON proyecto_usuario.idProyecto = proyecto.id where idUsuario=:id");
    $stmt->bindParam(':id', $_SESSION["idUsuario"], PDO::PARAM_INT);

    // Ejecutamos la consulta
    $stmt->execute();

    // Obtenemos los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Enviamos el JSON al js para que lo renderice
    echo json_encode($result);

} catch (PDOException $e) {
    // echo "Error de conexión: " . $e->getMessage();
    $_SESSION["error"]="Error de conexión";
    header("location:../views/dashboard.php");
}
