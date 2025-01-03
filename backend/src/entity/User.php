<?php

namespace App\Entity;

class User {
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private string $birthdate;
    private string $first_name;
    private string $last_name;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail (): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getBirthdate(): string {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate): void {
        $this->birthdate = $birthdate;
    }

    public function getFirstName(): string {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void {
        $this->first_name = $first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void {
        $this->last_name = $last_name;
    }
    
    public function save(\PDO $pdo): void {
        $sql = 'INSERT INTO SUBSCRIBER (username, password, email, birthdate, first_name, last_name) VALUES (:username, :password, :email, :birthdate, :first_name, :last_name)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':birthdate', $this->birthdate);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }

    
    public function login(\PDO $pdo, string $username, string $password): ?array {
        $sql = 'SELECT id, username, email, birthdate, password FROM SUBSCRIBER WHERE username = :username';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            
            return [
                "id" => $user['id'],
                "username" => $user['username'],
                "email" => $user['email'],
                "birthdate" => $user['birthdate'],
                "password" => $user['password']
            ];
        }
    
        return null;
    }
    
    
    public function delete(\PDO $pdo, int $id): void
    {
        $sqlDeleteSchedule = 'DELETE FROM schedule WHERE subscriber_id = :id';
        $stmtSchedule = $pdo->prepare($sqlDeleteSchedule);
        $stmtSchedule->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmtSchedule->execute();

        $sqlDeleteUser = 'DELETE FROM SUBSCRIBER WHERE id = :id';
        $stmtUser = $pdo->prepare($sqlDeleteUser);
        $stmtUser->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmtUser->execute();
    }
    


    public function update(\PDO $pdo, int $id): void{
        $sql = 'UPDATE SUBSCRIBER SET username = :username, email = :email, birthdate = :birthdate WHERE id = :id';
        $stmt = $pdo ->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':birthdate', $this->birthdate);
        $stmt->execute();
    }

    public function updatePassword(int $id, string $oldPassword, string $newPassword): bool
    {
        $sqlFetch = 'SELECT password FROM SUBSCRIBER WHERE id = :id';
        $stmtFetch = $this->pdo->prepare($sqlFetch);
        $stmtFetch->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmtFetch->execute();
        $user = $stmtFetch->fetch(\PDO::FETCH_ASSOC);

        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return false;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sqlUpdate = 'UPDATE SUBSCRIBER SET password = :password WHERE id = :id';
        $stmtUpdate = $this->pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':password', $hashedPassword, \PDO::PARAM_STR);
        $stmtUpdate->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmtUpdate->execute();
    }

}