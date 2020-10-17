<?php

use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

session_start();

$settings = require __DIR__ . '/../config/settings.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

// Instantiate Slim
$app = new \Slim\App($settings);

require __DIR__ . '/../bootstrap/dependencies.php';
require __DIR__ . '/../routes/web.php';

$app->add(new \Tuupola\Middleware\HttpBasicAuthentication([
    'secure' => false,
    'users' => [
        'user' => getenv('ACCESS_PASSWORD'),
    ],
    'path' => '/*',
    'ignore' => [
        '/.well-known/*',
        '/baikal/*',
    ],
]));

$container = $app->getContainer();

$container['storage'] = function ($container) {
    return new \Ilhamarrouf\Filesystem\FilesystemManager($container);
};

$app->run();
