<?php

namespace App\Entity;

class Category
{
    private $id;
    private $name;
    private $helpText;

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

    public function getHelpText(): string
    {
        return $this->helpText;
    }

    public function setHelpText(string $helpText): void
    {
        $this->helpText = $helpText;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO category (name, helpText) VALUES (:name, :helpText)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':helpText', $this->helpText);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM category WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();


        /*/
                Entity/Category.php : 

                Pour le delete : faire en sorte que lors de la suppression d'une catégorie, on supprime la/les categories aussi dans le category_id des spectacles
        */
    }

    public function getById($id): ?array
    {
        $sql = "SELECT * FROM category WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function update(\PDO $pdo, array $updates): void
    {
        $fields = [];
        $params = [':id' => $this->id];

        foreach ($updates as $column => $value) {
            $fields[] = "$column = :$column";
            $params[":$column"] = $value;
        }

        $sql = "UPDATE category SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
    }
}