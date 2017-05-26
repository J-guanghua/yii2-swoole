<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole;

use iPaya\Serializers\SerializerInterface;
use yii\base\Object;

abstract class Queue extends Object
{
    /**
     * @var SerializerInterface
     */
    public $serializer = 'iPaya\Serializers\JsonSerializer';


    /**
     * @param JobInterface $job
     * @return mixed
     */
    abstract public function push(JobInterface $job);

    /**
     * @return JobInterface[]
     */
    abstract public function pop();
}
