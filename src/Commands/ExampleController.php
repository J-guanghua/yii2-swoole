<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


use iPaya\Swoole\Clients\SyncClient;
use iPaya\Swoole\Handlers\SendEmailTaskHandler;
use yii\console\Controller;
use yii\helpers\Json;

class ExampleController extends Controller
{

    /**
     * 模拟听见发送邮件异步任务
     */
    public function actionSendEmails()
    {
        $client = new SyncClient([
            'host' => '127.0.0.1',
            'port' => 9052,
            'socketType' => SWOOLE_SOCK_TCP,
            'syncType' => SWOOLE_SOCK_SYNC
        ]);

        $handler = SendEmailTaskHandler::className();
        $emailSubject = 'Email Subject';
        $emailBody = 'Email Body';
        $data = [
            [
                'handler' => $handler,
                'to' => 'test1@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
            [
                'handler' => $handler,
                'to' => 'test2@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
            [
                'handler' => $handler,
                'to' => 'test3@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
            [
                'handler' => $handler,
                'to' => 'test4@example.com',
                'subject' => $emailSubject,
                'body' => $emailBody,
            ],
        ];
        foreach ($data as $item) {
            $client->send(Json::encode($item));
        }
    }
}
