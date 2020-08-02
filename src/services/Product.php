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
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param int $id
     * @return EProduct|null
     */
    private function getSingleProduct(int $id)
    {
        return $this->container->repositoryProduct->getSingle($id);
    }

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

    /**
     * @param string $param
     * @return array|mixed|null
     */
    private function getPost(string $param)
    {
        return $this->request->getPost($param);
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Заполняет товар данными из post-запроса
     *
     * @param EProduct $product
     */
    public function fillProductFromPost(EProduct $product):void
    {
        $product->setName($this->getPost('name'));
        $product->setTitle($this->getPost('title'));
        $product->setDescription($this->getPost('description'));
        $product->setImage($this->getPost('image'));
        $product->setPrice($this->getPost('price'));
        $product->setImagesFromString($this->getPost('images'));
    }

    /**
     * Сохранение товара
     *
     * @param int $id
     * @return bool|int
     */
    public function save(int $id)
    {
        if (empty($id)) {
            $product = new EProduct();
        } else {
            $product = $this->getSingleProduct($id);
        }
        $this->fillProductFromPost($product);
        return $this->saveProduct($product);
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
        $product = $this->getSingleProduct($id);
        if (empty($product)) {
            return false;
        }
        return $this->deleteProduct($id);
    }

}
