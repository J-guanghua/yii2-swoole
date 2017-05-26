<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\WebSocket;


use iPaya\Swoole\WebSocket\Events\MessageEvent;
use iPaya\Swoole\WebSocket\Events\OpenEvent;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;

class Server extends \iPaya\Swoole\Server
{
    const EVENT_OPEN = 'open';
    const EVENT_MESSAGE = 'message';

    /**
     * @var \Swoole\WebSocket\Server
     */
    public $server;

    public function start()
    {
        $this->server = $this->createServer('\Swoole\WebSocket\Server');

        $this->server->set($this->swooleOptions);
        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('close', [$this, 'onClose']);


        $this->server->start();
    }

    /**
     * @param \Swoole\WebSocket\Server $server
     * @param Request $request
     */
    public function onOpen($server, $request)
    {
        $this->trigger(static::EVENT_OPEN, new OpenEvent([
            'server' => $server,
            'request' => $request,
        ]));
    }

    /**
     * @param \Swoole\WebSocket\Server $server
     * @param Frame $frame
     */
    public function onMessage($server, $frame)
    {
        $this->trigger(static::EVENT_MESSAGE, new MessageEvent([
            'server' => $server,
            'frame' => $frame,
        ]));
    }

}
