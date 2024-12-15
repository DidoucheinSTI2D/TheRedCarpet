<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Chargement automatique des dépendances

use App\Entity\Spectacle;
use App\DB\Connector;

// Configuration des headers pour le CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Gestion de la méthode OPTIONS pour le préflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Traitement des requêtes GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Connexion à la base de données
    $connector = new Connector();
    $pdo = $connector->getPdo();

    // Instance du service contenant la fonction TopThreeSpectacle
    $Spectacle = new Spectacle();

    try {
        // Appel de la fonction TopThreeSpectacle
        $result = $Spectacle->TopThreeSpectacle($pdo);

        // Réponse avec les données retournées par la fonction
        echo json_encode([
            "status" => "success",
            "message" => "Top three categories retrieved successfully.",
            "data" => $result
        ]);
    } catch (Exception $e) {
        // Réponse en cas d'erreur interne
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Failed to retrieve top three categories: " . $e->getMessage()
        ]);
    }
} else {
    // Réponse pour les méthodes non autorisées
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Method not allowed."
    ]);
}
?>
