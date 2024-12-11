<?php

namespace App\Entity;

class Artist {
    private $id;
    private $firstName;
    private $lastName;
    private $biography;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBiography(): string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO artist (firstName, lastName, biography) VALUES (:firstName, :lastName, :biography)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':firstName', $this->firstName);
        $stmt -> bindParam(':lastName', $this->lastName);
        $stmt -> bindParam(':biography', $this->biography);
        $stmt -> execute();

        $this->id = $pdo->lastInsertId();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM artist WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':id', $this->id);
        $stmt -> execute();
    }
}