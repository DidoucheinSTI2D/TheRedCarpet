<?php

namespace App\Entity;

class Room
{
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
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':gauge', $this->gauge);
        $stmt->bindParam(':theater_id', $this->theater_id);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM room WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function findRoomByBorough(string $borough): array
    {
        $sql = "SELECT room.id, room.name, room.gauge, room.theater_id
                FROM room
                JOIN theatre ON room.theater_id = theatre.id
                WHERE theatre.borough = :borough";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':borough', $borough, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDistinctLieux(): array
    {

        /**
         * Récupère la liste des lieux distincts des spectacles.
         *
         * @return array Liste des lieux.
         * @throws \Exception En cas d'erreur lors de la récupération.
         */

        try {
            // Préparer et exécuter la requête SQL
            $stmt = $this->pdo->prepare("SELECT DISTINCT lieu FROM spectacles ORDER BY lieu ASC");
            $stmt->execute();

            // Récupérer les résultats
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PdoException $e) {
            // Gérer les exceptions et remonter une erreur explicite
            throw new \Exception("Erreur lors de la récupération des lieux : " . $e->getMessage());
        }
    }



}