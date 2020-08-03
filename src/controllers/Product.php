<?php

namespace app\controllers;

use app\entities\Product as EProduct;


/**
 * Class Product
 * @package app\controllers
 */
class Product extends Controller
{

    /**
     * Д Е Й С Т В И Я
     */

    /**
     * Действие по умолчанию
     */
    protected function default_action()
    {
        $this->toLocation('/product/list/?page=1');
    }

    /**
     * Выводит список товаров
     *
     * @return string
     */
    protected function list_action()
    {
        return $this->render('product/index.twig', $this->getConfigForLists('list'));
    }

    /**
     * Выводит список товаров с возможностью создания, редактирования и удаления (для админа)
     *
     * @return string|void
     */
    protected function table_action()
    {
        if (!$this->permission('admin')) {
            $this->toLocation('/product/list/?page=1');
            return;
        }
        return $this->render('product/table.twig', $this->getConfigForLists('table'));
    }

    /**
     * Выводит одиночный товар
     *
     * @return string|void
     */
    protected function single_action()
    {
        $config = $this->getConfig();
        if ($config['product'] = $this->getProduct()) {
            $this->toLocation('/product/list/?page=1');
            return;
        }
        return $this->render('product/single.twig', $config);
    }

    /**
     * Возвращает форму для создания товара или создает его
     *
     * @return string|void
     */
    protected function create_action()
    {
        if (!$this->permission('admin')) {
            $this->toLocation('/product/list/?page=1');
            return;
        }
        $config = $this->getConfigForEdit('/product/create', 'Добавление товара', 'Добавить');
        if (empty($this->getPost())) {
            $config['product'] = new EProduct();
            return $this->render('product/edit.twig', $config);
        }
        return $this->save($config);
    }

    /**
     * Возвращает форму для редактирования товара или изменяет его
     *
     * @return string|void
     */
    protected function update_action()
    {
        if (!$this->permission('admin')) {
            $this->toLocation('/product/list/?page=1');
            return;
        }
        if (empty($this->getId())) {
            $this->toLocation('/product/create');
            return;
        }
        $config = $this->getConfigForEdit("/product/update/?id={$this->getId()}",
            'Редактирование товара', 'Сохранить изменения', true);
        if (empty($this->getPost())) {
            $config['product'] = $this->getProduct();
            return $this->render('product/edit.twig', $config);
        }
        return $this->save($config);
    }

    /**
     * Удаляет товар
     */
    protected function delete_action(): void
    {
        if (!$this->permission('admin')) {
            $this->toLocation('/product/list/?page=1');
            return;
        }
        $this->deleteProduct();
        $this->toLocation('/product/table/?page=1');
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает конфигурацию для списков
     *
     * @param string $action
     * @return array
     */
    private function getConfigForLists(string $action): array
    {
        $config = $this->getConfig();
        $this->configurePaginator($this->app->repositoryProduct, "/product/{$action}/?page=", $this->getPage());
        $config['goods'] = $this->paginator->getItems();
        $config['count'] = count($config['goods']);
        $config['pages'] = [
            'links' => $this->app->paginator->getUrls(),
            'current' => $this->getPage(),
        ];
        $config['pages']['count'] = count($config['pages']['links']);
        return $config;
    }

    /**
     * Возвращает конфигурацию для редактирования
     *
     * @param string $action
     * @param string $title
     * @param string $buttonTitle
     * @param bool $showId
     * @return array
     */
    private function getConfigForEdit(string $action, string $title, string $buttonTitle, bool $showId = false): array
    {
        $config = $this->getConfig();
        $config['action'] = $action;
        $config['title'] = $title;
        $config['buttonTitle'] = $buttonTitle;
        $config['showId'] = $showId;
        return $config;
    }

    /**
     * Сохраняет переданные данные
     *
     * @param array $config
     * @return string|void
     */
    private function save(array &$config)
    {
        if ($this->checkRequiredParams() and $this->saveProduct()) {
            $this->toLocation('/product/table/?page=1');
            return;
        }
        $config['product'] = $this->getProductFromPost();
        return $this->render('product/edit.twig', $config);
    }

    /**
     * Проверяет наличие обязательных параметров для добавления и изменения
     *
     * @return bool
     */
    private function checkRequiredParams(): bool
    {
        return !empty($this->getPost('name')) and !empty($this->getPost('title'));
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @return EProduct|null
     */
    private function getProduct()
    {
        return $this->app->serviceProduct->getProduct($this->getId());
    }

    /**
     * @return EProduct|null
     */
    private function getProductFromPost()
    {
        return $this->app->serviceProduct->getProductFromPost();
    }

    /**
     * @return bool|int
     */
    private function saveProduct()
    {
        return $this->app->serviceProduct->save($this->getId());
    }

    /**
     * @return bool
     */
    private function deleteProduct(): bool
    {
        return $this->app->serviceProduct->delete($this->getId());
    }

}
