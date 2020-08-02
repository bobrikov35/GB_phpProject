<?php

namespace app\entities;


/**
 * Class Product
 * @package app\entities
 */
class Product extends Entity
{

    /**
     * С В О Й С Т В А
     */

    private string $name = '';
    private string $title = '';
    private string $description = '';
    private string $image = '';
    private int $price = 0;
    private array $images = [];
    private array $feedbacks = [];


    /**
     * О Б Я З А Т Е Л Ь Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * @return array
     */
    public function getVars(): array
    {
        $vars = get_object_vars($this);
        unset($vars['id']);
        unset($vars['images']);
        unset($vars['feedbacks']);
        return $vars;
    }


    /**
     * S E T T E R ' Ы
     */

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = '';
        if (!empty($name)) {
            $this->name = (string)$name;
        }
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = '';
        if (!empty($title)) {
            $this->title = (string)$title;
        }
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = '';
        if (!empty($description)) {
            $this->description = (string)$description;
        }
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = '';
        if (!empty($image)) {
            $this->image = (string)$image;
        }
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = 0;
        if (!empty($price) and is_numeric($price)) {
            $this->price = (int)$price;
        }
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = [];
        if (!empty($images)) {
            $this->images = $images;
        }
    }

    /**
     * @param string $images
     */
    public function setImagesFromString(string $images): void
    {
        $this->images = [];
        if (!empty($images) and $imagesList = explode(PHP_EOL, $images)) {
            $this->images = $imagesList;
        }
    }

    /**
     * @param array $feedbacks
     */
    public function setFeedbacks(array $feedbacks): void
    {
        $this->feedbacks = [];
        if (!empty($feedbacks)) {
            $this->feedbacks = $feedbacks;
        }
    }


    /**
     * G E T T E R ' Ы
     */

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getImagesToString(): string
    {
        return implode(PHP_EOL, $this->images);
    }

    /**
     * @return array
     */
    public function getFeedbacks(): array
    {
        return $this->feedbacks;
    }

}
