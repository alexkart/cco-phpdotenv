<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = new \Slim\App;

$container = $app->getContainer();

$container['db'] = function () {
    return new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
};

$app->get('/', function (Request $request, Response $response) {
    $users = $this->db->query('SELECT * FROM users');

    return $response->withJson($users->fetchAll(PDO::FETCH_OBJ));
});

$app->run();