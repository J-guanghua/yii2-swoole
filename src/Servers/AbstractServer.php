<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Servers;

use iPaya\Swoole\Server\ServerInterface;
use Swoole\Server as SwooleServer;
use yii\base\Object;

abstract class AbstractServer extends Object
{
    /**
     * @var SwooleServer
     */
    public $server;
}