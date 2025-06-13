<?php
include_once "../config/config.php";
include_once "../includes/cors.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_SESSION['email']; // Obtener el email del usuario desde la sesión
    $nombre = trim($_POST["user-edit-name"] ?? '');
    $apellidos = trim($_POST["user-edit-lastname"] ?? '');

    $errores = [];

    //Validaciones

    // Validar nombre: obligatorio, máximo 20 caracteres, solo letras (mayúsculas/minúsculas), tildes permitidas
    if (empty($nombre) || strlen($nombre) > 20 || !preg_match('/^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,20}$/', $nombre)) {
        $errores[] = "El nombre es obligatorio, debe tener entre 2 y 20 caracteres y solo puede contener letras.";
    }

    // Validar apellidos: obligatorio, máximo 40 caracteres, uno o dos apellidos con espacio, solo letras
    if (empty($apellidos) || strlen($apellidos) > 40 || !preg_match('/^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,30}( [A-Za-zÁÉÍÓÚÑáéíóúñ]{2,30})?$/', $apellidos)) {
        $errores[] = "Los apellidos son obligatorios, deben tener máximo 40 caracteres y solo pueden contener letras.";
    }

    // Si hay errores de validación, redirigir al formulario con los errores
    if (!empty($errores)) {
        $_SESSION["error"] = implode("<br>", $errores);
        header("Location: ../views/registro.php");
        exit();
    }

    // Intentar actualizar los campos de nombre y apellidos en la base de datos
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE usuario SET nombre = :nombre, apellidos = :apellidos WHERE email = :email");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $_SESSION["nombreUsuario"] = $nombre;
        $_SESSION["apellidos"] = $apellidos;
        $_SESSION["success"] = "Datos actualizados correctamente.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al actualizar los datos en la base de datos.";
        header("Location: ../views/registro.php");
        exit();
    }

    // Verificar si se sube una nueva imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        
        // Validar el tamaño máximo del archivo (2 MB = 2 * 1024 * 1024 bytes)
        $tamanoMaximo = 2 * 1024 * 1024; // 2 MB
        if ($_FILES['foto']['size'] > $tamanoMaximo) {
            $_SESSION["error"] = "La imagen es demasiado grande. El tamaño máximo permitido es 2 MB.";
            header("Location: ../views/registro.php");
            exit();
        }

        // Obtener la información del archivo subido
        $archivoTmp = $_FILES['foto']['tmp_name'];
        $nombreOriginal = $_FILES['foto']['name'];

        // Obtener la extensión del archivo (asegurándonos de que sea en minúsculas)
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        // Validar tipo de imagen permitido (JPG, JPEG)
        $tiposPermitidos = ['jpg', 'jpeg'];
        $mimePermitidos = ['image/jpeg'];
        $mimeReal = mime_content_type($archivoTmp);

        if (in_array($extension, $tiposPermitidos) && in_array($mimeReal, $mimePermitidos)) {
            // Nombre base del archivo (sin extensión)
            $nombreBase = $email . "_avatar";

            // Ruta absoluta para guardar la imagen (usando el nombre base y la nueva extensión)
            $nombreArchivo = $nombreBase . "." . $extension;
            $rutaRelativa = "avatars/" . $nombreArchivo;
            $rutaCompleta = "../" . $rutaRelativa;

            // Si ya existe un archivo con el mismo nombre base pero con diferente extensión, lo eliminamos
            $extensiones = ['jpg', 'jpeg', 'png'];
            foreach ($extensiones as $ext) {
                $archivoExistente = "../avatars/" . $nombreBase . "." . $ext;
                if (file_exists($archivoExistente)) {
                    unlink($archivoExistente); // Eliminar el archivo existente
                }
            }

            // Mover el archivo subido al directorio de destino
            if (move_uploaded_file($archivoTmp, $rutaCompleta)) {
                // Actualizar la ruta en la base de datos
                try {
                    $pdo = Database::getConnection();
                    $stmt = $pdo->prepare("UPDATE usuario SET avatar = :avatar WHERE email = :email");
                    $stmt->bindParam(':avatar', $rutaCompleta);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    $_SESSION["avatar"] = $rutaCompleta;
                    $_SESSION["success"] = "Imagen actualizada correctamente.";
                } catch (PDOException $e) {
                    $_SESSION["error"] = "Error al actualizar la base de datos.";
                }
            } else {
                $_SESSION["error"] = "No se pudo guardar la imagen.";
            }
        } else {
            $_SESSION["error"] = "Formato de imagen no permitido. Solo JPG o JPEG.";
        }
    }

    // Redirigir a la página de dashboard después de la operación
    header("Location: ../views/dashboard.php");
    exit;
}
