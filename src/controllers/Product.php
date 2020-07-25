<?php

namespace app\controllers;

use app\models\Product as MProduct;


class Product extends Controller
{

    /**
     * @return MProduct|bool
     */
    private function getProduct()
    {
        if (empty($_POST)) {
            return false;
        }
        $product = new MProduct();
        $product->setId($this->getId());
        $product->name = $this->request->getPost('name');
        $product->title = $this->request->getPost('title');
        $product->description = $this->request->getPost('description');
        $product->image = $this->request->getPost('image');
        $product->price = $this->request->getPost('price', 'float');
        $product->setImages($this->request->getPost('images', 'array'));
        return $product;
    }


    protected function default_action()
    {
        return $this->list_action();
    }

    protected function list_action()
    {
        $goods = MProduct::getList();
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
        $goods = MProduct::getList();
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
        $product = MProduct::getSingle($this->getId());
        if (!$product) {
            $this->changeLocation('/?c=product&a=list');
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
            'action' => '/?c=product&a=create',
            'title' => 'Добавление товара',
            'button' => 'Добавить',
        ];
        if (!$product = $this->getProduct()) {
            return $this->render('product/edit.twig',
                [
                    'config' => $config,
                    'sol' => $this->getSol(),
                    'menu' => $this->getMenu(),
                    'product' => new MProduct(),
                ]
            );
        }
        if ($product->name == '' or $product->title == '' or !$id = $product->save()) {
            return $this->render('product/edit.twig',
                [
                    'config' => $config,
                    'sol' => $this->getSol(),
                    'menu' => $this->getMenu(),
                    'product' => $product,
                ]
            );
        }
        $this->changeLocation('/?c=product&a=table');
        return;
    }

    /**
     * @return mixed|void
     */
    public function update_action()
    {
        $config = [
            'showId' => true,
            'action' => "/?c=product&a=update&id={$this->getId()}",
            'title' => 'Редактирование товара',
            'button' => 'Сохранить изменения',
        ];
        if (empty($this->getId())) {
            $this->changeLocation("/?c=product&a=create");
            return;
        }
        if (!$product = $this->getProduct()) {
            return $this->render('product/edit.twig',
                [
                    'config' => $config,
                    'sol' => $this->getSol(),
                    'menu' => $this->getMenu(),
                    'product' => MProduct::getSingle($this->getId()),
                ]
            );
        }
        if ($product->name == '' or $product->title == '' or !$product->save()) {
            return $this->render('product/edit.twig',
                [
                    'config' => $config,
                    'sol' => $this->getSol(),
                    'menu' => $this->getMenu(),
                    'product' => $product,
                ]
            );
        }
        $this->changeLocation('/?c=product&a=table');
        return;
    }

    public function delete_action()
    {
        MProduct::getSingle($this->getId())->delete();
        $this->changeLocation('/?c=product&a=table');
        return;
    }

}
