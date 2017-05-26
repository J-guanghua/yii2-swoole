<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Events;


class TaskEvent extends ServerEvent
{
    public $taskId;
    public $workerId;
    /**
     * @var mixed
     */
    public $content;
}
