<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Schedule;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['spectacle_id'], $data['subscriber_id'], $data['comment'], $data['notation'], $data['reactions'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $schedule = new Schedule($pdo);

        $spectacleId = $data['spectacle_id'];
        $subscriberId = $data['subscriber_id'];
        $comment = $data['comment'];
        $notation = (int) $data['notation'];
        $reactions = $data['reactions'];

        try {
            $success = $schedule->updateNote($spectacleId, $subscriberId, $comment, $notation, $reactions);

            if ($success) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Note, comment, and reactions updated successfully."
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to update note. Either paid is false or the schedule does not exist."
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update note: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Spectacle ID, subscriber ID, comment, notation, and reactions are required."
        ]);
    }
}
