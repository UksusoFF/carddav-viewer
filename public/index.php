<?php

use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

session_start();

if (file_exists(__DIR__ . '/../config/settings.php')) {
    $settings = require __DIR__ . '/../config/settings.php';
} else {
    $settings = require __DIR__ . '/../config/settings.php.dist';
}

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

// Instantiate Slim
$app = new \Slim\App($settings);

require __DIR__ . '/../bootstrap/dependencies.php';
require __DIR__ . '/../routes/web.php';

$app->add(new \Tuupola\Middleware\HttpBasicAuthentication([
    'secure' => false,
    'users' => [
        'access' => getenv('ACCESS_PASSWORD'),
    ],
]));

$app->run();
