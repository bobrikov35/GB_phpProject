<?php

session_start();

use app\services\{Request, RendererTemplate};

require_once dirname(__DIR__) . '/vendor/autoload.php';


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
function isLogin()
{
    static $login;
    if (!isset($login)) {
        $login = isset($_SESSION['login']) and $_SESSION['login'];
    }
    return $login;
}


$request = new Request();
$controllerName = $request->getController();

if (class_exists($controllerName)) {
    $controller = new $controllerName(
        $request,
        new RendererTemplate()
    );
    $content = $controller->run($request->getAction());
    if (!empty($content)) {
        echo $content;
    }
}
