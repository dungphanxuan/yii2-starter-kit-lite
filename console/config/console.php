<?php
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'command-bus' => [
            'class' => 'trntv\bus\console\BackgroundBusController',
        ],
        'message' => [
            'class' => 'console\controllers\ExtendedMessageController'
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@common/migrations/db',
            'migrationTable' => '{{%system_db_migration}}',
            'templateFile' => '@common/migrations/migration_template.php',
            'migrationNamespaces' => [
                'yii\queue\db\migrations',
            ],
        ],
        'rbac-migrate' => [
            'class' => 'console\controllers\RbacMigrateController',
            'migrationPath' => '@common/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile' => '@common/rbac/views/migration.php'
        ],
        'app-migrate' => [
            'class' => 'console\controllers\AppMigrateController',
            'migrationPath' => '@common/migrations/app',
            'migrationTable' => '{{%system_app_migration}}',
            'templateFile' => '@common/migrations/migration_template.php',
        ],
        'async-worker' => [
            'class' => 'bazilio\async\commands\AsyncWorkerCommand',
        ],
    ],
    'components' => [
        'queue' => [
            'class' => yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => [
                'class' => yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
                'db' => 'db',
            ],
        ],
    ]
];
