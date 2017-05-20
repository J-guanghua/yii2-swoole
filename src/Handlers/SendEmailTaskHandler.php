<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Handlers;


use iPaya\Swoole\Helpers\ConsoleHelper;
use yii\helpers\Json;

class SendEmailTaskHandler extends AbstractHandler
{
    /**
     * 模拟发送邮件
     * @inheritDoc
     */
    function handle($server, $data = [])
    {
        $task_id = $data['task_id'];
        $email = $data['email'];

        ConsoleHelper::stdout(self::className() . " \${$task_id} >>> Send email to {$email}\n" . Json::encode($data) . PHP_EOL);
    }

}
