<?php

namespace app\services;

use app\entities\Entity;
use app\repositories\Repository;


/**
 * Class Paginator
 * @package app\services
 */
class Paginator extends Service
{

    /**
     * С В О Й С Т В А
     */

    private array $items = [];
    private int $quantity = 0;
    private int $itemsOnPage = 9;
    private string $path = '/product/list/?page=';


    /**
     * S E T T E R ' Ы
     */

    /**
     * @param Repository $repository
     * @param int $page
     */
    public function setItems(Repository $repository, int $page = 1): void
    {
        $this->quantity = $repository->getQuantityItems();
        $this->items = $repository->getItemsByPage($page, $this->itemsOnPage);
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }


    /**
     * G E T T E R ' Ы
     */

    /**
     * @return Entity[]|array
     */
    public function getItems(): array
    {
        return $this->items;
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * @return array
     */
    public function getUrls(): array
    {
        $urls = [];
        for ($i = 1; $i <= $this->getPages(); $i++) {
            $urls[$i] = $this->path . $i;
        }
        return $urls;
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

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

}
