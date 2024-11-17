<?php 

require_once __DIR__ . '/../../../vendor/autoload.php';

session_start();


$_SESSION = [];

session_destroy();

echo json_encode([
    "status" => "success",
    "message" => "User disconnected successfully."
]);