<?php

$app->get('/{type}/{id}.jpg', \App\Controllers\MetaController::class . ':image')->setName('meta:image');
$app->get('/data', \App\Controllers\CardController::class . ':data')->setName('card:data');
$app->get('/', \App\Controllers\CardController::class . ':index')->setName('card:index');
