<?php

namespace app\services;

use app\entities\Product as EProduct;
use app\repositories\Product as RProduct;


class Product
{

    private Request $request;


    /**
     * Product constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @param EProduct $product
     */
    public function fillProductFromPost(EProduct $product)
    {
        $product->setName($this->request->getPost('name'));
        $product->setTitle($this->request->getPost('title'));
        $product->setDescription($this->request->getPost('description'));
        $product->setImage($this->request->getPost('image'));
        $product->setPrice($this->request->getPost('price'));
        $product->setImagesFromString($this->request->getPost('images'));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function save(int $id): bool
    {
        if (empty($id)) {
            $product = new EProduct();
        } else {
            $product = (new RProduct())->getSingle($id);
        }
        $this->fillProductFromPost($product);
        return (bool)(new RProduct())->save($product);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        if ($product = (new RProduct())->getSingle($id)) {
            return (new RProduct())->delete($id);
        }
        return false;
    }

}
