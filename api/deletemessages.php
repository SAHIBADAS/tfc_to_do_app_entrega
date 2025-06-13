<?php

include_once "../config/config.php";
include_once "../includes/cors.php";
session_start();
header("Content-Type: application/json");

try {
    // Verificar si hay un proyecto iniciado
    if (empty($_SESSION["idProyectoIniciado"])) {
        echo json_encode(["success" => false, "message" => "No hay proyecto iniciado."]);
        exit;
    }

    $idProyecto = $_SESSION["idProyectoIniciado"];

    // Obtener el id del chat relacionado al proyecto
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT id FROM chat WHERE idProyecto = :idProyecto");
    $stmt->bindParam(":idProyecto", $idProyecto, PDO::PARAM_INT);
    $stmt->execute();
    $chat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chat) {
        echo json_encode(["success" => false, "message" => "No se encontró un chat asociado."]);
        exit;
    }

    $idChat = $chat["id"];

    // Eliminar los mensajes asociados a ese chat
    $stmt = $pdo->prepare("DELETE FROM mensaje WHERE idChat = :idChat");
    $stmt->bindParam(":idChat", $idChat, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Todos los mensajes han sido eliminados."]);

} catch (PDOException $e) {
    error_log("Error al eliminar mensajes: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Error interno."]);
}
