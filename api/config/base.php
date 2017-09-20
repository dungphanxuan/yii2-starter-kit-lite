<?php
return [
    'id'         => 'api',
    'basePath'   => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        //'cache' => require(__DIR__.'/_cache.php'),
    ],
];
