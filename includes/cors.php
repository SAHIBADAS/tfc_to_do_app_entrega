<?php
// Orígenes permitidos
$allowed_origins = [
    'localhost',
    'taskhive.space'
];

// Detectar el origen real de la solicitud
$origin = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? $_SERVER['REMOTE_ADDR'] ?? '';

// Verificar si el origen está en la lista permitida
if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
}

// Configurar cabeceras CORS
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Responder a preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Aquí continúa tu lógica del endpoint
