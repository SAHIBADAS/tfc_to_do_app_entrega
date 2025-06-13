<?php
session_start();
include_once "../config/config.php";// Asegúrate de tener tu conexión aquí
include_once "../includes/cors.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['idUsuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Obtener y sanitizar entradas
$oldpass     = $_POST['oldpass']     ?? '';
$newpass     = $_POST['newpass']     ?? '';
$newpassConf = $_POST['newpass-conf'] ?? '';

if (empty($oldpass) || empty($newpass) || empty($newpassConf)) {
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    $_SESSION["error"]='Todos los campos son obligatorios';
    header("Location: ../views/dashboard.php");
    exit;
}

if ($newpass !== $newpassConf) {
    echo json_encode(['error' => 'Las contraseñas no coinciden']);
    $_SESSION["error"]='Las contraseñas no coinciden';
    header("Location: ../views/dashboard.php");
    exit;
}

// Obtener usuario desde la BD
$userId = $_SESSION['idUsuario'];
$pdo = Database::getConnection();
$stmt = $pdo->prepare("SELECT clave FROM usuario WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user || !password_verify($oldpass, $user['clave'])) {
    echo json_encode(['error' => 'La contraseña actual es incorrecta']);
    $_SESSION["error"]='La contraseña actual es incorrecta';
    header("Location: ../views/dashboard.php");
    exit;
}

// Hashear nueva contraseña
$newpassHash = password_hash($newpass, PASSWORD_DEFAULT);

// Actualizar contraseña en la BD
$update = $pdo->prepare("UPDATE usuario SET clave = ? WHERE id = ?");
if ($update->execute([$newpassHash, $userId])) {
    $_SESSION['success'] = 'Contraseña actualizada correctamente';
    echo json_encode(['success' => true]);
    header("Location: ../views/dashboard.php");
} else {
    echo json_encode(['error' => 'Error al actualizar la contraseña']);
    $_SESSION["error"]='Error al actualizar la contraseña';
    header("Location: ../views/dashboard.php");
}
