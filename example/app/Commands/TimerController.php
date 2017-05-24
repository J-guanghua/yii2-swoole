<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace App\Commands;

use Yii;
use yii\console\Controller;

/**
 * 定时器
 *
 * @package App\Commands
 */
class TimerController extends Controller
{
    /**
     * 启动定时器
     */
    public function actionStart()
    {
        Yii::$app->timer->start();
    }
}
