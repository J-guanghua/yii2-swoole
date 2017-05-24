<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace App\Commands;


use App\Jobs\EchoJob;
use App\Jobs\SendEmailJob;
use Yii;
use yii\console\Controller;

/**
 * AsyncTask 服务器
 *
 * @package App\Commands
 */
class AsyncTaskController extends Controller
{
    /**
     * 启动 AsyncTask 服务器
     */
    public function actionStart()
    {
        Yii::$app->asyncTask->start();
    }

    /**
     * 尝试推送任务到队列
     */
    public function actionTryEcho()
    {
        $names = [
            'Alex', 'Clare', 'Diego', 'Eva', 'Frank', 'Kevin'
        ];
        foreach ($names as $name) {
            Yii::$app->queue->push(new EchoJob([
                'text' => $name
            ]));
        }
    }

    /**
     * 尝试推送发送邮件任务到队列
     */
    public function actionTryEmails()
    {
        $emails = [
            ['to' => 'user1@example.com', 'subject' => 'Hello User 1', 'body' => 'Hello, I am AsyncTask Server.'],
            ['to' => 'user2@example.com', 'subject' => 'Hello User 2', 'body' => 'Hello, I am AsyncTask Server.'],
            ['to' => 'user3@example.com', 'subject' => 'Hello User 3', 'body' => 'Hello, I am AsyncTask Server.'],
            ['to' => 'user4@example.com', 'subject' => 'Hello User 4', 'body' => 'Hello, I am AsyncTask Server.'],
            ['to' => 'user5@example.com', 'subject' => 'Hello User 5', 'body' => 'Hello, I am AsyncTask Server.'],
        ];
        foreach ($emails as $email) {
            Yii::$app->queue->push(new SendEmailJob([
                'to' => $email['to'],
                'subject' => $email['subject'],
                'body' => $email['body']
            ]));
        }
    }
}
