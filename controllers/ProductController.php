<?php

namespace app\controllers;

use app\models\Product;


class ProductController extends Controller
{

    /**
     * @return Product|bool
     */
    private function getProduct()
    {
        if (empty($_POST)) {
            return false;
        }
        $product = new Product();
        $product->setId($this->getId());
        $product->name = $this->getPostParam('name');
        $product->title = $this->getPostParam('title');
        $product->description = $this->getPostParam('description');
        $product->image = $this->getPostParam('image');
        $product->price = $this->getPostParam('price', 'float');
        $product->setImages($this->getPostParam('images', 'array'));
        return $product;
    }


    protected function default_action()
    {
        return $this->list_action();
    }

    protected function list_action()
    {
        return $this->render('product/index',
            [
                'title' => 'Каталог товаров',
                'menu' => $this->getMenu(),
                'goods' => Product::getList(),
            ]
        );
    }

    protected function table_action()
    {
        return $this->render('product/table',
            [
                'title' => 'Товары',
                'menu' => $this->getMenu(),
                'goods' => Product::getList(),
            ]
        );
    }

    protected function single_action()
    {
        $product = Product::getSingle($this->getId());
        if (!$product) {
            $this->changeLocation('/?c=product&a=list');
            return false;
        }
        return $this->render('product/single',
            [
                'title' => 'Товар',
                'menu' => $this->getMenu(),
                'product' => $product,
            ]
        );
    }

    public function create_action()
    {
        $config = [
            'showId' => false,
            'action' => '/?c=product&a=create',
            'title' => 'Добавление товара',
            'button' => 'Добавить',
        ];
        if (!$product = $this->getProduct()) {
            return $this->render('product/edit',
                [
                    'config' => $config,
                    'title' => 'Добавление товара',
                    'menu' => $this->getMenu(),
                    'product' => new Product(),
                ]
            );
        }
        if ($product->name == '' or $product->title == '' or !$id = $product->save()) {
            return $this->render('product/edit',
                [
                    'config' => $config,
                    'title' => 'Добавление товара',
                    'menu' => $this->getMenu(),
                    'product' => $product,
                ]
            );
        }
        $this->changeLocation('/?c=product&a=table');
        return;
    }

    public function update_action()
    {
        $config = [
            'showId' => true,
            'action' => "/?c=product&a=update&id={$this->getId()}",
            'title' => 'Изменение товара',
            'button' => 'Сохранить изменения',
        ];
        if (empty($this->getId())) {
            $this->changeLocation("/?c=product&a=create");
            return;
        }
        if (!$product = $this->getProduct()) {
            return $this->render('product/edit',
                [
                    'config' => $config,
                    'title' => 'Редактирование товара',
                    'menu' => $this->getMenu(),
                    'product' => Product::getSingle($this->getId()),
                ]
            );
        }
        if ($product->name == '' or $product->title == '' or !$product->save()) {
            return $this->render('product/edit',
                [
                    'config' => $config,
                    'title' => 'Редактирование товара',
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
        Product::getSingle($this->getId())->delete();
        $this->changeLocation('/?c=product&a=table');
        return;
    }

}
