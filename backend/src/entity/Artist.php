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
  
    public function ArtistInCommon(\PDO $pdo, string $entree)
    {
        $sql = "SELECT artist.firstName AS firstName_1, 
                       artist_2.firstName AS firstName_2, 
                        COUNT(DISTINCT role.spectacle_id) AS common_spectacles
                    FROM role JOIN role AS role_2 
                        ON role.spectacle_id = role_2.spectacle_id 
                        AND role.artist_id <> role_2.artist_id  -- Différents artistes dans le même spectacle
                    JOIN artist ON role.artist_id = artist.ID  -- Premier artiste
                    JOIN artist AS artist_2 ON role_2.artist_id = artist_2.ID  -- Deuxième artiste
                        WHERE artist.firstName LIKE '$entree'
                        OR   artist.lastName LIKE '$entree'-- Prénom de l'artiste donné
                    GROUP BY artist.firstName, artist_2.firstName
                    HAVING COUNT(DISTINCT role.spectacle_id) >= 2";

        $stmt = $pdo->prepare($sql);
        $stmt -> execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);   

    }
  
      function getArtistsWithThreeRoles(): array {
        $sql = " SELECT r.artist_id, COUNT(DISTINCT r.role) AS role_count FROM role r GROUP BY r.artist_id HAVING COUNT(DISTINCT r.role) >= 3;";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}