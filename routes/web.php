<?php

$container = $app->getContainer();

$app->get('/', \App\Controllers\CardController::class . ':index')->setName('card:index');
$app->get('/data', \App\Controllers\CardController::class . ':data')->setName('card:data');
