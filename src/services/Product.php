<?php

namespace app\services;

use app\entities\Product as EProduct;


/**
 * Class Product
 * @package app\services
 */
class Product extends Service
{

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
            $product = $this->container->repositoryProduct->getSingle($id);
        }
        $this->fillProductFromPost($product);
        return (bool)$this->container->repositoryProduct->save($product);
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
        $product = $this->container->repositoryProduct->getSingle($id);
        if (empty($product)) {
            return false;
        }
        return $this->container->repositoryProduct->delete($id);
    }

}
