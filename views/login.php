<?php
include_once "../config/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = strtolower(trim($_POST["email"] ?? ''));
    $clave = $_POST["password"] ?? '';

    $errores = [];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    if (empty($clave)) {
        $errores[] = "La contraseña es obligatoria.";
    }

    if (!empty($errores)) {
        $_SESSION["error"] = implode(" ", $errores);
        header("Location: ../views/login.php");
        exit();
    }

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, nombre, clave, apellidos, avatar, email FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($clave, $usuario['clave'])) {

            // Login exitoso
            $_SESSION["idUsuario"] = $usuario["id"];
            $_SESSION["nombreUsuario"] = $usuario["nombre"];
            $_SESSION["avatar"] = $usuario["avatar"];
            $_SESSION["apellidos"] = $usuario["apellidos"];
            $_SESSION["email"] = $usuario["email"];
            $_SESSION["idProyectoIniciado"] = "";
            $_SESSION["nombreProyectoIniciado"] = "";

            // Guardamos la fecha y hora de sesión
            $now = (new DateTime())->format("Y-m-d H:i:s");
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("UPDATE usuario SET ultima_sesion = :ultima_sesion WHERE id = :id");
            $stmt->bindParam(':ultima_sesion', $now, PDO::PARAM_STR);
            $stmt->bindParam(':id', $usuario["id"], PDO::PARAM_INT);
            $stmt->execute();

            header("Location: dashboard.php");
            exit();
        } else {

            $_SESSION["error"] = "Correo o contraseña incorrectos.";
            header("Location: ../views/login.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error en login: " . $e->getMessage());
        $_SESSION["error"] = "Ocurrió un error interno. Intenta más tarde.";

        header("Location: ../views/login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta de forma segura para disfrutar de todas las funcionalidades personalizadas.">
    <title>TaskHive Home</title>
    <link rel="stylesheet" href="../assets/css/style-copy.css">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <script type="module" src="../js/logValidation.js"></script>
    <script type="module" src="../js/domElements.js"></script>
    <script type="module" src="../js/closesesion.js"></script>
</head>

<body class="reg">
    <div class="loader" id="loader"></div>
    <?php include "../includes/header.php"; ?>

    <!-- Modal error -->
    <dialog id="errorModal" closedby="any" class="dialog-1">
        <h3 class="modalTitle">Aviso</h3>
        <p id="modalMessageError" class="modalText"></p>
        <div class="butt2">
            <button id="acceptBtn2" class="second">Aceptar</button>
        </div>
    </dialog>

    <section class="form-reg">
        <article id="art_swap2">
            <form action="#" method="post">
                <h1>Iniciar sesión</h1>

                <label for="email-login">Email:</label>
                <input type="email" id="email-login" name="email" placeholder="Introduce tu correo eléctronico." aria-describedby="erroremail-log">
                <span id="erroremail-log" class="errorinfo" role="alert"></span>

                <label for="password-login">Contraseña:</label>
                <input type="password" id="password-login" name="password" placeholder="Introduce tu contraseña." aria-describedby="errorpass-log">
                <span id="errorpass-log" class="errorinfo" role="alert"></span>

                <button type="submit">Iniciar sesión</button>
                <button class="second" id="redir1" type="button">Registro</button>
            </form>
        </article>
        <article id="img_log"></article>
    </section>
    <?php include "../includes/footer.php"; ?>
</body>

</html>