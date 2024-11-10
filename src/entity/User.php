<?php

namespace App\Entity;

class User {
    private int $id;
    private string $username;
    private string $password;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(\PDO $pdo): void {
        $sql = 'INSERT INTO USER (username, password) VALUES (:username, :password)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }

}