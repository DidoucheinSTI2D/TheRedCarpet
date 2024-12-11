<?php 

namespace App\Entity;

class Representation {
    private $first_date;
    private $last_date;
    private $spectacle_id;
    private $room_id;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setFirstDate(string $first_date): void
    {
        $this->first_date = $first_date;
    }

    public function getFirstDate(): string
    {
        return $this->first_date;
    }

    public function setLastDate(string $last_date): void
    {
        $this->last_date = $last_date;
    }

    public function getLastDate(): string
    {
        return $this->last_date;
    }

    public function setSpectacleId(int $spectacle_id): void
    {
        $this->spectacle_id = $spectacle_id;
    }

    public function getSpectacleId(): int
    {
        return $this->spectacle_id;
    }

    public function setRoomId(int $room_id): void
    {
        $this->room_id = $room_id;
    }

    public function getRoomId(): int
    {
        return $this->room_id;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO representation (first_date, last_date, spectacle_id, room_id) VALUES (:first_date, :last_date, :spectacle_id, :room_id)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':first_date', $this->first_date);
        $stmt -> bindParam(':last_date', $this->last_date);
        $stmt -> bindParam(':spectacle_id', $this->spectacle_id);
        $stmt -> bindParam(':room_id', $this->room_id);
        $stmt -> execute();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM representation WHERE first_date = :first_date AND last_date = :last_date AND spectacle_id = :spectacle_id AND room_id = :room_id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':first_date', $this->first_date);
        $stmt -> bindParam(':last_date', $this->last_date);
        $stmt -> bindParam(':spectacle_id', $this->spectacle_id);
        $stmt -> bindParam(':room_id', $this->room_id);
        $stmt -> execute();
    }
}