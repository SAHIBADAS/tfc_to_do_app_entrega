<?php
session_start();
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
    $_SESSION["error"] = "ID de proyecto inválido.";
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}

// Verificar que la sesión tiene un usuario activo
if (!isset($_SESSION['idUsuario'])) {
    $_SESSION["error"] = "No se encontró el id del usuario en la sesión.";
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$idProyecto = (int) $jsonData['id'];

try {
    // Verificar el rol del usuario en la base de datos
    $pdo = Database::getConnection();
    $sqlRol = "SELECT rol FROM proyecto_usuario WHERE idUsuario = :idUsuario AND idProyecto = :idProyecto";
    $stmtRol = $pdo->prepare($sqlRol);
    $stmtRol->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtRol->bindParam(':idProyecto', $idProyecto, PDO::PARAM_INT);
    $stmtRol->execute();
    $rolUsuario = $stmtRol->fetchColumn();

    // Si el rol no es "creador", eliminar solo la relación del usuario con el proyecto
    if ($rolUsuario != 'creador') {
        try {
            $pdo = Database::getConnection();
            $pdo->beginTransaction();

            $sqlProyecto = "DELETE FROM proyecto_usuario WHERE idUsuario = :idUsuario AND idProyecto = :idProyectoIniciado";
            $stmtProyecto = $pdo->prepare($sqlProyecto);
            $stmtProyecto->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmtProyecto->bindParam(':idProyectoIniciado', $idProyecto, PDO::PARAM_INT);
            $stmtProyecto->execute();

            $pdo->commit();

            $_SESSION["idProyectoIniciado"] = "";
            $_SESSION["nombreProyectoIniciado"] = "";
            $_SESSION["success"]="Proyecto eliminado con éxito.";

            echo json_encode(["status" => "success", "message" => "Usuario eliminado del proyecto correctamente."]);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION["error"] = "No se pudo eliminar al usuario del proyecto. Error: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
            exit();
        }
    }

    // Si el rol es "creador", eliminar el proyecto completo
    try {
        $pdo = Database::getConnection();
        $pdo->beginTransaction();

        $sqlProyecto = "DELETE FROM proyecto WHERE id = :idProyecto";
        $stmtProyecto = $pdo->prepare($sqlProyecto);
        $stmtProyecto->bindParam(':idProyecto', $idProyecto, PDO::PARAM_INT);
        $stmtProyecto->execute();

        $pdo->commit();

        $_SESSION["idProyectoIniciado"] = "";
        $_SESSION["nombreProyectoIniciado"] = "";
        $_SESSION["success"]="Proyecto eliminado con éxito.";

        echo json_encode(["status" => "success", "message" => "Proyecto eliminado correctamente."]);
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION["error"] = "No se pudo eliminar el proyecto. Error: " . $e->getMessage();
        echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
        exit();
    }
} catch (PDOException $e) {
    $_SESSION["error"] = "Error al verificar el rol del usuario. Error: " . $e->getMessage();
    echo json_encode(["status" => "error", "message" => $_SESSION["error"]]);
    exit();
}
