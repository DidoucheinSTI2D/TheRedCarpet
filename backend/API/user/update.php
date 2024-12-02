<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\User;
use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['username']) &&  isset($data['email']) && isset($data['birthdate'])) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $user = new User($pdo);
        $user->setUsername($data['username']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $user->setEmail($data['email']);
        $user->setBirthdate($data['birthdate']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);

        try {
            $user->update($pdo, $data['id']);

            echo json_encode([
                "status" => "success",
                "message" => "User registered successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to modify user: " . $e->getMessage()
            ]);
        }
    }
}
?>