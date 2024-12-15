<?php 

namespace App\Entity;

class Theatre{
    private $id;
    private $name;
    private $presentation;
    private $address;
    private $borough;
    private $geolocalisation;
    private $phone;
    private $email;

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

    public function getPresentation(): string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): void
    {
        $this->presentation = $presentation;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getBorough(): string
    {
        return $this->borough;
    }

    public function setBorough(string $borough): void
    {
        $this->borough = $borough;
    }

    public function getGeolocalisation(): array
    {
        if (preg_match('/POINT\(([-\d.]+) ([-\d.]+)\)/', $this->geolocalisation, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2],
            ];
        }
    
        return [
            'latitude' => 0,
            'longitude' => 0,
        ];
    }
    
    

    public function setGeolocalisation(array $coordinates): void
    {
        $latitude = $coordinates['latitude'] ?? 0; // Défaut : 0 si non fourni
        $longitude = $coordinates['longitude'] ?? 0; // Défaut : 0 si non fourni
    
        $this->geolocalisation = $latitude . ' ' . $longitude;
    }
    
    

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO theatre (name, presentation, address, borough, geolocalisation, phone, email) 
                VALUES (:name, :presentation, :address, :borough, ST_GeomFromText(:geolocalisation), :phone, :email)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':presentation', $this->presentation);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':borough', $this->borough);
        $point = "POINT(" . $this->geolocalisation . ")";
        $stmt->bindParam(':geolocalisation', $point);
    
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
    
        $stmt->execute();
    }
    

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM theatre WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':id', $this->id);
        $stmt -> execute();
    }


    public function ScenaristPerTheater(\PDO $pdo, string $theater)
    {
        $sql = "SELECT DISTINCT artist.firstName, artist.lastName, theatre.name AS theatre_name
                        FROM role, artist, spectacle, representation, room, theatre
                        WHERE role.artist_id = artist.ID 
                            AND role.spectacle_id = spectacle.ID
                            AND spectacle.ID = representation.spectacle_id 
                            AND representation.room_id = room.ID 
                            AND room.theater_id = theatre.ID
                            AND role.role = 'metteur en scène' 
                            AND theatre.name = '$theater'";
        $stmt = $pdo->prepare($sql);
        $stmt -> execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    
    public function RecepyPerSpectacle(\PDO $pdo)
    {
        $sql = "SELECT spectacle.name AS spectacle_name, 
                SUM(schedule.booked * schedule.price) AS recettes
                    FROM schedule, spectacle
                    WHERE schedule.spectacle_id = spectacle.ID
                    GROUP BY spectacle.name
                    ORDER BY recettes DESC";
         $stmt = $pdo->prepare($sql);
         $stmt -> execute();
         
         return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
    }
}