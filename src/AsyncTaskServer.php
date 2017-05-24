<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;


use Swoole\Server;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

class AsyncTaskServer extends AbstractServer
{
    public $name = 'AsyncTask 服务器';
    public $listen;
    public $swooleOptions = [
        'worker_num' => 4,
        'daemonize' => false,
        'task_worker_num' => 4
    ];
    public $events = [
        'start', 'workerStart', 'connect', 'receive', 'close', 'receive', 'task', 'finish'
    ];
    /**
     * @var Queue|array|string
     */
    public $queue;
    public $taskWorkerNum = 4;
    public $workerNum = 4;


    public function init()
    {
        parent::init();
        if ($this->listen == null) {
            throw new InvalidConfigException('请配置监听地址及端口 "listen"。');
        }
        if (is_string($this->queue)) {
            $this->queue = Yii::$app->get($this->queue);
        } elseif (is_array($this->queue)) {
            if (!isset($this->queue['class'])) {
                $this->queue['class'] = Queue::className();
            }
            $this->queue = Yii::createObject($this->queue);
        }
        if (!$this->queue instanceof Queue) {
            throw new InvalidConfigException('"queue" 必须为 Queue 实例或一个 Queue 实例的程序组件 ID.');
        }
        if ($this->taskWorkerNum) {
            $this->swooleOptions['task_worker_num'] = $this->taskWorkerNum;
        }
        if ($this->workerNum) {
            $this->swooleOptions['worker_num'] = $this->workerNum;
        }
    }

    /**
     * @param Server $server
     * @param int $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        if ($worker_id == 0) {
            $server->tick(1000, function () use ($server) {
                $jobs = $this->queue->pop();
                foreach ($jobs as $job) {
                    $server->task($job);
                }
            });
        }
    }

    /**
     * @inheritdoc
     */
    public function onReceive($server, $fd, $from_id, $data)
    {
        $this->server->task($data);
        $this->server->close($fd);
    }

    /**
     * @inheritDoc
     */
    public function onTask(Server $server, $task_id, $src_worker_id, $data)
    {
        $job = $this->queue->serializer->unserialize($data);
        if ($job instanceof JobInterface) {
            $job->run();
            $server->finish($task_id);
        } else {
            throw new NotSupportedException('不支持的任务类型，任务类必须实现 JobInterface 接口。');
        }
    }
}
