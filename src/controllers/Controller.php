<?php

namespace app\controllers;

use app\engine\App;
use app\services\{Request, Paginator};
use app\repositories\Repository;


/**
 * Class Controller
 * @package app\controllers
 */
abstract class Controller
{

    /**
     * С В О Й С Т В А
     */

    protected App $app;
    protected Request $request;
    protected Paginator $paginator;


    /**
     * М А Г И Ч Е С К И Е   Ф У Н К Ц И И
     */

    /**
     * Controller constructor
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        $this->paginator = $app->paginator;
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Вызывает действие текущего контроллера
     *
     * @return mixed
     */
    public function run()
    {
        $method = $this->getAction() . '_action';
        return $this->$method();
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает общие конфигурации шаблонов
     *
     * @return array
     */
    protected function getConfig(): array
    {
        return [
            'time' => $this->getSettings('time'),
            'menu' => $this->getMenu(),
        ];
    }

    /**
     * Возвращает главное меню сайта
     *
     * @return array
     */
    private function getMenu(): array
    {
        $menu = [
            ['name' => 'Главная', 'link' => '/home'],
            ['name' => 'Товары', 'link' => '/product/list/?page=1'],
        ];
        if ($this->isLogin()) {
            $menu[] = ['name' => 'Заказы', 'link' => '/order/list/?page=1'];
        }
        if (empty($this->getCart())) {
            $menu[] = ['name' => 'Корзина', 'link' => '/cart/list'];
        } else {
            $menu[] = ['name' => 'Корзина (' . count($this->getCart()) . ')', 'link' => '/cart/list'];
        }
        if ($this->isAdmin()) {
            $menu[] = ['name' => 'Работа с <br> товарами', 'link' => '/product/table/?page=1'];
            $menu[] = ['name' => 'Работа с <br> заказами', 'link' => '/order/table/?page=1'];
        }
        if ($this->isLogin()) {
            $menu[] = ['name' => $this->getUser('name'), 'link' => '/user'];
            $menu[] = ['name' => 'Выйти', 'link' => '/user/logout'];
        } else {
            $menu[] = ['name' => 'Войти', 'link' => '/user/login'];
        }
        return $menu;
    }

    /**
     * Возвращает действие для текущего контроллера
     *
     * @return string
     */
    private function getAction(): string
    {
        $action = $this->request->getAction();
        $method = $action . "_action";
        if (!method_exists($this, $method)) {
            $action = $this->getSettings('actionDefault');
        }
        return $action;
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

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
     * @param string $key
     * @return array|mixed|null
     */
    protected function getUser(string $key = '')
    {
        return $this->request->getUser($key);
    }

    /**
     * @param string $param
     * @return array|mixed|null
     */
    protected function getPost(string $param = '')
    {
        return $this->request->getPost($param);
    }

    /**
     * @param string $param
     * @return array|mixed|null
     */
    protected function getSession(string $param = '')
    {
        return $this->request->getSession($param);
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->app->request->isAdmin();
    }

    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        return $this->app->request->isLogin();
    }

    /**
     * @param string $right
     * @return bool
     */
    public function permission(string $right): bool
    {
        return $this->app->request->permission($right);
    }

    /**
     * @param string $location
     * @param string $message
     */
    protected function toLocation(string $location = '', string $message = ''): void
    {
        $this->request->toLocation($location, $message);
    }

    /**
     * @param Repository $repository
     * @param string $path
     * @param int $page
     */
    protected function configurePaginator(Repository $repository, string $path, int $page = 1): void
    {
        $this->paginator->setPath($path);
        $this->paginator->setItems($repository, $page);
    }

    /**
     * @param string $key
     * @return array|mixed|null
     */
    protected function getSettings(string $key = '')
    {
        return$this->app->getSettings($key);
    }

    /**
     * @return array
     */
    protected function getCart(): array
    {
        return $this->app->serviceCart->getList();
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function render(string $template, array $params = []): string
    {
        return $this->app->renderer->render($template, $params);
    }

}
