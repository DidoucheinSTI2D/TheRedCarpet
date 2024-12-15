<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Room;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVEr['REQUEST_METHOD'] === 'DELETE') { 
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $room = new Room($pdo);
        $room->setId($data['id']);

        try {
            $room->delete($pdo);

            echo json_encode([
                "status" => "success",
                "message" => "Room deleted successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to delete room: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Id is required."
        ]);
    }
}