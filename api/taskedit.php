<?php
session_start();
include_once "../config/config.php"; // Archivo de conexión a la base de datos
include_once "../includes/cors.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $id = isset($_POST['id-edit']) ? intval($_POST['id-edit']) : 0;
    $titulo = isset($_POST['title-edit']) ? trim($_POST['title-edit']) : '';
    $estimacion = isset($_POST['estimation-edit']) ? $_POST['estimation-edit'] : '';
    $estado = isset($_POST['state-edit']) ? intval($_POST['state-edit']) : 0;
    $prioridad = isset($_POST['priority-edit']) ? intval($_POST['priority-edit']) : 0;
    $descripcion = isset($_POST['desc-edit']) ? trim($_POST['desc-edit']) : '';
    $color = isset($_POST['color']) ? trim($_POST['color']) : '#bebdbd';
    $asig = isset($_POST['asig-edit']) ? trim($_POST['asig-edit']) : $_SESSION["idUsuario"];

    // Validar que el título no esté vacío y que tenga una longitud válida (1-39 caracteres)
    if (empty($titulo) || strlen($titulo) >= 40) {
        $_SESSION["error"] = "El título debe tener entre 1 y 39 caracteres.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validar que la descripción no esté vacía y que tenga una longitud válida (1-199 caracteres)
    if (empty($descripcion) || strlen($descripcion) >= 500) {
        $_SESSION["error"] = "La descripción debe tener entre 1 y 499 caracteres.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación de la estimación (aseguramos que sea una fecha válida)
    $fechaEstimacion = DateTime::createFromFormat('Y-m-d', $estimacion);
    if (!$fechaEstimacion || $fechaEstimacion->format('Y-m-d') !== $estimacion) {
        $_SESSION["error"] = "La estimación no es una fecha válida.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación del estado (debe estar entre 0 y 4)
    if ($estado < 0 || $estado > 4) {
        $_SESSION["error"] = "El estado debe estar entre 0 y 4.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación de la prioridad (debe estar entre 0 y 4)
    if ($prioridad < 0 || $prioridad > 4) {
        $_SESSION["error"] = "La prioridad debe estar entre 0 y 4.";
        header("Location: ../views/dashboard.php");
        exit;
    }


    try {
        // Preparar la consulta SQL para actualizar la tarea
        $pdo = Database::getConnection();
        $sql = "UPDATE task SET titulo = :titulo, estimacion = :estimacion, estado = :estado, prioridad = :prioridad, descripcion = :descripcion, color_agenciado = :color, idUsuarioAsignado = :asig WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Bind de los parámetros
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':estimacion', $estimacion, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':prioridad', $prioridad, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':asig', $asig, PDO::PARAM_INT);

        $stmt->execute();
        header("Location: ../views/dashboard.php");
        $_SESSION["success"] = "¡Tarea editada con éxito!";
        exit;
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error en la actualización: " . $e->getMessage();
        header("Location: ../views/dashboard.php");
        exit;
    }
}
