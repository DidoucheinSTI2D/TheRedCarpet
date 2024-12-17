<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\DB\Connector;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    try {

        $connector = new Connector();
        $pdo = $connector->getPdo();


        $stmt = $pdo->prepare("SELECT DISTINCT lieu FROM spectacles ORDER BY lieu ASC");
        $stmt->execute();


        $lieux = $stmt->fetchAll(PDO::FETCH_ASSOC);

/// APRES TU FAIS LE 14
/// APRES TU CREER L'API.TS POUR LE 14
/// FAUT FAIRE CA CE SOIR SANS FAUTE TAFFE AU LIEU DE JOUER A FIFA SALE FRAUDE


        echo json_encode([
            "status" => "success",
            "data" => $lieux
        ]);

    } catch (Exception $e) {

        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Une erreur est survenue lors de la récupération des lieux : " . $e->getMessage()
        ]);
    }
} else {

    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Seules les requêtes GET sont autorisées."
    ]);
}

