<?php
session_start();
header("Content-Type: application/json");
include_once "../config/config.php";
include_once "../includes/cors.php";

sleep(2);

// Leer el cuerpo de la solicitud una única vez
$rawInput = file_get_contents('php://input');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($rawInput)) {
    $_SESSION["error"] = "Solicitud no válida.";
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}

$jsonData = json_decode($rawInput, true);

// Validar que el ID esté presente y sea numérico
if (!isset($jsonData['id']) || !is_numeric($jsonData['id'])) {
    $_SESSION["error"] = "ID de usuario inválido.";
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}

// Verificar que la sesión tiene un proyecto activo
if (!isset($_SESSION['idProyectoIniciado'])) {
    $_SESSION["error"] = "Sesión expirada o proyecto no seleccionado.";
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}

// Sanitizar y asegurar los valores
$idUsuarioEliminar = (int) $jsonData['id'];
$idProyecto = (int) $_SESSION['idProyectoIniciado'];

try {
    // Verificar el rol del usuario a eliminar
    $pdo = Database::getConnection();
    $stmtRol = $pdo->prepare("SELECT rol FROM proyecto_usuario WHERE idUsuario = :id AND idProyecto = :idProyecto");
    $stmtRol->bindParam(':id', $idUsuarioEliminar, PDO::PARAM_INT);
    $stmtRol->bindParam(':idProyecto', $idProyecto, PDO::PARAM_INT);
    $stmtRol->execute();
    $rolUsuario = $stmtRol->fetchColumn();

    if ($rolUsuario === 'creador') {
        $_SESSION["error"] = "No se puede eliminar al creador del proyecto.";
        echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
        exit();
    }

    // Proceder con la eliminación del usuario del proyecto
    $stmt = $pdo->prepare("DELETE FROM proyecto_usuario WHERE idUsuario = :id AND idProyecto = :idProyecto");
    $stmt->bindParam(':id', $idUsuarioEliminar, PDO::PARAM_INT);
    $stmt->bindParam(':idProyecto', $idProyecto, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuario eliminado del proyecto correctamente."]);
        $_SESSION["success"]="Usuario eliminado con éxito.";
    } else {
        $_SESSION["error"] = "Error al eliminar al usuario del proyecto.";
        echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    }
} catch (PDOException $e) {
    error_log("Error al eliminar usuario del proyecto: " . $e->getMessage());
    $_SESSION["error"] = "Error interno al procesar la solicitud.";
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}
