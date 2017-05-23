<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


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
     * @var string 监听主机
     */
    public $host = '127.0.0.1';
    /**
     * @var int 监听端口
     */
    public $port = 9053;


    public function init()
    {
        parent::init();
        $this->server = new MailerServer([
            'host' => $this->host,
            'port' => $this->port,
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
