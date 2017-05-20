<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Handlers;


use yii\base\Object;

abstract class AbstractHandler extends Object
{
    abstract function handle();
}
