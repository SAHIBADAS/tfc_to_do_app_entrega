<?php
session_start();
include_once "../config/config.php";
include_once "../includes/cors.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $emailcollab = htmlspecialchars($_POST["emailcollab"]);
    $rol = "colaborador";

    // Validación básica del email
    if (!filter_var($emailcollab, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "El correo electrónico proporcionado no es válido.";
        header("Location: ../views/dashboard.php");
        exit;
    }

    try {
        // Comprobamos si existe el email en la base de datos
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $emailcollab, PDO::PARAM_STR);
        $stmt->execute();

        // Obtenemos el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) { // Si existe el usuario
            $idUsuario = $result['id']; // Extraemos el ID

            try {
                // Insertamos en la tabla proyecto_usuario
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("INSERT INTO proyecto_usuario (idUsuario, idProyecto, rol) VALUES (:idUsuario, :idProyecto, :rol)");
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmt->bindParam(':idProyecto', $_SESSION["idProyectoIniciado"], PDO::PARAM_INT);
                $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);

                $stmt->execute();

                // Después de realizar la operación, redirigimos sin mostrar mensaje de éxito
                $_SESSION["success"] = "¡Colaborador añadido con éxito!";
                header("Location: ../views/dashboard.php");
                exit;
            } catch (PDOException $e) {
                // Error al ejecutar la consulta
                $_SESSION["error"] = "Error al agregar el colaborador al proyecto.";
                header("Location: ../views/dashboard.php");
                exit;
            }
        } else {
            // El usuario no existe
            $_SESSION["error"] = "El usuario no existe en la base de datos.";
            header("Location: ../views/dashboard.php");
            exit;
        }
    } catch (PDOException $e) {
        // Error de conexión con la base de datos
        $_SESSION["error"] = "Error de conexión a la base de datos.";
        header("Location: ../views/dashboard.php");
        exit;
    }
}

