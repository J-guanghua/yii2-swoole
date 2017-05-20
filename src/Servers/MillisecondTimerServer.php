<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Servers;

use iPaya\Swoole\Handlers\AbstractHandler;
use Swoole\Server as SwooleServer;

class MillisecondTimerServer extends AbstractServer
{
    public $name = '毫秒定时器';
    /**
     * @var int 定时间隔
     */
    public $millisecond = 1000;

    /**
     * @var AbstractHandler
     */
    public $handler;

    public $swooleOptions = [
        'worker_num' => 1,
        'daemonize' => false,
    ];

    public $events = [
        'start', 'workerStart', 'connect', 'receive', 'close'
    ];

    /**
     * @param SwooleServer $server
     * @param int $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        if ($worker_id == 0) {
            $server->tick($this->millisecond, function () {
                if ($this->handler instanceof AbstractHandler) {
                    $this->handler->handle();
                }
            });
        }
    }
}
