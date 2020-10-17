<?php

namespace App\Controllers;

use App\Components\CardDavComponent;
use League\Flysystem\FileNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class CardController
{
    private $cards;

    /** @var \Slim\Views\Twig */
    private $view;

    /** @var \League\Flysystem\FilesystemInterface */
    private $meta;

    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');

        $this->meta = $container->get('storage')->get('meta');

        $this->cards = new CardDavComponent();
    }

    public function index(Request $request, Response $response): ResponseInterface
    {
        try {
            $viber = collect(json_decode($this->meta->read('viber/meta.json'), true));
        } catch (FileNotFoundException $exception) {
            $viber = collect([]);
        }

        $cards = array_map(static function($card) use ($viber) {
            return [
                'firstname' => $card->firstname,
                'lastname' => $card->lastname,
                'note' => $card->note ?? '',
                'categories' => $card->categories,
                'phones' => array_flatten(array_map(static function($phone) use ($viber) {
                    $phones = [];

                    foreach ($phone as $p) {
                        $phones[] = (object)[
                            'number' => $p,
                            'viber' => (object)$viber->firstWhere('phone', $p),
                        ];
                    }

                    return $phones;
                }, $card->phone)),
            ];
        }, $this->cards->getAll());

        return $this->view->render($response, 'card/index.twig', [
            'title' => getenv('APP_NAME'),
            'cards' => $cards,
        ]);
    }

    public function data(Request $request, Response $response): ResponseInterface
    {
        $data = $this->cards->getAll();

        return $response->withJson($data, 201);
    }
}
