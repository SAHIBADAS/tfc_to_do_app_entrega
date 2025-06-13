<?php
include_once "../config/config.php";
include_once "../includes/cors.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos enviados a través del formulario
    $titulo = $_POST['title'];
    $estimacion = $_POST['estimation'];
    $estado = $_POST['state'];
    $prioridad = $_POST['priority'];
    $descripcion = $_POST['desc'];
    $color = $_POST['color'];
    $asig = $_POST['asig'];

    // Validación del título (1 a 39 caracteres)
    if (strlen($titulo) === 0 || strlen($titulo) >= 40) {
        $_SESSION["error"] = "El título debe tener entre 1 y 39 caracteres.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación de la descripción (1 a 199 caracteres)
    if (strlen($descripcion) === 0 || strlen($descripcion) >= 500) {
        $_SESSION["error"] = "La descripción debe tener entre 1 y 499 caracteres.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación de la estimación (formato 'Y-m-d' y fecha válida)
    $fechaEstimacion = DateTime::createFromFormat('Y-m-d', $estimacion);
    if (!$fechaEstimacion || $fechaEstimacion->format('Y-m-d') !== $estimacion) {
        $_SESSION["error"] = "La estimación no es una fecha válida.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación del estado (debe ser "0" a "4")
    $validStates = ["0", "1", "2", "3", "4"];
    if (!in_array($estado, $validStates, true)) {
        $_SESSION["error"] = "El estado seleccionado no es válido.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Validación de la prioridad (debe ser "0" a "4")
    $validPriorities = ["0", "1", "2", "3", "4"];
    if (!in_array($prioridad, $validPriorities, true)) {
        $_SESSION["error"] = "La prioridad seleccionada no es válida.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Crear fecha de creación
    $fecha = new DateTime(); // Obtiene la fecha y hora actual
    $now = $fecha->format("Y-m-d"); // Formatea correctamente

    try {
        // Preparamos la consulta SQL
        $pdo = Database::getConnection();
        $sql = "INSERT INTO task (titulo, estado, estimacion, idProyecto, prioridad, creador, fecha_creacion, descripcion, color_agenciado, idUsuarioAsignado) 
                VALUES (:titulo, :estado, :estimacion, :idProyecto, :prioridad, :creador, :fecha_creacion, :descripcion, :color, :idAsig)";
        $stmt = $pdo->prepare($sql);

        // Vinculamos los parámetros con bindParam
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':estimacion', $estimacion, PDO::PARAM_STR);
        $stmt->bindParam(':idProyecto', $_SESSION["idProyectoIniciado"], PDO::PARAM_INT);
        $stmt->bindParam(':prioridad', $prioridad, PDO::PARAM_INT);
        $stmt->bindParam(':creador', $_SESSION["nombreUsuario"], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_creacion', $now, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':idAsig', $asig, PDO::PARAM_INT);

        $stmt->execute();

        // Redirigir a la página de dashboard después de la inserción exitosa
        header("Location: ../views/dashboard.php");
        $_SESSION["success"] = "¡Tarea creada con éxito!";
        exit;
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al agregar la tarea: " . $e->getMessage();
        header("Location: ../views/dashboard.php");
        exit;
    }
}
