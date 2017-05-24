<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Serializers;

use Yii;
use yii\helpers\Json;

/**
 * Class JsonSerializer
 * @package iPaya\Swoole\Serializers
 */
class JsonSerializer implements SerializerInterface
{
    /**
     * @inheritDoc
     */
    public function serialize($value)
    {
        return Json::encode($this->toArray($value));
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        return $this->fromArray(Json::decode($serialized));
    }


    /**
     * @param mixed $data
     * @return array
     */
    protected function toArray($data)
    {
        if (is_object($data)) {
            $result['class'] = get_class($data);
            foreach (get_object_vars($data) as $property => $value) {
                $result[$property] = $this->toArray($value);
            }
            return $result;
        }
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = $this->toArray($value);
            }
            return $result;
        }
        return $data;
    }

    /**
     * @param mixed $data
     * @return array|object
     */
    protected function fromArray($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        if (!isset($data['class'])) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = $this->fromArray($value);
            }
            return $result;
        }
        $config = ['class' => $data['class']];
        unset($data['class']);
        foreach ($data as $property => $value) {
            $config[$property] = $this->fromArray($value);
        }
        return Yii::createObject($config);
    }
}
