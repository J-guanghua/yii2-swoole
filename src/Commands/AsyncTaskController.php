<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


use iPaya\Swoole\Servers\AsyncTaskServer;
use yii\console\Controller;

/**
 * 异步任务服务器
 *
 * @package iPaya\Swoole\Commands
 */
class AsyncTaskController extends Controller
{
    /**
     * @var AsyncTaskServer
     */
    public $server;
    public $listen = [
        ['127.0.0.1', 9052]
    ];
    public $host = '127.0.0.1';
    public $port = 9052;


    public function init()
    {
        parent::init();
        $this->server = new AsyncTaskServer([
            'listen' => $this->listen,
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
