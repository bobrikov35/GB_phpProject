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
        $goods = (new RProduct())->getList();
        return $this->render('product/index.twig',
            [
                'sol' => $this->getSol(),
                'menu' => $this->getMenu(),
                'goods' => $goods,
                'count' => count($goods),
            ]
        );
    }

    protected function table_action()
    {
        $goods = (new RProduct())->getList();
        return $this->render('product/table.twig',
            [
                'sol' => $this->getSol(),
                'menu' => $this->getMenu(),
                'goods' => $goods,
                'count' => count($goods),
            ]
        );
    }

    protected function single_action()
    {
        if (empty($product = (new RProduct())->getSingle($this->getId()))) {
            $this->changeLocation('/product/list');
            return false;
        }
        return $this->render('product/single.twig',
            [
                'sol' => $this->getSol(),
                'menu' => $this->getMenu(),
                'product' => $product,
            ]
        );
    }


    /**
     * @return mixed|void
     */
    public function create_action()
    {
        $config = [
            'showId' => false,
            'action' => '/product/create',
            'title' => 'Добавление товара',
            'button' => 'Добавить',
        ];
        if (empty($this->request->getPost())) {
            return $this->render('product/edit.twig',
                [
                    'config' => $config,
                    'sol' => $this->getSol(),
                    'menu' => $this->getMenu(),
                    'product' => new EProduct(),
                ]
            );
        }
        if (!empty($this->request->getPost('name')) and !empty($this->request->getPost('title'))
            and (new SProduct($this->request))->save($this->getId())) {
                $this->changeLocation('/product/table');
                return;
        }
        $product = new EProduct();
        (new SProduct($this->request))->fillProductFromPost($product);
        return $this->render('product/edit.twig',
            [
                'config' => $config,
                'sol' => $this->getSol(),
                'menu' => $this->getMenu(),
                'product' => $product,
            ]
        );
    }

    /**
     * @return mixed|void
     */
    public function update_action()
    {
        $config = [
            'showId' => true,
            'action' => "/product/update/?id={$this->getId()}",
            'title' => 'Редактирование товара',
            'button' => 'Сохранить изменения',
        ];
        if (empty($this->getId())) {
            $this->changeLocation("/product/create");
            return;
        }
        if (empty($this->request->getPost())) {
            return $this->render('product/edit.twig',
                [
                    'config' => $config,
                    'sol' => $this->getSol(),
                    'menu' => $this->getMenu(),
                    'product' => (new RProduct())->getSingle($this->getId()),
                ]
            );
        }
        if (!empty($this->request->getPost('name')) and !empty($this->request->getPost('title'))
            and (new SProduct($this->request))->save($this->getId())) {
                $this->changeLocation('/product/table');
                return;
        }
        $product = new EProduct();
        (new SProduct($this->request))->fillProductFromPost($product);
        return $this->render('product/edit.twig',
            [
                'config' => $config,
                'sol' => $this->getSol(),
                'menu' => $this->getMenu(),
                'product' => $product,
            ]
        );
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
