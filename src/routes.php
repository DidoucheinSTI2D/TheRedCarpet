<?php

$requestRoute = $_SERVER['REQUEST_URI'];
$requestRoute = parse_url($requestRoute, PHP_URL_PATH);

function routeName($name){
    $templatePath = __DIR__ . '/../templates';
    return $templatePath . '/' . $name . '/'. $name . '.html.php';
}

function getScript($name){
    $scriptPath = __DIR__ . '/../public/';
    return $scriptPath . '/' . $name . '.php';
}

switch($requestRoute) {
    case '/':
        require_once routeName('homepage');
        break;
    case '/test':
        echo '<h1>TestRoute</h1>';
        break;
    case '/register':
        require_once getScript('register');
        break;
    default:
        http_response_code(404);
        // vous pouvez créer une page 404 et l'inclure ici, ça fait plus propre :p
        echo '404 Not Found';
        break;
}