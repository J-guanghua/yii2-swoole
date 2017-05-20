<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


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
        $this->server = new MillisecondTimerServer([
            'cmd' => 'say/something',
            'cmdParams' => [
                'Hello World'
            ],
            'millisecond' => 5000,// 5 秒钟执行一次,
            'console' => \Yii::$app
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
