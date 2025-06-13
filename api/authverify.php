<?php
include_once "../config/config.php";
include_once "../includes/cors.php";

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "0";
    exit();
}

$email = strtolower(trim($_POST["email"] ?? ''));
$clave = $_POST["password"] ?? '';

if (empty($email) || empty($clave)) {
    echo "0";
    exit();
}

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT clave FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario["clave"])) {
        echo "1";
    } else {
        echo "0";
    }
    
} catch (PDOException $e) {
    error_log("Error en authverify: " . $e->getMessage());
    echo "0";
}
?>
