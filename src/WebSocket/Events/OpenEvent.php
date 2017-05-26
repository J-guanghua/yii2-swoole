<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\WebSocket\Events;


use iPaya\Swoole\Events\ServerEvent;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;

class OpenEvent extends ServerEvent
{
    /**
     * @var Server
     */
    public $server;
    /**
     * @var Request
     */
    public $request;
}
