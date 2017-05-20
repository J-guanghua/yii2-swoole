<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


use iPaya\Swoole\Handlers\ConsoleHandler;
use iPaya\Swoole\Servers\MillisecondTimerServer;
use yii\console\Controller;

class MillisecondTimerController extends Controller
{
    /**
     * @var MillisecondTimerServer
     */
    public $server;

    public function init()
    {
        parent::init();
        $handler = new ConsoleHandler([
            'console' => \Yii::$app,
            'route' => 'say/something',
            'routeParams' => [
                'Hello World'
            ],
        ]);
        $this->server = new MillisecondTimerServer([
            'millisecond' => 5000,// 5 秒钟执行一次,
            'handler' => $handler
        ]);
    }

    /**
     * 启动定时器
     */
    public function actionStart()
    {
        $this->server->start();
    }
}
