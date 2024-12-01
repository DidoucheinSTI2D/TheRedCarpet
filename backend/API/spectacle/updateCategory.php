<?php 

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Entity\Category;
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

    if (isset($data['id']) && (isset($data['name']) || isset($data['helpText']))) {
        $connector = new Connector();
        $pdo = $connector->getPdo();

        $category = new Category($pdo);
        $category->setId($data['id']);
        
        $existingCategory = $category->getById($data['id']);
        if (!$existingCategory) {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "Category not found."
            ]);
            exit();
        }

        $updates = [];
        if (isset($data['name']) && $data['name'] !== $existingCategory['name']) {
            $updates['name'] = $data['name'];
        }
        if (isset($data['helpText']) && $data['helpText'] !== $existingCategory['helpText']) {
            $updates['helpText'] = $data['helpText'];
        }

        if (empty($updates)) {
            echo json_encode([
                "status" => "success",
                "message" => "No changes detected."
            ]);
            exit();
        }

        try {
            $category->update($pdo, $updates);

            echo json_encode([
                "status" => "success",
                "message" => "Category updated successfully."
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update category: " . $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "ID, name or help text are required."
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only PATCH requests are allowed."
    ]);
}
