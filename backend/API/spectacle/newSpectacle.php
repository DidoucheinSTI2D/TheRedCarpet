<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Spectacle;
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

    if (
        isset($data['title']) &&
        isset($data['synopsis']) &&
        isset($data['duration']) &&
        isset($data['price']) &&
        isset($data['language']) &&
        isset($data['category_id'])
    ) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $spectacle = new Spectacle($pdo);
        $spectacle->setTitle($data['title']);
        $spectacle->setsynopsis($data['synopsis']);
        $spectacle->setDuration($data['duration']);
        $spectacle->setPrice($data['price']);
        $spectacle->setLanguage($data['language']);
        $spectacle->setCategory_Id($data['category_id']);  // Modification ici

        try {
            $spectacle->save($pdo);

            echo json_encode([
                "status" => "success",
                "message" => "Spectacle created successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create spectacle: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "All fields (title, synopsis, duration, price, language, category_id) are required."
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only POST requests are allowed."
    ]);
}
