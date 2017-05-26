<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;

use iPaya\Swoole\Events\CloseEvent;
use iPaya\Swoole\Events\ConnectEvent;
use iPaya\Swoole\Events\FinishEvent;
use iPaya\Swoole\Events\ManagerStartEvent;
use iPaya\Swoole\Events\ManagerStopEvent;
use iPaya\Swoole\Events\PacketEvent;
use iPaya\Swoole\Events\PipeMessageEvent;
use iPaya\Swoole\Events\ReceiveEvent;
use iPaya\Swoole\Events\ShutdownEvent;
use iPaya\Swoole\Events\StartEvent;
use iPaya\Swoole\Events\TaskEvent;
use iPaya\Swoole\Events\WorkerErrorEvent;
use iPaya\Swoole\Events\WorkerStartEvent;
use iPaya\Swoole\Events\WorkerStopEvent;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class Server extends Component
{
    /**
     * @event 启动事件
     */
    const EVENT_START = 'start';
    /**
     * @event 停止事件
     */
    const EVENT_SHUTDOWN = 'shudown';
    /**
     * @event Worker 启动事件
     */
    const EVENT_WORKER_START = 'workerStart';
    /**
     * @event Worker 停止事件
     */
    const EVENT_WORKER_STOP = 'workerStop';
    /**
     * @event 新连接进入事件
     */
    const EVENT_CONNECT = 'connect';
    /**
     * @event 接收数据事件
     */
    const EVENT_RECEIVE = 'receive';
    /**
     * @event 接收到 UDP 数据包事件
     */
    const EVENT_PACKET = 'packet';
    /**
     * @event TCP 客户端连接关闭事件
     */
    const EVENT_CLOSE = 'close';
    /**
     * @event 新任务事件
     */
    const EVENT_TASK = 'task';
    /**
     * @event 完成任务事件
     */
    const EVENT_FINISH = 'finish';
    /**
     * @event 接收到管道消息事件
     */
    const EVENT_PIPE_MESSAGE = 'pipeMessage';
    /**
     * @event Worker/TaskWorker 进程异常事件
     */
    const EVENT_WORKER_ERROR = 'workerError';
    /**
     * @event 管理进程启动事件
     */
    const EVENT_MANAGER_START = 'managerStart';
    /**
     * @event 管理进程结束事件
     */
    const EVENT_MANAGER_STOP = 'managerStop';

    public $listen;
    /**
     * @var \Swoole\Server
     */
    public $server;
    public $mode = SWOOLE_PROCESS;
    public $sockType = SWOOLE_SOCK_TCP;
    public $swooleOptions = [];
    /**
     * @var array
     */
    public $enabledEvents = [];
    /**
     * @var array
     */
    public $availableEvents = [
        'start' => 'onSwooleStart',
        'shutdown' => 'onSwooleShutdown',
        'workerStart' => 'onSwooleWorkerStart',
        'workerStop' => 'onSwooleWorkerStop',
        'connect' => 'onSwooleConnect',
        'receive' => 'onSwooleReceive',
        'packet' => 'onSwoolePacket',
        'close' => 'onSwooleClose',
        'task' => 'onSwooleTask',
        'finish' => 'onSwooleFinish',
        'pipeMessage' => 'onSwoolePipeMessage',
        'workerError' => 'onSwooleWorkerError',
        'managerStart' => 'onSwooleManagerStart',
        'managerStop' => 'onSwooleManagerStop',
    ];


    public function init()
    {
        parent::init();
        if ($this->listen == null) {
            throw new InvalidConfigException('请配置监听地址及端口 "listen"。');
        }
    }

    public function start()
    {
        $this->server = $this->createServer('\Swoole\Server');
        $this->server->set($this->swooleOptions);

        $this->server->start();
    }

    /**
     * @return null|\Swoole\Server|\Swoole\WebSocket\Server
     */
    public function createServer($serverClass)
    {
        /** @var \Swoole\Server $server */
        $server = null;
        foreach ($this->listen as $index => $address) {
            list($host, $port) = $address;
            if ($index == 0) {
                $server = new $serverClass($host, $port, $this->mode, $this->sockType);
            } else {
                $server->addlistener($host, $port, $this->sockType);
            }
        }
        foreach ($this->enabledEvents as $event) {
            $method = ArrayHelper::getValue($this->availableEvents, $event);
            $server->on($event, [$this, $method]);
        }
        return $server;
    }

    /**
     * @param \Swoole\Server $server
     */
    public function onSwooleStart($server)
    {
        $this->trigger(static::EVENT_START, new StartEvent([
            'server' => $server,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     */
    public function onSwooleShutdown($server)
    {
        $this->trigger(static::EVENT_SHUTDOWN, new ShutdownEvent([
            'server' => $server
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $worker_id
     */
    public function onSwooleWorkerStart($server, $worker_id)
    {
        $this->trigger(static::EVENT_WORKER_START, new WorkerStartEvent([
            'server' => $server,
            'workerId' => $worker_id,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $worker_id
     */
    public function onSwooleWorkerStop($server, $worker_id)
    {
        $this->trigger(static::EVENT_WORKER_STOP, new WorkerStopEvent([
            'server' => $server,
            'workerId' => $worker_id,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onSwooleConnect($server, $fd, $reactorId)
    {
        $this->trigger(static::EVENT_CONNECT, new ConnectEvent([
            'server' => $server,
            'fd' => $fd,
            'reactorId' => $reactorId,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $fd
     * @param int $reactorId
     * @param string $content
     */
    public function onSwooleReceive($server, $fd, $reactorId, $content)
    {
        $this->trigger(static::EVENT_RECEIVE, new ReceiveEvent([
            'server' => $server,
            'fd' => $fd,
            'reactorId' => $reactorId,
            'content' => $content
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param string $content
     * @param array $client_info
     */
    public function onSwoolePacket($server, $content, array $client_info)
    {
        $this->trigger(static::EVENT_PACKET, new PacketEvent([
            'server' => $server,
            'content' => $content,
            'clientInfo' => $client_info,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onSwooleClose($server, $fd, $reactorId)
    {
        $this->trigger(static::EVENT_CLOSE, new CloseEvent([
            'server' => $server,
            'fd' => $fd,
            'reactorId' => $reactorId,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $taskId
     * @param int $workerId
     * @param mixed $content
     */
    public function onSwooleTask($server, $taskId, $workerId, $content)
    {
        $this->trigger(static::EVENT_TASK, new TaskEvent([
            'server' => $server,
            'taskId' => $taskId,
            'workerId' => $workerId,
            'content' => $content
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $taskId
     * @param string $content
     */
    public function onSwooleFinish($server, $taskId, $content)
    {
        $this->trigger(static::EVENT_FINISH, new FinishEvent([
            'server' => $server,
            'taskId' => $taskId,
            'content' => $content
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $workerId
     * @param string $message
     */
    public function onSwoolePipeMessage($server, $workerId, $message)
    {
        $this->trigger(static::EVENT_PIPE_MESSAGE, new PipeMessageEvent([
            'server' => $server,
            'workerId' => $workerId,
            'message' => $message,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     * @param int $workerId
     * @param int $workerPid
     * @param int $exitCode
     * @param int $signal
     */
    public function onSwooleWorkerError($server, $workerId, $workerPid, $exitCode, $signal)
    {
        $this->trigger(static::EVENT_WORKER_ERROR, new WorkerErrorEvent([
            'server' => $server,
            'workerId' => $workerId,
            'workerPid' => $workerPid,
            'exitCode' => $exitCode,
            'signal' => $signal,
        ]));
    }

    /**
     * @param \Swoole\Server $server
     */
    public function onSwooleManagerStart($server)
    {
        $this->trigger(static::EVENT_MANAGER_START, new ManagerStartEvent([
            'server' => $server
        ]));
    }

    /**
     * @param \Swoole\Server $server
     */
    public function onSwooleManagerStop($server)
    {
        $this->trigger(static::EVENT_MANAGER_STOP, new ManagerStopEvent([
            'server' => $server,
        ]));
    }
}
