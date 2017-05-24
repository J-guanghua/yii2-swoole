<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace App\Jobs;


use iPaya\Swoole\AbstractJob;
use Yii;

class SendEmailJob extends AbstractJob
{
    public $to;
    public $subject;
    public $body;

    /**
     * @inheritDoc
     */
    public function run()
    {
        Yii::$app->mailer->compose()
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
