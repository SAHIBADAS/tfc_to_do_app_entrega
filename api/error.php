<?php
session_start();
if (isset($_SESSION['error'])) {
    echo json_encode([
        "error" => true,
        "message" => $_SESSION['error']
    ]);
    unset($_SESSION['error']);
} else {
    echo json_encode([
        "error" => false
    ]);
}
?>
