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
    /**
     * @var MillisecondTimerServer
     */
    public $server;
    /**
     * @var Application
     */
    public $console;
    /**
     * @var 命令
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


    public function init()
    {
        $this->server = new SwooleServer('127.0.0.1', 9051);
        $this->server->set([
            'worker_num' => 1,
            'daemonize' => false,
        ]);
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
        $this->server->on('connect', [$this, 'onConnect']);
        $this->server->on('receive', [$this, 'onReceive']);
        $this->server->on('close', [$this, 'onClose']);
    }

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

    public function onConnect()
    {
        echo __METHOD__;
    }

    public function onReceive($server, $fd, $from_id, $data)
    {
        echo __METHOD__;
        $server->close($fd);
    }

    public function onClose()
    {
        echo __METHOD__;
    }

    /**
     * @inheritDoc
     */
    public function start()
    {
        $this->server->start();
    }

    /**
     * @inheritDoc
     */
    public function shutdown()
    {
        // TODO: Implement shutdown() method.
    }


}