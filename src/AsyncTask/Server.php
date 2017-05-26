<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\AsyncTask;


use iPaya\Swoole\Events\ReceiveEvent;
use iPaya\Swoole\Events\TaskEvent;
use iPaya\Swoole\Events\WorkerStartEvent;
use iPaya\Swoole\JobInterface;
use iPaya\Swoole\Queue;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

class Server extends \iPaya\Swoole\Server
{
    public $name = 'AsyncTask 服务器';
    public $swooleOptions = [
        'worker_num' => 4,
        'daemonize' => false,
        'task_worker_num' => 4
    ];
    public $enabledEvents = [
        'start', 'workerStart', 'connect', 'receive', 'close', 'task', 'finish',
    ];
    /**
     * @var Queue|array|string
     */
    public $queue;


    public function init()
    {
        parent::init();
        if (is_string($this->queue)) {
            $this->queue = Yii::$app->get($this->queue);
        } elseif (is_array($this->queue)) {
            $this->queue = Yii::createObject($this->queue);
        }
        if (!$this->queue instanceof Queue) {
            throw new InvalidConfigException('"queue" 必须实现 "QueueInterface" 接口.');
        }
        $this->on(self::EVENT_WORKER_START, [$this, 'onWorkerStart']);
        $this->on(self::EVENT_RECEIVE, [$this, 'onReceive']);
        $this->on(self::EVENT_TASK, [$this, 'onTask']);
    }

    /**
     * @param WorkerStartEvent $event
     */
    public function onWorkerStart($event)
    {
        if ($event->workerId == 0) {
            $event->server->tick(1000, function () use ($event) {
                $jobs = $this->queue->pop();
                foreach ($jobs as $job) {
                    $event->server->task($job);
                }
            });
        }
    }

    /**
     * @param ReceiveEvent $event
     */
    public function onReceive($event)
    {
        $event->server->task($event->content);
        $event->server->close($event->fd);
    }

    /**
     * @param TaskEvent $event
     * @throws NotSupportedException
     */
    public function onTask($event)
    {
        $job = $this->queue->serializer->unserialize($event->content);
        if ($job instanceof JobInterface) {
            $job->run();
            $event->server->finish($event->taskId);
        } else {
            throw new NotSupportedException('不支持的任务类型，任务类必须实现 JobInterface 接口。');
        }
    }
}
