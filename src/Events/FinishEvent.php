<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Events;


class FinishEvent extends ServerEvent
{
    public $taskId;
    /**
     * @var string
     */
    public $content;
}
