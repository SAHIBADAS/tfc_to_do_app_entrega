<?php

include_once "../config/config.php";
include_once "../includes/cors.php";

session_start();
header("Content-Type: application/json");

try {
    // Verificar si la variable de sesión está definida
    if (!isset($_SESSION["idProyectoIniciado"])) {
        header("location:../views/dashboard.php");
        exit;
    }

    // Primero obtenemos el idChat asociado al idProyecto
    $pdo = Database::getConnection();
    
    $stmt = $pdo->prepare("SELECT id FROM chat WHERE idProyecto = :idProyecto");
    $stmt->bindParam(':idProyecto', $_SESSION["idProyectoIniciado"], PDO::PARAM_INT);
    $stmt->execute();
    $chat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chat) {
        exit;
    }

    $idChat = $chat['id'];

    // Ahora obtenemos los mensajes de ese idChat
    $stmt = $pdo->prepare("SELECT mensaje.*, usuario.avatar as avatar FROM mensaje JOIN usuario ON mensaje.idUsuario = usuario.id WHERE mensaje.idChat = :idChat ORDER BY fecha_creacion ASC");
    $stmt->bindParam(':idChat', $idChat, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Enviamos el JSON con los mensajes
    echo json_encode($messages);
} catch (PDOException $e) {
    // echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    $_SESSION["error"]="Error de conexión";
    header("location:../views/dashboard.php");
}
