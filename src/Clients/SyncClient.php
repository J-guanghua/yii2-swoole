<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Clients;


use iPaya\Swoole\Helpers\ConsoleHelper;
use yii\helpers\Console;

class SyncClient extends AbstractClient
{
    /**
     * @inheritDoc
     */
    public function send($data)
    {
        if (!$this->client->connect($this->host, $this->port)) {
            ConsoleHelper::stderr('连接失败' . PHP_EOL, Console::BOLD, Console::FG_RED);
        }
        $this->client->send($data);
        echo $this->client->recv();
        $this->client->close();
    }

}
