<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MetaController
{
    /** @var \League\Flysystem\FilesystemInterface */
    private $meta;

    public function __construct(ContainerInterface $container)
    {
        $this->meta = $container->get('storage')->get('meta');
    }

    public function image(Request $request, Response $response, array $args): ResponseInterface
    {
        if ($this->meta->has("{$args['type']}/{$args['id']}.jpg")) {
            $image = $this->meta->read("{$args['type']}/{$args['id']}.jpg");
            $response->write($image);

            return $response->withHeader('Content-Type', 'image/png');
        }

        return $response->withStatus(404);
    }
}