<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

return [
    'id' => 'console',
    'basePath' => __DIR__ . '/../app',
    'enableCoreCommands' => false,
    'runtimePath' => __DIR__ . '/../runtime',
    'controllerNamespace' => 'App\Commands',
    'aliases' => [
        '@App' => __DIR__ . '/../app/',
        '@iPaya/Swoole' => __DIR__ . '/../../src'
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0
        ],
        'queue' => [
            'class' => 'iPaya\Swoole\Queue',
            'redis' => 'redis'
        ],
        'timer' => [
            'class' => 'iPaya\Swoole\Timer'
        ],
        'asyncTask' => [
            'class' => 'iPaya\Swoole\AsyncTaskServer',
            'queue' => 'queue',
            'listen' => [
                ['127.0.0.1', 9052]
            ]
        ]
    ]
];
