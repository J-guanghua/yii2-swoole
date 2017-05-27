# AsyncTask 异步任务服务器

异步任务服务器是处理耗时任务的首选。

## 使用

如示例代码中，通过一个简单的队列，每隔 1 秒检查一次是否有新的任务，有新任务时，将任务发送给 `TaskWorker` 执行。

配置 redis:

```php
<?php
return [
    // ...
    'components'=>[
        // ...
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0
        ],
        // ...
    ]
    // ...
];
```

配置 `queue` 队列:

```php
<?php
return [
    // ...
    'components'=>[
        // ...
        'queue' => [
            'class' => 'iPaya\Swoole\Redis\Queue',
            // 上面配置的 redis
            'redis' => 'redis'
        ],
        // ...
    ]
    // ...
];
```

如果要实现自己队列需要继承 `iPaya\Swoole\Queue` 类。

配置 `asyncTask`:

```php
<?php
return [
    // ...
    'components'=>[
        // ...
        'asyncTask' => [
            'class' => 'iPaya\Swoole\AsyncTask\Server',
            // 上面配置的 queue 队列
            'queue' => 'queue',
            // 监听地址及端口，每隔数组一条，第一个元素是地址，第二个元素是端口
            'listen' => [
                ['127.0.0.1', 9052]
            ]
        ]
        // ...
    ]
    // ...
];
```

增加命令行命令，见 [`example/Commands/AsyncTaskController.php`](/example/Commands/AsyncTaskController.php)。

启动 AsyncTask 服务器，使用命令:

```bash
php 命令行入口文件 async-task/start
```

![AsyncTask 启动](/docs/guide/images/example-async-task-start.png)

推送任务到队列，示例中实现了一个让服务器端打印的任务和一个发送邮件的任务:

1. 服务器端打印字符

执行命令:

```bash
php 命令行入口文件 async-task/try-echo
```

![AsyncTask 服务器端打印字符](/docs/guide/images/example-async-task-try-echo.png)

2. 发送邮件任务

此功能需要配置 `mailer`:

```php
<?php
return [
    // ...
    'components'=>[
        // ...
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // 这里是模拟发送，会将邮件保存到 runtime/mail 目录，生产环境需配置为 false
            'useFileTransport' => true,
            // ...
        ],
        // ...
    ]
    // ...
];
```

执行命令

```bash
php 命令行入口文件 async-task/try-emails
```

执行后可以在 `example/runtime/mail/` 目录中查看是否有发送过来的邮件。

## 自定义任务

通过继承 [src/AbstractJob.php](/src/AbstractJob.php) 来实现自定义的任务，在 `run` 方法中来执行自己的业务，
也可以通过实现接口 [src/JobInterface.php](/src/JobInterface.php) 来实现，但是创建的类必须要继承 `\yii\base\Object`, 
因为在反序列化队列消息时，使用到了 `Yii::createObject()`。
