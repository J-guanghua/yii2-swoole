<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Handlers;


use Swoole\Server;
use yii\base\Object;

abstract class AbstractHandler extends Object
{
    /**
     * @param Server $server
     */
    abstract function handle($server);
}
