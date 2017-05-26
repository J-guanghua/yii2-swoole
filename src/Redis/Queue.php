<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Redis;

use iPaya\Swoole\JobInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\redis\Connection;

class Queue extends \iPaya\Swoole\Queue
{
    /**
     * @var Connection|array|string
     */
    public $redis = 'redis';
    public $key = 'queue:task';

    public function init()
    {
        parent::init();
        if (is_string($this->redis)) {
            $this->redis = Yii::$app->get($this->redis);
        } elseif (is_array($this->redis)) {
            if (!isset($this->redis['class'])) {
                $this->redis['class'] = Connection::className();
            }
            $this->redis = Yii::createObject($this->redis);
        }
        if (!$this->redis instanceof Connection) {
            throw new InvalidConfigException('App\TaskServer\Queue::redis must be either a Redis connection instance or the application component ID of a Redis connection.');
        }
        $this->serializer = new $this->serializer;
    }

    /**
     * @param JobInterface $job
     * @return mixed
     */
    public function push(JobInterface $job)
    {
        return $this->redis->executeCommand('RPUSH', [$this->key, $this->serializer->serialize($job)]);
    }

    /**
     * @return array
     */
    public function pop()
    {
        $jobs = [];
        $message = $this->redis->executeCommand('LPOP', [$this->key]);
        while ($message != null) {
            $jobs[] = $message;
            $message = $this->redis->executeCommand('LPOP', [$this->key]);
        }
        return $jobs;
    }
}
