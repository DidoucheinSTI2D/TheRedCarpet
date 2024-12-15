<?php

namespace App\Entity;

class Spectacle {
    private $id;
    private $title;
    private $synopsis;
    private $duration;
    private $price;
    private $language;
    private $category_id;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getCategory_id(): int
    {
        return $this->category_id;
    }

    public function setCategory_id(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function addCategory_id(int $category_id): void
    {
        $this->category_id[] = $category_id;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO spectacle (title, synopsis, duration, price, language, category_id) VALUES (:title, :synopsis, :duration, :price, :language, :category_id)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt -> bindParam(':synopsis', $this->synopsis, \PDO::PARAM_STR);
        $stmt -> bindParam(':duration', $this->duration, \PDO::PARAM_STR);
        $stmt -> bindParam(':price', $this->price, \PDO::PARAM_STR);
        $stmt -> bindParam(':language', $this->language, \PDO::PARAM_STR);
        $stmt -> bindParam(':category_id', $this->category_id, \PDO::PARAM_INT);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }
    
    public function delete(\PDO $pdo): void
    {
        $sqlRole = "DELETE FROM role WHERE spectacle_id = :id";
        $stmtRole = $pdo->prepare($sqlRole);
        $stmtRole->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmtRole->execute();

        $sqlSchedule = "DELETE FROM schedule WHERE spectacle_id = :id";
        $stmtSchedule = $pdo->prepare($sqlSchedule);
        $stmtSchedule->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmtSchedule->execute();

        $sqlRepresentation = "DELETE FROM representation WHERE spectacle_id = :id";
        $stmtRepresentation = $pdo->prepare($sqlRepresentation);
        $stmtRepresentation->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmtRepresentation->execute();

        $sql = "DELETE FROM spectacle WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmt->execute();
    }
    
    

    public function getSpectacleByFilter(\PDO $pdo, $filter): array
    {
        $sql = "SELECT * FROM spectacle WHERE title LIKE :filter OR synopsis LIKE :filter OR duration LIKE :filter OR price LIKE :filter OR language LIKE :filter OR category_id LIKE :filter";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':filter', $filter, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}