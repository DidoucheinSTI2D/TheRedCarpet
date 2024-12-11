<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\User;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['username']) &&  isset($data['email']) && isset($data['id'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $user = new User($pdo);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setBirthdate($data['birthdate']);

        try {
            $user->update($pdo, $data['id']);

            echo json_encode([
                "status" => "success",
                "message" => "User successfully updated."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to modify user: " . $e->getMessage()
            ]);
        }
    }  else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Invalid data."
        ]);
    }
}
?>