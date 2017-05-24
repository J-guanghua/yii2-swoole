<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Servers;


use iPaya\Swoole\Handlers\AbstractHandler;
use iPaya\Swoole\Helpers\ConsoleHelper;
use Swoole\Server as SwooleServer;
use yii\helpers\Json;

class AsyncTaskServer extends AbstractServer
{
    public $name = 'AsyncTask 服务器';
    public $listen = [
        ['127.0.0.1', 9052]
    ];

    public $swooleOptions = [
        'worker_num' => 4,
        'daemonize' => false,
        'task_worker_num' => 4
    ];

    public $events = [
        'start', 'workerStart', 'connect', 'receive', 'close', 'receive', 'task', 'finish'
    ];

    /**
     * @inheritdoc
     */
    public function onReceive($server, $fd, $from_id, $data)
    {
        ConsoleHelper::stdout('Receive data from #' . $fd . "\n" . $data . PHP_EOL . PHP_EOL);
        $this->server->task($data);
        $this->server->close($fd);
    }

    /**
     * @inheritDoc
     */
    public function onTask(SwooleServer $server, $task_id, $src_worker_id, $data)
    {
        $data = Json::decode($data);
        $handlerClass = $data['handler'];
        $data['task_id'] = $task_id;
        $handler = new $handlerClass;
        if ($handler instanceof AbstractHandler) {
            $handler->handle($server, $data);
            $this->server->finish($task_id);
        }
    }
}
