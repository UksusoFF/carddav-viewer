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

        'filesystem' => [
            'default' => 'meta',
            'disks' => [
                'meta' => [
                    'driver' => 'local',
                    'root' => __DIR__ . '/../storage/meta/',
                    'url' => $_SERVER['HTTP_HOST'] . '/../storage',
                    'visibility' => 'private',
                ],
            ],
        ],
    ],
];
