<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Representation;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['first_date']) && isset($data['last_date']) && isset($data['spectacle_id']) && isset($data['room_id'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $representation = new Representation($pdo);
        $representation->setFirstDate($data['first_date']);
        $representation->setLastDate($data['last_date']);
        $representation->setSpectacleId($data['spectacle_id']);
        $representation->setRoomId($data['room_id']);
        
        try {
            $representation->delete($pdo);
            echo json_encode([
                "status" => "success",
                "message" => "Representation deleted successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to delete representation: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "First date, last date, spectacle_id and room_id are required."
        ]);
    }
}