<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace App\Commands;


use iPaya\Swoole\Events\CloseEvent;
use iPaya\Swoole\WebSocket\Events\MessageEvent;
use iPaya\Swoole\WebSocket\Events\OpenEvent;
use iPaya\Swoole\WebSocket\Server;
use Yii;
use yii\console\Controller;

class WebsocketController extends Controller
{
    public $clients = [];

    /**
     * 启动 WebSocket 服务器
     */
    public function actionStart()
    {
        /** @var Server $websocket */
        $websocket = Yii::$app->websocket;
        $websocket->on(Server::EVENT_OPEN, function (OpenEvent $event) {
            $this->clients[$event->request->fd] = $event->request->fd;
            $event->server->push($event->request->fd, '登录成功！你的 ID 是 ' . $event->request->fd);
        });

        $websocket->on(Server::EVENT_MESSAGE, function (MessageEvent $event) {
            foreach ($this->clients as $fd => $client) {
                $event->server->push($fd, "#" . $event->frame->fd . ' ' . $event->frame->data);
            }
        });

        $websocket->on(Server::EVENT_CLOSE, function (CloseEvent $event) {
            unset($this->clients[$event->fd]);
        });
        $websocket->start();
    }
}
