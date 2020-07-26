<?php

namespace app\controllers;

use app\entities\Product as EProduct;
use app\repositories\Product as RProduct;
use app\services\Product as SProduct;


class Product extends Controller
{

    protected function default_action()
    {
        return $this->list_action();
    }

    protected function list_action()
    {
        $config = $this->getConfig();
        $config['goods'] = (new RProduct())->getList();
        $config['count'] = count($config['goods']);
        return $this->render('product/index.twig', $config);
    }

    protected function table_action()
    {
        $config = $this->getConfig();
        $config['goods'] = (new RProduct())->getList();
        $config['count'] = count($config['goods']);
        return $this->render('product/table.twig', $config);
    }

    /**
     * @return mixed|void
     */
    protected function single_action()
    {
        $config = $this->getConfig();
        $config['product'] = (new RProduct())->getSingle($this->getId());
        if (empty($config['product'])) {
            $this->changeLocation('/product/list');
            return;
        }
        return $this->render('product/single.twig', $config);
    }


    private function checkRequiredParams(): bool
    {
        return !empty($this->request->getPost('name'))
            and !empty($this->request->getPost('title'));
    }

    /**
     * @return mixed|void
     */
    public function create_action()
    {
        $config = $this->getConfig();
        $config['action'] = '/product/create';
        $config['title'] = 'Добавление товара';
        $config['buttonTitle'] = 'Добавить';
        $config['showId'] = false;
        if (empty($this->request->getPost())) {
            $config['product'] = new EProduct();
            return $this->render('product/edit.twig', $config);
        }
        if ($this->checkRequiredParams() and (new SProduct($this->request))->save($this->getId())) {
            $this->changeLocation('/product/table');
            return;
        }
        $config['product'] = new EProduct();
        (new SProduct($this->request))->fillProductFromPost($config['product']);
        return $this->render('product/edit.twig', $config);
    }

    /**
     * @return mixed|void
     */
    public function update_action()
    {
        $config = $this->getConfig();
        $config['action'] = "/product/update/?id={$this->getId()}";
        $config['title'] = 'Редактирование товара';
        $config['buttonTitle'] = 'Сохранить изменения';
        $config['showId'] = true;
        if (empty($this->getId())) {
            $this->changeLocation("/product/create");
            return;
        }
        if (empty($this->request->getPost())) {
            $config['product'] = (new RProduct())->getSingle($this->getId());
            return $this->render('product/edit.twig', $config);
        }
        if ($this->checkRequiredParams() and (new SProduct($this->request))->save($this->getId())) {
            $this->changeLocation('/product/table');
            return;
        }
        $config['product'] = new EProduct();
        (new SProduct($this->request))->fillProductFromPost($config['product']);
        return $this->render('product/edit.twig', $config);
    }

    public function delete_action()
    {
        if ((new SProduct($this->request))->delete($this->getId())) {
            $this->changeLocation('/product/table');
            return;
        }
        $this->changeLocation();
    }

}
