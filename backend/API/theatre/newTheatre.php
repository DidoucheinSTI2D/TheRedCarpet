<?php 

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Theatre;
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

    if (isset($data['name']) && isset($data['presentation']) && isset($data['address']) && isset($data['borough']) && isset($data['geolocalisation']) && isset($data['phone']) && isset($data['email'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $theatre = new Theatre($pdo);
        $theatre->setName($data['name']);
        $theatre->setPresentation($data['presentation']);
        $theatre->setAddress($data['address']);
        $theatre->setBorough($data['borough']);
        $theatre->setGeolocalisation($data['geolocalisation']);
        $theatre->setPhone($data['phone']);
        $theatre->setEmail($data['email']);

        try {
            $theatre->save($pdo);

            echo json_encode([
                "status" => "success",
                "message" => "Theatre created successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create theatre: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Name, presentation, address, borough, geolocalisation, phone and email are required."
        ]);
    }
}