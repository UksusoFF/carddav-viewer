<?php

namespace App\Controllers;

use App\Components\CardDavComponent;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class CardController
{
    private $cards;
    /** @var \Slim\Views\Twig */
    private $view;

    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');

        $this->cards = new CardDavComponent();
    }

    public function index(Request $request, Response $response): ResponseInterface
    {
        return $this->view->render($response, 'app/card/index.twig', [
            'title' => getenv('APP_NAME'),
            'cards' => $this->cards->getAll(),
        ]);
    }

    public function data(Request $request, Response $response): ResponseInterface
    {
        $data = $this->cards->getAll();

        return $response->withJson($data, 201);
    }
}
