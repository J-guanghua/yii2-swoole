<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Servers;


use iPaya\Swoole\Handlers\SendEmailTaskHandler;
use Swoole\Server;
use Yii;
use yii\helpers\Json;
use yii\redis\Connection;

/**
 * 邮件发送服务器
 *
 * 通过定时器，每隔 1 秒钟扫描一次邮件队列，有邮件需要发送的邮件时，遍历所有需要发送的邮件，将发送邮件任务添加到 `TaskWorker` 中。
 * `TaskWorker` 根据发送来的信息将执行发送邮件。
 *
 * @package iPaya\Swoole\Servers
 */
class MailerServer extends AsyncTaskServer
{
    public $name = '邮件发送服务器';


    /**
     * @var int 定时间隔
     */
    public $millisecond = 1000;


    /**
     * @param Server $server
     * @param int $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        if ($worker_id == 0) {
            $server->tick($this->millisecond, function () use ($server) {
                /** @var Connection $redis */
                $redis = Yii::$app->redis;
                $queue = $redis->executeCommand('LPOP', ['queue:mail']);
                while ($queue != null) {
                    $data = Json::decode($queue);
                    $data['handler'] = SendEmailTaskHandler::className();
                    $server->task(Json::encode($data));
                    $queue = $redis->executeCommand('LPOP', ['queue:mail']);
                }
            });
        }
    }
}
