<?php

$container = $app->getContainer();

$container['view'] = function($c) {
    $view = new \Slim\Views\Twig($c['settings']['view']['template_path'], $c['settings']['view']['twig']);
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));
    $view->addExtension(new \Twig\Extension\DebugExtension());
    return $view;
};
