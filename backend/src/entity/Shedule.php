<?php 

class Shedule{
    private $date;
    private $booked;
    private $paid;
    private $amount;
    private $comment;
    private $notation;
    private $reactions;
    private $spectacle_id;
    private $subscriber_id;

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setBooked(bool $booked): void
    {
        $this->booked = $booked;
    }

    public function getBooked(): bool
    {
        return $this->booked;
    }

    public function setPaid(bool $paid): void
    {
        $this->paid = $paid;
    }

    public function getPaid(): bool
    {
        return $this->paid;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setNotation(string $notation): void
    {
        $this->notation = $notation;
    }

    public function getNotation(): string
    {
        return $this->notation;
    }

    public function setReactions(string $reactions): void
    {
        $this->reactions = $reactions;
    }

    public function getReactions(): string
    {
        return $this->reactions;
    }

    public function setSpectacleId(int $spectacle_id): void
    {
        $this->spectacle_id = $spectacle_id;
    }

    public function getSpectacleId(): int
    {
        return $this->spectacle_id;
    }

    public function setSubscriberId(int $subscriber_id): void
    {
        $this->subscriber_id = $subscriber_id;
    }

    public function getSubscriberId(): int
    {
        return $this->subscriber_id;
    }

    public function save(\PDO $pdo): void
    {
        $sql = "INSERT INTO shedule (date, booked, paid, amount, comment, notation, reactions, spectacle_id, subscriber_id) VALUES (:date, :booked, :paid, :amount, :comment, :notation, :reactions, :spectacle_id, :subscriber_id)";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':date', $this->date);
        $stmt -> bindParam(':booked', $this->booked);
        $stmt -> bindParam(':paid', $this->paid);
        $stmt -> bindParam(':amount', $this->amount);
        $stmt -> bindParam(':comment', $this->comment);
        $stmt -> bindParam(':notation', $this->notation);
        $stmt -> bindParam(':reactions', $this->reactions);
        $stmt -> bindParam(':spectacle_id', $this->spectacle_id);
        $stmt -> bindParam(':subscriber_id', $this->subscriber_id);
        $stmt -> execute();
    }

    public function delete(\PDO $pdo): void
    {
        $sql = "DELETE FROM shedule WHERE date = :date";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':date', $this->date);
        $stmt -> execute();
    }
}