<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Schedule;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['date']) && isset($data['booked']) && isset($data['paid']) && isset($data['amount']) && isset($data['comment']) && isset($data['notation']) && isset($data['reactions']) && isset($data['spectacle_id']) && isset($data['subscriber_id'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $schedule = new Schedule($pdo);
        $schedule->setDate($data['date']);
        $schedule->setBooked($data['booked']);
        $schedule->setPaid($data['paid']);
        $schedule->setAmount($data['amount']);
        $schedule->setComment($data['comment']);
        $schedule->setNotation($data['notation']);
        $schedule->setReactions($data['reactions']);
        $schedule->setSpectacleId($data['spectacle_id']);
        $schedule->setSubscriberId($data['subscriber_id']);

        try {
            $schedule->save($pdo);

            echo json_encode([
                "status" => "success",
                "message" => "Schedule created successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create schedule: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Date, booked, paid, amount, comment, notation, reactions, spectacle_id and subscriber_id are required."
        ]);
    }
}