<?php
include_once "../config/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Recoger datos del formulario sin sanitizar aún
    $nombre = trim($_POST["name"] ?? '');
    $apellidos = trim($_POST["lastname"] ?? '');
    $email = strtolower(trim($_POST["email"] ?? ''));
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm-password"] ?? '';
    $ultima_sesion = null;

    $errores = [];

    // 2. Validaciones

    // Validación de nombre (solo letras y acentos, máximo 20 caracteres)
    if (empty($nombre) || strlen($nombre) > 20 || !preg_match('/^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,20}$/', $nombre)) {
        $errores[] = "El nombre es obligatorio, debe tener entre 2 y 20 caracteres y solo letras.";
    }

    // Validación de apellidos (uno o dos apellidos, separados por espacio, máximo 40 caracteres)
    if (empty($apellidos) || strlen($apellidos) > 40 || !preg_match('/^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,30}( [A-Za-zÁÉÍÓÚÑáéíóúñ]{2,30})?$/', $apellidos)) {
        $errores[] = "Los apellidos son obligatorios, deben tener máximo 40 caracteres y solo letras.";
    }

    // Validación de email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email es obligatorio y debe tener un formato válido.";
    }

    // Validación de contraseña
    if (empty($password) || strlen($password) < 9) {
        $errores[] = "La contraseña debe tener al menos 9 caracteres.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$%&·#@|]).{9,}$/', $password)) {
        $errores[] = "La contraseña debe tener al menos una mayúscula, una minúscula, un número y un símbolo especial ($%&·#@|).";
    }

    // Confirmación de contraseña
    if ($password !== $confirm_password) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Mostrar errores
    if (!empty($errores)) {
        $_SESSION["error"] = implode("<br>", $errores);
        header("Location: ../views/registro.php");
        exit();
    }

    // 3. Comprobar si el correo ya está registrado
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existeEmail = $stmt->fetchColumn();

        if ($existeEmail) {
            $_SESSION["error"] = "Este correo ya está registrado.";
            header("Location: ../views/registro.php");
            exit();
        }

        // 4. Registrar usuario
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuario (nombre, apellidos, email, clave, ultima_sesion)
                               VALUES (:nombre, :apellidos, :email, :clave, :ultima_sesion)");

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':clave', $hashpassword, PDO::PARAM_STR);
        $stmt->bindParam(':ultima_sesion', $ultima_sesion, PDO::PARAM_STR);

        $stmt->execute();

        $_SESSION["success"] = "Usuario registrado con éxito.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {

        error_log("Error en registro: " . $e->getMessage()); // Guarda en logs
        $_SESSION["error"] = "Ocurrió un error al procesar tu registro. Intentalo más tarde.";
        header("Location: ../views/registro.php");

        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crea una cuenta fácilmente para acceder a todos nuestros servicios. Solo toma unos segundos registrarte.">
    <title>TaskHive Home</title>
    <link rel="stylesheet" href="../assets/css/style-copy.css">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <script type="module" src="../js/regValidation.js"></script>
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
        <article id="art_swap">
            <form action="#" method="post">
                <h1>Registro</h1>
                <label for="name-reg">Nombre:</label>
                <input type="text" id="name-reg" name="name" placeholder="Máximo 50 caracteres" aria-describedby="errorname-reg">
                <span id="errorname-reg" class="errorinfo" role="alert"></span>

                <label for="lastname-reg">Apellidos:</label>
                <input type="text" id="lastname-reg" name="lastname" placeholder="Máximo 100 caractéres." aria-describedby="errorlastname-reg">
                <span id="errorlastname-reg" class="errorinfo" role="alert"></span>

                <label for="email-reg">Email:</label>
                <input type="email" id="email-reg" name="email" placeholder="example@example.com" aria-describedby="erroremail-reg">
                <span id="erroremail-reg" class="errorinfo" role="alert"></span>

                <label for="password-reg">Contraseña:</label>
                <input type="password" id="password-reg" name="password" placeholder="Ejemplo€jemplo123" aria-describedby="errorpass-reg">
                <span id="errorpass-reg" class="errorinfo" role="alert"></span>

                <label for="confirm-password-reg">Confirmar contraseña:</label>
                <input type="password" id="confirm-password-reg" name="confirm-password" placeholder="Confirma la contraseña" aria-describedby="errorpass2-reg">
                <span id="errorpass2-reg" class="errorinfo" role="alert"></span>

                <button type="submit">Enviar</button>
                <button class="second" id="redir2" type="button">Iniciar sesión</button>
            </form>
        </article>
        <article id="img_reg"></article>
    </section>
    <?php include "../includes/footer.php"; ?>
</body>

</html>