# 毫秒级定时器

使用 Swoole 的 [`tick`](https://wiki.swoole.com/wiki/page/414.html) 实现。

## 使用

继承 [`src/Timer.php`](/src/Timer.php) 重写 `onWorkerStart` 方法:

```php
<?php

namespace My;

class Timer extends \iPaya\Swoole\Timer
{
    public function init()
    {
        parent::init();
        $this->on(static::EVENT_WORKER_START, function(WorkerStartEvent $event){
            if ($event->workerId == 0) {
                $event->server->tick($this->millisecond, function () use ($event) {
                    // 这里写实际业务
                });
            }
        });
    }
}
```

修改配置文件 `main.php`:

```php
<?php
return [
    // ...
    'components'=>[
        // ...
        'timer'=>[
            'class'=>'\My\Timer'
        ],
        // ...
    ]
    // ...
];
```

增加命令行命令，见 [`example/Commands/TimerController.php`](/example/Commands/TimerController.php)。

启动时使用命令:

```bash
php 命令行入口文件 timer/start
```

![定时器](/docs/guide/images/example-timer.png)
