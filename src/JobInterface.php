<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;

/**
 * Interface JobInterface
 * @package iPaya\Swoole
 */
interface JobInterface
{
    /**
     * 执行任务
     * @return mixed
     */
    public function run();
}
