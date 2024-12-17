<?php 

namespace App\DB;

use Dotenv\Dotenv;

class Connector {
    private $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];

        $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    
    }

    public function getPdo(): \PDO {
        return $this->pdo;
    }
}
