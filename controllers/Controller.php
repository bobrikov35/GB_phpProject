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
        } elseif (empty($_SERVER['HTTP_REFERER'])) {
            header("location: /");
        } else {
            header("location: {$_SERVER['HTTP_REFERER']}");
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
        $id = 0;
        if (!empty($_GET['id']) and is_numeric($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        return $id;
    }

    /**
     * @return int
     */
    protected function getPage()
    {
        $page = 1;
        if (!empty($_GET['page']) and is_numeric($_GET['page'])) {
            $page = (int)$_GET['page'];
        }
        return $page;
    }

    /**
     * @param string $paramName
     * @param string $type
     * @return mixed
     */
    protected function getPostParam(string $paramName, string $type = 'string')
    {
        $result = '';
        if (!empty($_POST[$paramName])) {
            $result = $_POST[$paramName];
        }
        if ($type == 'int') {
            if (is_numeric($result)) {
                return (int)$result;
            }
            return 0;
        }
        if ($type == 'float') {
            if (is_numeric($result)) {
                return (float)$result;
            }
            return 0;
        }
        if ($type == 'array') {
            if ($list = explode(PHP_EOL, $result)) {
                return $list;
            };
            return [];
        }
        return $result;
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
