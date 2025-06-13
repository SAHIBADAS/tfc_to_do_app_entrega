<?php
include_once "../config/config.php";
include_once "../includes/cors.php";
session_start();
header('Content-Type: application/json');

// Obtén el contenido de la solicitud (el cuerpo) (id del proyecto a iniciar)
$input = file_get_contents('php://input');

// Decodifica los datos JSON recibidos
$data = json_decode($input, true);

$idTask = $data["id"];
$newState = $data["estado"];

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("UPDATE task SET estado = :estado WHERE id = :idTask;");
    $stmt->bindParam(':estado', $newState, PDO::PARAM_INT);
    $stmt->bindParam(':idTask', $idTask, PDO::PARAM_INT);
    

    // Ejecutamos la consulta
    $stmt->execute();
    echo $newState;

} catch (PDOException $e) {
    // echo "Error de conexión: " . $e->getMessage();
    $_SESSION["error"]="Error de conexión";
    header("location:../views/dashboard.php");
}
