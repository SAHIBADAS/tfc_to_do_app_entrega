<?php
session_start();
include_once "../config/config.php"; // Asegúrate de que $pdo esté definido
include_once "../includes/cors.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    http_response_code(401);
    $_SESSION['error'] = 'No autorizado';
    header("Location: ../views/dashboard.php");
    exit;
}

$userId = $_SESSION['idUsuario'];
$passwordInput = $_POST['delete-pass'] ?? '';

if (empty($passwordInput)) {
    $_SESSION['error'] = 'Debes ingresar tu contraseña para confirmar.';
    header("Location: ../views/dashboard.php");
    exit;
}

try {
    // Obtener la contraseña del usuario
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT clave FROM usuario WHERE id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user || !password_verify($passwordInput, $user['clave'])) {
        $_SESSION['error'] = 'Contraseña incorrecta.';
        header("Location: ../views/dashboard.php");
        exit;
    }

    // Eliminar el usuario
    $delete = $pdo->prepare("DELETE FROM usuario WHERE id = :id");
    $delete->bindParam(':id', $userId, PDO::PARAM_INT);
    
    if ($delete->execute()) {
        session_destroy(); // Finaliza la sesión si todo sale bien
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = 'Error al eliminar el usuario.';
        header("Location: ../views/dashboard.php");
        exit;
    }
    
} catch (PDOException $e) {
    // Captura cualquier error en la base de datos
    error_log("Error al eliminar usuario: " . $e->getMessage());
    $_SESSION['error'] = 'Ocurrió un error inesperado. Intenta nuevamente.';
    header("Location: ../views/dashboard.php");
    exit;
}
