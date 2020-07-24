<?php

use app\services\Autoloader;

include dirname(__DIR__) . '/services/Autoloader.php';

spl_autoload_register([(new Autoloader()), 'loadClass']);

session_start();


const CONTROLLER_DEFAULT = 'app\controllers\HomeController';
const ACTION_DEFAULT = 'default';


$_SESSION['login'] = true;
$_SESSION['admin'] = true;
$_SESSION['user']['name'] = 'Антон';


/**
 * @return bool
 */
function isAdmin(): bool
{
    static $admin;
    if (!isset($admin)) {
        $admin = isset($_SESSION['admin']) and $_SESSION['admin'];
    }
    return $admin;
}

/**
 * @return bool
 */
function isLogin(): bool
{
    static $login;
    if (!isset($login)) {
        $login = isset($_SESSION['login']) and $_SESSION['login'];
    }
    return $login;
}


/**
 * @return mixed
 */
function getController()
{

    function getControllerName($controller): string
    {
        return "app\\controllers\\{$controller}Controller";
    }

    $controller = CONTROLLER_DEFAULT;
    if (!empty($_GET['c']) and class_exists(getControllerName(ucfirst($_GET['c'])))) {
        $controller = getControllerName(ucfirst($_GET['c']));
    }
    return new $controller();
}

/**
 * @return string
 */
function getAction(): string
{
    if (empty($_GET['a'])) {
        return ACTION_DEFAULT;
    }
    return $_GET['a'];
}


$content = getController()->run(getAction());

if (!empty($content)) {
    echo $content;
}
