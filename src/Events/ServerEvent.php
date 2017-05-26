<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Events;


use Swoole\Server;
use yii\base\Event;

class ServerEvent extends Event
{
    /**
     * @var Server
     */
    public $server;
    /**
     * @var integer
     */
    public $workerId;
}
