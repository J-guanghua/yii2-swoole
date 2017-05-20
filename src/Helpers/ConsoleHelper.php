<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\Swoole\Helpers;


use yii\helpers\Console;

class ConsoleHelper extends Console
{
    /**
     * @param string $string
     * @return bool|int
     */
    public static function stdout($string)
    {
        $args = func_get_args();
        array_shift($args);
        $string = Console::ansiFormat($string, $args);
        return parent::stdout($string);
    }

    /**
     * @param string $string
     * @return bool|int
     */
    public static function stderr($string)
    {
        $args = func_get_args();
        array_shift($args);
        $string = Console::ansiFormat($string, $args);
        return parent::stderr($string);
    }
}
