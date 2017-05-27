<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;

use iPaya\Swoole\Events\WorkerStartEvent;

/**
 * Class Timer
 * @package iPaya\Swoole
 */
class Timer extends Server
{
    public $name = '定时器';
    /**
     * @var int 定时间隔
     */
    public $millisecond = 1000;
    public $enabledEvents = [
        'start', 'workerStart', 'receive'
    ];
    public $swooleOptions = [
        'worker_num' => 1,
    ];

    public function init()
    {
        parent::init();
        $this->on(static::EVENT_WORKER_START, [$this, 'onWorkerStart']);
    }

    /**
     * @param WorkerStartEvent $event
     */
    public function onWorkerStart($event)
    {
        if ($event->workerId == 0) {
            $event->server->tick($this->millisecond, function () {
                echo "Hello! Now is " . date('Y-m-d H:i:s') . PHP_EOL;
            });
        }
    }
}
