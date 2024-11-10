<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Entity\User;
use App\DB\Connector;

$connector = new Connector();
$pdo = $connector->getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($pdo);
    $user->setUsername($_POST['username']);
    $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
    $user->save($pdo);
}

require routeName('register');