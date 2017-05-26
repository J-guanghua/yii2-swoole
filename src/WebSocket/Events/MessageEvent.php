<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\WebSocket\Events;


use iPaya\Swoole\Events\ServerEvent;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class MessageEvent extends ServerEvent
{
    /**
     * @var Server
     */
    public $server;
    /**
     * @var Frame
     */
    public $frame;
}
