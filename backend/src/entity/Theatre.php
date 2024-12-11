<?php 

namespace App\Entity;

class Theatre{
    private $id;
    private $name;
    private $presentation;
    private $address;
    private $borough;
    private $geolocation;
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

    public function getGeolocation(): string
    {
        return $this->geolocation;
    }

    public function setGeolocation(string $geolocation): void
    {
        $this->geolocation = $geolocation;
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
        $sql = "INSERT INTO theatre (name, presentation, address, borough, geolocation, phone, email) VALUES (:name, :presentation, :address, :borough, :geolocation, :phone, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':name', $this->name);
        $stmt -> bindParam(':presentation', $this->presentation);
        $stmt -> bindParam(':address', $this->address);
        $stmt -> bindParam(':borough', $this->borough);
        $stmt -> bindParam(':geolocation', $this->geolocation);
        $stmt -> bindParam(':phone', $this->phone);
        $stmt -> bindParam(':email', $this->email);
        $stmt->execute();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM theatre WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':id', $this->id);
        $stmt -> execute();
    }
}