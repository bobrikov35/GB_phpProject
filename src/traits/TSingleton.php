<?php

namespace app\traits;


trait TSingleton
{

    /**
     * С В О Й С Т В А
     */

    private static $items;


    /**
     * М А Г И Ч Е С К И Е   Ф У Н К Ц И И
     */

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает экземпляр класса в единственном экземпляре
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (empty(static::$items)) {
            static::$items = new static();
        }
        return static::$items;
    }

}
