<?php
session_start();
header('Content-Type: application/json');

// Obtén el contenido de la solicitud (el cuerpo) (id del proyecto a iniciar)
$input = file_get_contents('php://input');

// Decodifica los datos JSON recibidos
$data = json_decode($input, true);

$_SESSION["idProyectoIniciado"] = $data["id"];
$_SESSION["nombreProyectoIniciado"] = $data["nombre"];

echo "Iniciado proyecto con id de sesion" . $data['id'];
