<?php

namespace app\services;

use app\models\Model;


class Paginator
{

    private array $items = [];
    private int $quantity = 0;
    private int $itemsOnPage = 12;
    private string $path;


    /**
     * Paginator constructor.
     * @param string $path
     */
    public function __construct(string $path = '/?c=product&a=list')
    {
        $this->path = $path;
    }


    /**
     * @param Model $model
     * @param int $page
     */
    public function setItems(Model $model, int $page = 1): void
    {
        $this->quantity = $model->getQuantityItems();
        $this->items = $model->getItemsOnPage($page, $this->itemsOnPage);
    }


    /**
     * @return int
     */
    private function getPages(): int
    {
        $result = ceil($this->quantity / $this->itemsOnPage);
        if ($result) {
            return (int)$result;
        }
        return 1;
    }

    /**
     * @return array
     */
    public function getUrls(): array
    {
        $urls = [];
        for ($i = 1; $i <= $this->getPages(); $i++) {
            $urls[$i] = "{$this->path}&page={$i}";
        }
        return $urls;
    }

    /**
     * @return array Models
     */
    public function getItems(): array
    {
        return $this->items;
    }

}
