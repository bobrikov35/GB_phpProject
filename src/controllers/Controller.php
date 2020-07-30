<?php

namespace app\controllers;

use app\engine\App;
use app\services\Request;


/**
 * Class Controller
 * @package app\controllers
 */
abstract class Controller
{

    protected App $app;
    protected Request $request;


    /**
     * Controller constructor
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $app->request;
    }


    /**
     * @return string
     */
    private function getAction(): string
    {
        $action = $this->request->getAction();
        $method = $action . "_action";
        if (!method_exists($this, $method)) {
            $action = $this->app->getSettings('actionDefault');
        }
        return $action;
    }

    /**
     * @return array
     */
    protected function getConfig(): array
    {
        return [
            'time' => $action = $this->app->getSettings('time'),
            'menu' => $this->getMenu(),
        ];
    }

    /**
     * @return array
     */
    private function getMenu(): array
    {
        $menu = [
            [ 'name' => 'Главная', 'link' => '/home' ],
            [ 'name' => 'Товары', 'link' => '/product/list/?page=1' ],
        ];
        if ($this->app->authorization->isLogin()) {
            $menu[] = [ 'name' => 'Заказы', 'link' => '/order/list/?page=1' ];
        }
        $cart = $this->app->serviceCart->getList();
        if (empty($cart)) {
            $menu[] = [ 'name' => 'Корзина', 'link' => '/cart/list' ];
        } else {
            $count = count($cart);
            $menu[] = [ 'name' => "Корзина ({$count})", 'link' => '/cart/list' ];
        }
        if ($this->app->authorization->isAdmin()) {
            $menu[] = [ 'name' => 'Работа с <br> товарами', 'link' => '/product/table/?page=1' ];
            $menu[] = [ 'name' => 'Работа с <br> заказами', 'link' => '/order/table/?page=1' ];
        }
        if ($this->app->authorization->isLogin()) {
            $user = $this->request->getSession('user');
            $menu[] = [ 'name' => $user['name'], 'link' => '/user' ];
            $menu[] = [ 'name' => 'Выйти', 'link' => '/user/logout' ];
        } else {
            $menu[] = [ 'name' => 'Войти', 'link' => '/user/login' ];
        }
        return $menu;
    }

    /**
     * @return int
     */
    protected function getId(): int
    {
        return $this->request->getId();
    }

    /**
     * @return int
     */
    protected function getPage(): int
    {
        return $this->request->getPage();
    }


    /**
     * @return mixed
     */
    public function run()
    {
        $method = $this->getAction() . '_action';
        return $this->$method();
    }

    /**
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render($template, $params = [])
    {
        return $this->app->renderer->render($template, $params);
    }

    protected function toLocation(string $location = '', string $message = '')
    {
        $this->request->toLocation($location, $message);
    }

}
