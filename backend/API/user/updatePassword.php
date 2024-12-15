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

    if (isset($data['id'], $data['old_password'], $data['new_password'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $user = new User($pdo);

        $id = (int) $data['id'];
        $oldPassword = $data['old_password'];
        $newPassword = $data['new_password'];

        try {
            $success = $user->updatePassword($id, $oldPassword, $newPassword);

            if ($success) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Password updated successfully."
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to update password. Either the old password is incorrect or the user does not exist."
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update password: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "User ID, old password, and new password are required."
        ]);
    }
}
