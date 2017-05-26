<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Events;


class WorkerErrorEvent extends ServerEvent
{
    public $workerId;
    public $workerPid;
    public $exitCode;
    public $signal;
}
