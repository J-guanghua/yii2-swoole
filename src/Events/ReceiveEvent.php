<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Events;


class ReceiveEvent extends ServerEvent
{
    public $fd;
    public $reactorId;
    public $content;
}
