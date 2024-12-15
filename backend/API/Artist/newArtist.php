<?php 

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Artist;
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

    if (isset($data['firstname']) && isset($data['lastname']) && isset($data['biography'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $artist = new Artist($pdo);
        $artist->setFirstName($data['firstname']);
        $artist->setLastName($data['lastname']);
        $artist->setBiography($data['biography']);

        try {
            $artist->save($pdo);

            echo json_encode([
                "status" => "success",
                "message" => "Artist created successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create artist: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "First name, last name and biography are required."
        ]);
    }
}