<?php

namespace app\controllers;

use app\entities\Product as EProduct;


/**
 * Class Product
 * @package app\controllers
 */
class Product extends Controller
{

    protected function default_action()
    {
        $this->toLocation('/product/list/?page=1');
    }

    /**
     * @param string $action
     * @return array
     */
    private function getListConfig(string $action): array
    {
        $this->app->paginator->setPath("/product/{$action}/?page=");
        $this->app->paginator->setItems($this->app->repositoryProduct, $this->getPage());
        $config = $this->getConfig();
        $config['goods'] = $this->app->paginator->getItems();
        $config['count'] = count($config['goods']);
        $config['pages'] = [
            'list' => $this->app->paginator->getUrls(),
            'current' => $this->getPage(),
        ];
        $config['pages']['count'] = count($config['pages']['list']);
        return $config;
    }

    /**
     * @return mixed
     */
    protected function list_action()
    {
        $config = $this->getListConfig('list');
        return $this->render('product/index.twig', $config);
    }

    /**
     * @return mixed
     */
    protected function table_action()
    {
        $config = $this->getListConfig('table');
        return $this->render('product/table.twig', $config);
    }

    /**
     * @return mixed|void
     */
    protected function single_action()
    {
        $config = $this->getConfig();
        $config['product'] = $this->app->repositoryProduct->getSingle($this->getId());
        if (empty($config['product'])) {
            $this->toLocation('/product/list/?page=1');
            return;
        }
        return $this->render('product/single.twig', $config);
    }

    /**
     * @return bool
     */
    private function checkRequiredParams(): bool
    {
        return !empty($this->request->getPost('name'))
                and !empty($this->request->getPost('title'));
    }

    /**
     * @return mixed|void
     */
    protected function create_action()
    {
        if (!$this->app->authorization->isAdmin()) {
            $this->toLocation('/product/list/?page=1');
        }
        $config = $this->getConfig();
        $config['action'] = '/product/create';
        $config['title'] = 'Добавление товара';
        $config['buttonTitle'] = 'Добавить';
        $config['showId'] = false;
        if (empty($this->request->getPost())) {
            $config['product'] = new EProduct();
            return $this->render('product/edit.twig', $config);
        }
        if ($this->checkRequiredParams() and $this->app->serviceProduct->save($this->getId())) {
            $this->toLocation('/product/table');
            return;
        }
        $config['product'] = new EProduct();
        $this->app->serviceProduct->fillProductFromPost($config['product']);
        return $this->render('product/edit.twig', $config);
    }

    /**
     * @return mixed|void
     */
    protected function update_action()
    {
        if (!$this->app->authorization->isAdmin()) {
            $this->toLocation('/product/list/?page=1');
        }
        $config = $this->getConfig();
        $config['action'] = "/product/update/?id={$this->getId()}";
        $config['title'] = 'Редактирование товара';
        $config['buttonTitle'] = 'Сохранить изменения';
        $config['showId'] = true;
        if (empty($this->getId())) {
            $this->toLocation('/product/create');
            return;
        }
        if (empty($this->request->getPost())) {
            $config['product'] = $this->app->repositoryProduct->getSingle($this->getId());
            return $this->render('product/edit.twig', $config);
        }
        if ($this->checkRequiredParams() and $this->app->serviceProduct->save($this->getId())) {
            $this->toLocation('/product/table/?page=1');
            return;
        }
        $config['product'] = new EProduct();
        $this->app->serviceProduct->fillProductFromPost($config['product']);
        return $this->render('product/edit.twig', $config);
    }

    protected function delete_action(): void
    {
        if (!$this->app->authorization->isAdmin()) {
            $this->toLocation('/product/list/?page=1');
        }
        if ($this->app->serviceProduct->delete($this->getId())) {
            $this->toLocation('/product/table/?page=1');
            return;
        }
        $this->toLocation();
    }

}
