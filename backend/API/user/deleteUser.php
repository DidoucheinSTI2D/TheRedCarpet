<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\User;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $user = new User($pdo);

        try {
            $user->delete($pdo, $data['id']);
            echo json_encode([
                "status" => "success",
                "message" => "User deleted successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to delete user: " . $e->getMessage()
            ]);
        }
    }
?>