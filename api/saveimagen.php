<?php
include_once "../config/config.php";
include_once "../includes/cors.php";

$data = json_decode(file_get_contents("php://input"));

sleep(2);

if (isset($data->imagen) && isset($data->email)) {
    $imagen = $data->imagen;
    $email = $data->email; // Sanitizar nombre

    // Extraer la parte de la imagen sin el encabezado
    list($tipo, $imagenBase64) = explode(';', $imagen);
    list(, $imagenBase64) = explode(',', $imagenBase64);
    $imagenBase64 = base64_decode($imagenBase64);

    // Ruta donde se guardará la imagen
    $rutaArchivo = "../avatars/{$email}_avatar.png";

    file_put_contents($rutaArchivo, $imagenBase64);

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE usuario SET avatar = :avatar WHERE email = :email");
        $stmt->bindParam(':avatar', $rutaArchivo, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        // echo "Error de conexión: " . $e->getMessage();
        $_SESSION["error"]="Error de conexión";
        header("location:../views/dashboard.php");
    }


} else {
    // echo "Datos no válidos";
    $_SESSION["error"]="Error de validación";
    header("location:../views/dashboard.php");
}
?>
