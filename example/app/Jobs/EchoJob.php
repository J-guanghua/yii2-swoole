<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace App\Jobs;


use iPaya\Swoole\AbstractJob;

class EchoJob extends AbstractJob
{
    public $text;

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo "Hello {$this->text}!" . PHP_EOL;
    }
}
