<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


use iPaya\Swoole\Clients\SyncClient;
use iPaya\Swoole\Handlers\SendEmailTaskHandler;
use iPaya\Swoole\Servers\AsyncTaskServer;
use yii\console\Controller;
use yii\helpers\Json;

class AsyncTaskController extends Controller
{
    /**
     * @var AsyncTaskServer
     */
    public $server;
    public $host = '127.0.0.1';
    public $port = 9052;
    /**
     * @var SyncClient
     */
    public $client;

    public function init()
    {
        parent::init();
        $this->server = new AsyncTaskServer([
            'host' => $this->host,
            'port' => $this->port,
        ]);
        $this->client = new SyncClient([
            'host' => $this->host,
            'port' => $this->port,
            'socketType' => SWOOLE_SOCK_TCP,
            'syncType' => SWOOLE_SOCK_SYNC
        ]);
    }

    /**
     * 启动 AsyncTask 服务器
     */
    public function actionStart()
    {
        $this->server->start();
    }

    /**
     * 模拟听见发送邮件异步任务
     */
    public function actionSendEmails()
    {
        $handler = SendEmailTaskHandler::className();
        $emailSubject = 'Email Subject';
        $emailBody = 'Email Body';
        $data = [
            [
                'handler' => $handler,
                'email' => 'test1@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
            [
                'handler' => $handler,
                'email' => 'test2@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
            [
                'handler' => $handler,
                'email' => 'test3@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
            [
                'handler' => $handler,
                'email' => 'test4@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
        ];
        foreach ($data as $item) {
            $this->client->send(Json::encode($item));
        }
    }
}
