<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Spectacle;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $spectacle = new Spectacle($pdo);
        $spectacles = $spectacle->findSpectaclesByBorough();

        echo json_encode([
            "status" => "success",
            "data" => $spectacles
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred while retrieving spectacles by borough: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only GET requests are allowed."
    ]);
}
