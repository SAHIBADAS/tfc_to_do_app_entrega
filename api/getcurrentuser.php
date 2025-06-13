<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION["idUsuario"])) {
    echo json_encode(["idUsuario" => $_SESSION["idUsuario"]]);
} else {
    echo json_encode(["idUsuario" => null]);
}
?>
