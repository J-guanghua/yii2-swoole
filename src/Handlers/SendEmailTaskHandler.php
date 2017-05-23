<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Handlers;


use iPaya\Swoole\Helpers\ConsoleHelper;
use Yii;
use yii\helpers\Console;

class SendEmailTaskHandler extends AbstractHandler
{
    /**
     * 发送邮件
     * @inheritDoc
     */
    function handle($server, $data = [])
    {
        $task_id = $data['task_id'];
        $to = $data['to'];
        $subject = $data['subject'];
        $body = $data['body'];

        ConsoleHelper::stdout("Task \${$task_id} executing...");

        $mailer = Yii::$app->mailer->compose();
        $mailer->setTo($to);
        $mailer->setSubject($subject);
        $mailer->setTextBody($body);
        if ($mailer->send()) {
            ConsoleHelper::stdout("[Ok]" . PHP_EOL, Console::BOLD, Console::FG_GREEN);
        } else {
            ConsoleHelper::stderr('[Fail]' . PHP_EOL, Console::BOLD, Console::FG_RED);
        }
        $server->finish($task_id);
    }

}
