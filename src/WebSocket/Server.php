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
    public $enabledEvents = [
        'open', 'message', 'close'
    ];
    public $availableEvents = [
        'open' => 'onSwooleOpen',
        'message' => 'onSwooleMessage',
        'close' => 'onSwooleClose'
    ];

    public function start()
    {
        $this->server = $this->createServer('\Swoole\WebSocket\Server');
        $this->server->start();
    }

    /**
     * @param \Swoole\WebSocket\Server $server
     * @param Request $request
     */
    public function onSwooleOpen($server, $request)
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
    public function onSwooleMessage($server, $frame)
    {
        $this->trigger(static::EVENT_MESSAGE, new MessageEvent([
            'server' => $server,
            'frame' => $frame,
        ]));
    }

}
