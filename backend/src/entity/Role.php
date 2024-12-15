<?php 

namespace App\Entity;

class Role {
    private $role;
    private $artist_id;
    private $spectacle_id;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setArtistId(int $artist_id): void
    {
        $this->artist_id = $artist_id;
    }

    public function getArtistId(): int
    {
        return $this->artist_id;
    }

    public function setSpectacleId(int $spectacle_id): void
    {
        $this->spectacle_id = $spectacle_id;
    }

    public function getSpectacleId(): int
    {
        return $this->spectacle_id;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO role (role, artist_id, spectacle_id) VALUES (:role, :artist_id, :spectacle_id)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':role', $this->role);
        $stmt -> bindParam(':artist_id', $this->artist_id);
        $stmt -> bindParam(':spectacle_id', $this->spectacle_id);
        $stmt -> execute();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM role WHERE role = :role";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':role', $this->role);
        $stmt -> execute();
    }
    
}