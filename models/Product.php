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
     * @return array
     */
    public function getFeedbacks(): array
    {
        if (empty($this->feedbacks)) {
            $this->updateFeedbacks();
        }
        return $this->feedbacks;
    }

}
