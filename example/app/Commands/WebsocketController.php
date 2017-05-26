<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace App\Commands;


use Yii;
use yii\console\Controller;

class WebsocketController extends Controller
{
    /**
     * 启动 WebSocket 服务器
     */
    public function actionStart()
    {
        Yii::$app->websocket->start();
    }
}
