<?php
session_start();

$response = [
    'success' => ''
];

if (!empty($_SESSION['success'])) {
    $response['success'] = $_SESSION['success'];
    $_SESSION['success'] = '';
}

echo json_encode($response);
