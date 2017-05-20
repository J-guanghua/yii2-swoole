<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Servers;

use Swoole\Server as SwooleServer;
use yii\console\Application;

class MillisecondTimerServer extends AbstractServer
{
    public $name = '毫秒定时器';
    /**
     * @var Application
     */
    public $console;
    /**
     * @var string 命令
     */
    public $cmd;
    /**
     * @var array 命令参数
     */
    public $cmdParams = [];
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
     * @param SwooleServer $server
     * @param int $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        if ($worker_id == 0) {
            $server->tick($this->millisecond, function () {
                $this->console->runAction($this->cmd, $this->cmdParams);
            });
        }
    }
}
