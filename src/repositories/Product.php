<?php

namespace app\repositories;

use app\entities\{Entity, Product as EProduct};


/**
 * Class Product
 * @package app\repositories
 */
class Product extends Repository
{

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'goods';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return EProduct::class;
    }


    /**
     * @param EProduct $product
     * @return void
     */
    public function fetchImages(EProduct $product): void
    {
        $images = [];
        $sql = 'SELECT `link` FROM `images` WHERE `id_product` = :id';
        if ($result = $this->getDatabase()->readTable($sql, [':id' => $product->getId()])) {
            foreach ($result as $row) {
                $images[] = $row['link'];
            }
        }
        $product->setImages($images);
    }

    /**
     * @param EProduct $product
     * @return void
     */
    public function fetchFeedbacks(EProduct $product): void
    {
        $feedbacks = [];
        $sql = 'SELECT `name`, `email`, `comment` FROM `feedbacks` WHERE `id_product` = :id';
        if ($result = $this->getDatabase()->readTable($sql, [':id' => $product->getId()])) {
            foreach ($result as $row) {
                $feedbacks[] = [
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'comment' => $row['comment'],
                ];
            }
        }
        $product->setFeedbacks($feedbacks);
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getSingle(int $id)
    {
        if ($product = parent::getSingle($id)) {
            $this->fetchImages($product);
            $this->fetchFeedbacks($product);
        }
        return $product;
    }

    /**
     * @param Entity $product
     * @return int
     */
    protected function insert(Entity $product): int
    {
        /**
         * @var EProduct $product
         */
        if (!$id = parent::insert($product) or empty($product->getImages())) {
            return $id;
        }
        foreach ($product->getImages() as $image) {
            if ($image == '') {
                continue;
            }
            $sql = "INSERT INTO `images` (`link`, `id_product`) VALUES (:link, :id)";
            $this->getDatabase()->execute($sql, [':link' => $image, ':id' => $id]);
        }
        return $id;
    }

    /**
     * @param Entity $product
     * @return bool
     */
    protected function update(Entity $product): bool
    {
        if (!parent::update($product)) {
            return false;
        }
        /**
         * @var EProduct $product
         */
        $newImages = array_unique($product->getImages());
        $this->fetchImages($product);
        foreach ($product->getImages() as $image) {
            if (in_array($image, $newImages, true)) {
                continue;
            }
            $sql = "DELETE FROM `images` WHERE `id_product` = :id and `link` = :link";
            $this->getDatabase()->execute($sql, [':id' => $product->getId(), ':link' => $image]);
        }
        foreach ($newImages as $image) {
            if (in_array($image, $product->getImages(), true)) {
                continue;
            }
            $sql = "INSERT INTO `images` (`link`, `id_product`) VALUES (:link, :id)";
            $this->getDatabase()->execute($sql, [':id' => $product->getId(), ':link' => $image]);
        }
        return true;
    }

}
