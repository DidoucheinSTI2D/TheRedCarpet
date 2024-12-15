<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Room;
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
    $borough = $_GET['borough'] ?? null;

    if (!$borough) {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Borough is required."
        ]);
        exit();
    }

    try {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $room = new Room($pdo);
        $rooms = $room->findRoomByBorough($borough);

        echo json_encode([
            "status" => "success",
            "data" => $rooms
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred while filtering rooms by borough: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only GET requests are allowed."
    ]);
}
