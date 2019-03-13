<?php

return [
    'settings' => [
        'addContentLengthHeader' => false,
        'displayErrorDetails' => true,
        'view' => [
            'template_path' => 'resources/templates',
            'twig' => [
                'cache' => 'cache/twig',
                'debug' => true,
            ],
        ],
    ],
];
