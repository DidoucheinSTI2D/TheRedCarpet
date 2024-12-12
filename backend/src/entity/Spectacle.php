<?php

namespace App\Entity;

class Spectacle
{
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getsynopsis(): string
    {
        return $this->synopsis;
    }

    public function setsynopsis(string $synopsis): void
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
        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindParam(':synopsis', $this->synopsis, \PDO::PARAM_STR);
        $stmt->bindParam(':duration', $this->duration, \PDO::PARAM_STR);
        $stmt->bindParam(':price', $this->price, \PDO::PARAM_STR);
        $stmt->bindParam(':language', $this->language, \PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $this->category_id, \PDO::PARAM_INT);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }

    public function delete(\PDO $pdo, int $id): void
    {
        $sql = 'DELETE FROM SPECTACLE WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}