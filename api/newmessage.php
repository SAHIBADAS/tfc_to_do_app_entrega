<?php

include_once "../config/config.php";
include_once "../includes/cors.php";

session_start();
header("Content-Type: application/json");

try {
    // Verificar si la sesión tiene el proyecto iniciado
    if (!isset($_SESSION["idProyectoIniciado"])) {
        exit;
    }

    // Obtener el contenido del cuerpo de la solicitud
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    // Validar que el mensaje no esté vacío
    if (!isset($data["contenido"]) || trim($data["contenido"]) === "") {
        exit;
    }

    // Obtener el idChat asociado al idProyecto
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT id FROM chat WHERE idProyecto = :idProyecto");
    $stmt->bindParam(':idProyecto', $_SESSION["idProyectoIniciado"], PDO::PARAM_INT);
    $stmt->execute();
    $chat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chat) {
        exit;
    }

    $idChat = $chat['id'];
    $fecha = new DateTime(); // Obtiene la fecha y hora actual
    $now = $fecha->format("Y-m-d H:i:s"); // Formatea correctamente

    // Insertar el nuevo mensaje en la base de datos
    $stmt = $pdo->prepare("INSERT INTO mensaje (idChat ,idUsuario ,contenido, fecha_creacion) VALUES (:idChat, :idUsuario, :contenido, :fecha_creacion)");
    $stmt->bindParam(':idChat', $idChat, PDO::PARAM_INT);
    $stmt->bindParam(':idUsuario', $_SESSION["idUsuario"], PDO::PARAM_INT);
    $stmt->bindParam(':contenido', $data["contenido"], PDO::PARAM_STR);
    $stmt->bindParam(':fecha_creacion', $now, PDO::PARAM_STR);
    $stmt->execute();


} catch (PDOException $e) {
    // Si hay un error en la conexión, redirigir con el mensaje de error correspondiente
    $_SESSION["error"] = "Error de conexión";
    header("Location: ../views/dashboard.php");
    exit;
}
