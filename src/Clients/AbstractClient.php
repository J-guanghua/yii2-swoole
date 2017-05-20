<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Clients;

use Swoole\Client;
use yii\base\InvalidConfigException;
use yii\base\Object;

abstract class AbstractClient extends Object
{
    public $host;
    public $port;
    public $socketType;
    public $syncType;
    /**
     * @var Client
     */
    public $client;

    public function init()
    {
        parent::init();

        if ($this->host === null) {
            throw new InvalidConfigException('请配置 "host"');
        }
        if ($this->port === null) {
            throw new InvalidConfigException('请配置 "port"');
        }
        if ($this->socketType === null) {
            throw new InvalidConfigException('请配置 "socketType"');
        }
        if ($this->syncType === null) {
            throw new InvalidConfigException('请配置 "syncType"');
        }
        $this->client = new Client($this->socketType, $this->syncType);
    }

    /**
     * @param string $data
     */
    abstract public function send($data);
}
