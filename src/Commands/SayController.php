<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Commands;


use yii\console\Controller;

class SayController extends Controller
{
    public $defaultAction = 'something';


    /**
     * @param string $words
     */
    public function actionSomething($words)
    {
        echo date('Y/m/d H:i:s') . ': ' . $words . PHP_EOL;
    }
}