<?php

return [
    'settings' => [
        'addContentLengthHeader' => false,
        'displayErrorDetails' => true,
        'view' => [
            'template_path' => 'templates',
            'twig' => [
                'cache' => 'cache/twig',
                'debug' => true,
            ],
        ],
    ],
];
