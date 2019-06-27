<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Pages
        ['pattern' => 'page/<slug>', 'route' => 'page/view'],

        // Articles
        ['pattern' => 'article/<id:\d+>/<name>', 'route' => 'article/view'],
        ['pattern' => 'article/<id:\d+>', 'route' => 'article/view'],
        'article/<action:[\w-]+>' => 'article/<action>',

    ]
];
