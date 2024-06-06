<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\App;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new App();
$app->handleRequest();
