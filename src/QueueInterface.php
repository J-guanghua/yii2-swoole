<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;


interface QueueInterface
{
    /**
     * @param JobInterface $job
     * @return mixed
     */
    public function push(JobInterface $job);

    /**
     * @return JobInterface[]
     */
    public function pop();
}
