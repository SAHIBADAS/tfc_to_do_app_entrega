<?php

session_start();
include_once "../config/config.php"; // Archivo de conexión a la base de datos
include_once "../includes/cors.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $id = isset($_POST['id-edit']) ? intval($_POST['id-edit']) : 0;
    
    // Validar que los datos obligatorios no estén vacíos
    if ($id <= 0) {
        die("Error: Datos inválidos.");
    }

    try {
        // Preparar la consulta SQL para actualizar la tarea
        $pdo = Database::getConnection();
        $sql = "DELETE FROM task WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        // Bind de los parámetros
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        header("location:../views/dashboard.php");
        $_SESSION["success"] = "¡Tarea borrada con éxito!";
        
    } catch (PDOException $e) {
        // echo "Error en la actualización: " . $e->getMessage();
        $_SESSION["error"]="Error al borrar la tarea";
        header("location:../views/dashboard.php");
    }
}
?>