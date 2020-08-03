<?php

namespace app\services;

use app\entities\{Product as EProduct};


/**
 * Class Product
 * @package app\services
 */
class Product extends Service
{

    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает товар из базы данных по id
     *
     * @param int $id
     * @return EProduct|null
     */
    public function getProduct(int $id)
    {
        return $this->container->repositoryProduct->getSingle($id);
    }

    /**
     * Возвращает товар с данными из POST-запроса
     *
     * @return EProduct
     */
    public function getProductFromPost()
    {
        $product = new EProduct();
        $this->fillProductFromPost($product);
        return $product;
    }

    /**
     * Сохраняет товар в базе данных
     *
     * @param int $id
     * @return bool|int
     */
    public function save(int $id)
    {
        if (empty($id)) {
            $product = new EProduct();
        } else {
            $product = $this->getProduct($id);
        }
        $this->fillProductFromPost($product);
        return $this->saveProduct($product);
    }

    /**
     * Удаляет товар из базы данных
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        if ($this->getProduct($id)) {
            return $this->deleteProduct($id);
        }
        return false;
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Заполняет товар данными из post-запроса
     *
     * @param EProduct $product
     */
    private function fillProductFromPost(EProduct $product):void
    {
        $product->setName($this->getPost('name'));
        $product->setTitle($this->getPost('title'));
        $product->setDescription($this->getPost('description'));
        $product->setImage($this->getPost('image'));
        $product->setPrice($this->getPost('price'));
        $product->setImagesFromString($this->getPost('images'));
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param EProduct $product
     * @return bool|int
     */
    private function saveProduct(EProduct $product)
    {
        return $this->container->repositoryProduct->save($product);
    }

    /**
     * @param int $id
     * @return bool
     */
    private function deleteProduct(int $id): bool
    {
        return $this->container->repositoryProduct->delete($id);
    }

}
