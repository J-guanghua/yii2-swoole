<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Handlers;


use yii\console\Application;

class ConsoleHandler extends AbstractHandler
{
    /**
     * @var Application
     */
    public $console;
    /**
     * @var string
     */
    public $route;
    /**
     * @var array
     */
    public $routeParams = [];


    /**
     * @inheritdoc
     */
    function handle($server)
    {
        $this->console->runAction($this->route, $this->routeParams);
    }
}
