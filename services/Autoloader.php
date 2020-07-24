<?php

namespace app\services;


class Autoloader
{

    /**
     * @param $namespace
     */
    public function loadClass($namespace)
    {
        $file = dirname(__DIR__) . mb_strcut($namespace, 3) . '.php';
        $file = str_replace('\\', '/', $file);
        if (is_file($file)) {
            include $file;
        }
    }

}
