<?php
require 'C:\Users\marti\Documents\GitHub\TheRedCarpet\vendor\autoload.php';

use Faker\Factory;

// Connexion à la base de données
$host = '127.0.0.1';
$db = 'c';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connexion à la base de données réussie.\n";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$faker = Factory::create('fr_FR');

// --------------------------- INSERT TABLE "category" ---------------------------
echo "Insertion des catégories...\n";
$nbCategories = 10;
$category_ids = [];
for ($i = 0; $i < $nbCategories; $i++) {
    $stmt = $pdo->prepare("INSERT INTO category (name, helpText) VALUES (?, ?)");
    $stmt->execute([
        $faker->word,
        $faker->sentence
    ]);
    $category_ids[] = $pdo->lastInsertId();
}

// --------------------------- INSERT TABLE "spectacle" ---------------------------
echo "Insertion des spectacles...\n";
$nbSpectacles = 50;
$spectacle_ids = [];
for ($i = 0; $i < $nbSpectacles; $i++) {
    $stmt = $pdo->prepare("INSERT INTO spectacle (title, synopsis, duration, price, language, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $faker->sentence(3),
        $faker->paragraph,
        $faker->time('H:i:s'),
        $faker->randomFloat(2, 10, 100),
        $faker->randomElement(['français', 'VO', 'surtitré', 'audio']),
        $faker->randomElement($category_ids)
    ]);
    $spectacle_ids[] = $pdo->lastInsertId();
}

// --------------------------- INSERT TABLE "subscriber" ---------------------------
echo "Insertion des abonnés...\n";
$nbSubscribers = 200;
$subscriber_ids = [];
for ($i = 0; $i < $nbSubscribers; $i++) {
    $stmt = $pdo->prepare("INSERT INTO subscriber (username, password, email, birthdate, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $faker->userName,
        password_hash($faker->password, PASSWORD_BCRYPT),
        $faker->email,
        $faker->date('Y-m-d'),
        $faker->firstName,
        $faker->lastName
    ]);
    $subscriber_ids[] = $pdo->lastInsertId();
}

// --------------------------- INSERT TABLE "artist" ---------------------------
echo "Insertion des artistes...\n";
$nbArtists = 30;
$artist_ids = [];
for ($i = 0; $i < $nbArtists; $i++) {
    $stmt = $pdo->prepare("INSERT INTO artist (firstName, lastName, biography) VALUES (?, ?, ?)");
    $stmt->execute([
        $faker->firstName,
        $faker->lastName,
        $faker->paragraph
    ]);
    $artist_ids[] = $pdo->lastInsertId();
}

// --------------------------- INSERT TABLE "role" ---------------------------
echo "Insertion des rôles...\n";
$nbRoles = 50;
for ($i = 0; $i < $nbRoles; $i++) {
    $stmt = $pdo->prepare("INSERT INTO role (role, artist_id, spectacle_id) VALUES (?, ?, ?)");
    $stmt->execute([
        $faker->jobTitle,
        $faker->randomElement($artist_ids),
        $faker->randomElement($spectacle_ids)
    ]);
}

// --------------------------- INSERT TABLE "theatre" ---------------------------
echo "Insertion des théâtres...\n";
$nbTheatres = 5;
$theatre_ids = [];
for ($i = 0; $i < $nbTheatres; $i++) {
    $stmt = $pdo->prepare("INSERT INTO theatre (name, presentation, address, borough, geolocalisation, phone, email) VALUES (?, ?, ?, ?, POINT(?, ?), ?, ?)");
    $stmt->execute([
        $faker->company,
        $faker->paragraph,
        $faker->address,
        $faker->numberBetween(1, 20),
        $faker->latitude, $faker->longitude,
        $faker->phoneNumber,
        $faker->email
    ]);
    $theatre_ids[] = $pdo->lastInsertId();
}

// --------------------------- INSERT TABLE "room" ---------------------------
echo "Insertion des salles...\n";
$nbRooms = 20;
$room_ids = [];
for ($i = 0; $i < $nbRooms; $i++) {
    $stmt = $pdo->prepare("INSERT INTO room (name, gauge, theater_id) VALUES (?, ?, ?)");
    $stmt->execute([
        $faker->randomLetter,
        $faker->numberBetween(50, 500),
        $faker->randomElement($theatre_ids)
    ]);
    $room_ids[] = $pdo->lastInsertId();
}

// --------------------------- INSERT TABLE "representation" ---------------------------
echo "Insertion des représentations...\n";
$nbRepresentations = 100;
for ($i = 0; $i < $nbRepresentations; $i++) {
    $stmt = $pdo->prepare("INSERT INTO representation (first_date, last_date, spectacle_id, room_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s'),
        $faker->dateTimeBetween('+1 day', '+2 months')->format('Y-m-d H:i:s'),
        $faker->randomElement($spectacle_ids),
        $faker->randomElement($room_ids)
    ]);
}

// --------------------------- INSERT TABLE "schedule" ---------------------------
echo "Insertion des horaires...\n";
$nbSchedules = 300;
for ($i = 0; $i < $nbSchedules; $i++) {
    $stmt = $pdo->prepare("INSERT INTO schedule (date, booked, paid, amount, comment, notation, reactions, spectacle_id, subscriber_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s'),
        $faker->numberBetween(0, 1),
        $faker->numberBetween(0, 1),
        $faker->randomFloat(2, 10, 100),
        $faker->sentence(6),
        $faker->numberBetween(1, 5),
        json_encode(['reaction' => $faker->word]),
        $faker->randomElement($spectacle_ids),
        $faker->randomElement($subscriber_ids)
    ]);
}

echo "Toutes les données ont été insérées avec succès !";
?>
