<?php 

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Role;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['role']) && isset($data['artist_id']) && isset($data['spectacle_id'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $role = new Role($pdo);
        $role->setRole($data['role']);
        $role->setArtistId($data['artist_id']);
        $role->setSpectacleId($data['spectacle_id']);

        try {
            $role->save($pdo);

            echo json_encode([
                "status" => "success",
                "message" => "Role created successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create role: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Role, artist_id and spectacle_id are required."
        ]);
    }
}