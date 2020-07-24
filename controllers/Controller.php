<?php

namespace app\controllers;

use app\services\{IRenderer, RendererTemplate};


class Controller
{

    protected const ACTION_DEFAULT = 'default';
    protected string $action;
    protected IRenderer $renderer;


    public function __construct()
    {
        $this->renderer = new RendererTemplate();
    }


    /**
     * @param string $location
     */
    protected function changeLocation($location = '') {
        if ($location != '') {
            header("location: {$location}");
        } elseif (isset($_SERVER['HTTP_REFERER'])) {
            header("location: {$_SERVER['HTTP_REFERER']}");
        } else {
            header("location: /");
        }
    }


    /**
     * @return array
     */
    function getMenu()
    {
        $menu = [
            [ 'name' => 'Главная', 'link' => '/?c=home' ],
            [ 'name' => 'Товары', 'link' => '/?c=product&a=list' ],
        ];
        if (isLogin()) {
            $menu[] = [ 'name' => 'Заказы', 'link' => '/?c=order&a=list' ];
        }
        $menu[] = [ 'name' => 'Корзина', 'link' => '/?c=cart&a=list' ];
        if (isAdmin()) {
            $menu[] = [ 'name' => 'Работа с <br> товарами', 'link' => '/?c=product&a=table' ];
            $menu[] = [ 'name' => 'Работа с <br> заказами', 'link' => '/?c=order&a=table' ];
        }
        if (isLogin()) {
            $menu[] = [ 'name' => $_SESSION['user']['name'], 'link' => '/?c=account' ];
            $menu[] = [ 'name' => 'Выйти', 'link' => '/?c=account&a=logout' ];
        } else {
            $menu[] = [ 'name' => 'Войти', 'link' => '/?c=account&a=login' ];
        }
        return $menu;
    }

    /**
     * @return int
     */
    protected function getId()
    {
        static $id;
        if (isset($id)) {
            return $id;
        }
        $id = 0;
        if (isset($_GET['id']) and is_numeric($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        return $id;
    }


    /**
     * @param string $action
     * @return mixed
     */
    public function run($action)
    {
        $this->action = $action;
        $method = $this->action . "_action";
        if (!method_exists($this, $method)) {
            $this->action = ACTION_DEFAULT;
            $method = $this->action . "_action";
        }
        return $this->$method();
    }

    /**
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render($template, $params = [])
    {
        return $this->renderer->render($template, $params);
    }

}
