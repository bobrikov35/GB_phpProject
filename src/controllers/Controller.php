<?php

namespace app\controllers;

use app\services\{Request, IRenderer, Cart};


abstract class Controller
{

    private const ACTION_DEFAULT = 'default';

    private string $sol;
    protected Request $request;
    protected IRenderer $renderer;


    /**
     * Controller constructor.
     * @param Request $request
     * @param IRenderer $renderer
     */
    public function __construct(Request $request, IRenderer $renderer)
    {
        $this->sol = microtime(true).rand();
        $this->request = $request;
        $this->renderer = $renderer;
    }


    /**
     * @param string $location
     */
    protected function changeLocation(string $location = '')
    {
        if ($location != '') {
            header("location: {$location}");
        } elseif (empty($_SERVER['HTTP_REFERER'])) {
            header("location: /");
        } else {
            header("location: {$_SERVER['HTTP_REFERER']}");
        }
    }


    /**
     * @return string
     */
    protected function getAction(): string
    {
        $action = $this->request->getAction();
        $method = $action . "_action";
        if (!method_exists($this, $method)) {
            $action = self::ACTION_DEFAULT;
        }
        return $action;
    }

    /**
     * @return array
     */
    protected function getConfig(): array
    {
        return [
            'sol' => $this->getSol(),
            'menu' => $this->getMenu(),
        ];
    }

    /**
     * @return array
     */
    function getMenu(): array
    {
        $menu = [
            [ 'name' => 'Главная', 'link' => '/home' ],
            [ 'name' => 'Товары', 'link' => '/product/list' ],
        ];
        if (isLogin()) {
            $menu[] = [ 'name' => 'Заказы', 'link' => '/order/list' ];
        }
        $cartCount = count((new Cart($this->request))->getList());
        if ($cartCount > 0) {
            $menu[] = [ 'name' => "Корзина ({$cartCount})", 'link' => '/cart/list' ];
        } else {
            $menu[] = [ 'name' => 'Корзина', 'link' => '/cart/list' ];
        }
        if (isAdmin()) {
            $menu[] = [ 'name' => 'Работа с <br> товарами', 'link' => '/product/table' ];
            $menu[] = [ 'name' => 'Работа с <br> заказами', 'link' => '/order/table' ];
        }
        if (isLogin()) {
            $menu[] = [ 'name' => $this->request->getSession('user')['name'], 'link' => '/user' ];
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

    protected function getSol(): int
    {
        return $this->sol;
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
        return $this->renderer->render($template, $params);
    }

}
