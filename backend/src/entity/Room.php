<?php 

namespace App\Entity;

class Room {
    private $id;
    private $name;
    private $gauge;
    private $theater_id;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getGauge(): int
    {
        return $this->gauge;
    }

    public function setGauge(int $gauge): void
    {
        $this->gauge = $gauge;
    }

    public function getTheaterId(): int
    {
        return $this->theater_id;
    }

    public function setTheaterId(int $theater_id): void
    {
        $this->theater_id = $theater_id;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO room (name, gauge, theater_id) VALUES (:name, :gauge, :theater_id)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':name', $this->name);
        $stmt -> bindParam(':gauge', $this->gauge);
        $stmt -> bindParam(':theater_id', $this->theater_id);
        $stmt -> execute();

        $this->id = $pdo->lastInsertId();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM room WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':id', $this->id);
        $stmt -> execute();
    }
}