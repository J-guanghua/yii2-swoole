<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;

use Swoole\Server;

/**
 * Class Timer
 * @package iPaya\Swoole
 */
class Timer extends AbstractServer
{
    public $name = '定时器';
    /**
     * @var int 定时间隔
     */
    public $millisecond = 1000;

    public $swooleOptions = [
        'worker_num' => 1,
        'daemonize' => false,
    ];

    public $events = [
        'start', 'workerStart', 'connect', 'receive', 'close'
    ];

    /**
     * @param Server $server
     * @param int $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        if ($worker_id == 0) {
            $server->tick($this->millisecond, function () use ($server) {
                echo "Hello! Now is " . date('Y-m-d H:i:s') . PHP_EOL;
            });
        }
    }
}
