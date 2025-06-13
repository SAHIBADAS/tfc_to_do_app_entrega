<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $mensaje = htmlspecialchars($_POST['mensaje'] ?? '');

    if (empty($nombre) || empty($email) || empty($mensaje)) {
        $_SESSION['error'] = "Por favor, completa todos los campos.";
        exit;
    }

    $destinatario = "taskhive@taskhive.space"; // Cámbialo por el correo real
    $asunto = "Mensaje de contacto desde la web";

    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $email\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($destinatario, $asunto, $contenido, $headers)) {
        $_SESSION['success'] = "Correo enviado correctamente!";
        header("location:../views/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Vaya, parece que algo salió mal...";
        header("location:../views/index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Vaya, parece que algo salió mal...";
    header("location:../views/index.php");
    exit();
}
