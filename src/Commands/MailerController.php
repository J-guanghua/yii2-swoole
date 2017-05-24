<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


use iPaya\Swoole\Handlers\SendEmailTaskHandler;
use iPaya\Swoole\Servers\AsyncTaskServer;
use iPaya\Swoole\Servers\MailerServer;
use yii\console\Controller;

/**
 * 邮件发送服务器
 *
 * @package iPaya\Swoole\Commands
 */
class MailerController extends Controller
{
    /**
     * @var AsyncTaskServer
     */
    public $server;
    /**
     * @var array 监听地址
     */
    public $listen = [
        ['127.0.0.1', 9053]
    ];


    public function init()
    {
        parent::init();
        $this->server = new MailerServer([
            'listen' => $this->listen,
            'redis' => \Yii::$app->redis,
            'queueKey' => 'queue:mailer',
            'handler' => SendEmailTaskHandler::className(),
        ]);
    }

    /**
     * 启动 AsyncTask 服务器
     */
    public function actionStart()
    {
        $this->server->start();
    }
}
