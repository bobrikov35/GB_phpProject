<?php

namespace app\models;


class Product extends Model
{

    public string $name = '';
    public string $title = '';
    public string $description = '';
    public string $image = '';
    public float $price = 0;
    private array $images;
    private array $feedbacks;


    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'goods';
    }


    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    public function setImagesFromString(string $images): void
    {
        if ($images = explode(PHP_EOL, $images)) {
            $this->images = $images;
        }
        $this->images = [];
    }


    public function updateImages(): void
    {
        $this->images = [];
        $sql = 'SELECT `link` FROM `images` WHERE `id_product` = :id';
        if ($result = static::getDatabase()->readTable($sql, [':id' => $this->getId()])) {
            $this->images = [];
            foreach ($result as $row) {
                $this->images[] = $row['link'];
            }
        }
    }

    public function updateFeedbacks(): void
    {
        $this->feedbacks = [];
        $sql = 'SELECT `name`, `email`, `comment` FROM `feedbacks` WHERE `id_product` = :id';
        if ($result = static::getDatabase()->readTable($sql, [':id' => $this->getId()])) {
            foreach ($result as $row) {
                $this->feedbacks[] = [
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'comment' => $row['comment'],
                ];
            }
        }
    }


    /**
     * @return array
     */
    public function getImages(): array
    {
        if (empty($this->images)) {
            $this->updateImages();
        }
        return $this->images;
    }

    /**
     * @return string
     */
    public function getImagesToString(): string
    {
        if (empty($this->images)) {
            $this->updateImages();
        }
        return implode(PHP_EOL, $this->images);
    }

    /**
     * @return array
     */
    public function getFeedbacks(): array
    {
        if (empty($this->feedbacks)) {
            $this->updateFeedbacks();
        }
        return $this->feedbacks;
    }


    /**
     * @param int $id
     * @return mixed
     */
    public static function getSingle($id)
    {
        if ($product = parent::getSingle($id)) {
            $product->updateImages();
            $product->updateFeedbacks();
        }
        return $product;
    }


    /**
     * @return int
     */
    protected function insert(): int
    {
        if (!$id = parent::insert() or empty($this->images)) {
            return $id;
        }
        foreach ($this->images as $image) {
            if ($image == '') {
                continue;
            }
            $sql = "INSERT INTO `images` (`link`, `id_product`) VALUES (:image, :id)";
            static::getDatabase()->execute($sql, [':image' => $image, ':id' => $id]);
        }
        return $id;
    }

    /**
     * @return bool
     */
    protected function update(): bool
    {
        if (!parent::update()) {
            return false;
        }
        $newImages = array_unique($this->images);
        $this->updateImages();
        foreach ($this->getImages() as $image) {
            if (in_array($image, $newImages, true)) {
                continue;
            }
            $sql = "DELETE FROM `images` WHERE `id_product` = :id and `link` = :image";
            static::getDatabase()->execute($sql, [':id' => $this->getId(), ':image' => $image]);
        }
        foreach ($newImages as $image) {
            if (in_array($image, $this->getImages(), true)) {
                continue;
            }
            $sql = "INSERT INTO `images` (`link`, `id_product`) VALUES (:image, :id)";
            static::getDatabase()->execute($sql, [':image' => $image, ':id' => $this->getId()]);
        }
        return true;
    }

}
