<?php

namespace app\entities;


/**
 * Class Order
 * @package app\entities
 */
class Order extends Entity
{

    /**
     * С В О Й С Т В А
     */

    private string $status = 'Передан на обработку';
    private int $count = 0;
    private int $quantity = 0;
    private int $cost = 0;
    private array $goods = [];


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
        unset($vars['goods']);
        return $vars;
    }


    /**
     * S E T T E R ' Ы
     */

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = !empty($status) ? (string)$status : '';
    }

    /**
     * @param mixed $count
     */
    public function setCount($count): void
    {
        $this->count = !empty($count) and is_numeric($count) ? (int)$count : 0;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = !empty($quantity) and is_numeric($quantity) ? (int)$quantity : 0;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost): void
    {
        $this->cost = !empty($cost) and is_numeric($cost) ? (int)$cost : 0;
    }

    /**
     * @param array $goods
     */
    public function setGoods(array $goods): void
    {
        $this->goods = !empty($goods) ? $goods : [];
    }


    /**
     * G E T T E R ' Ы
     */

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @return array
     */
    public function getGoods(): array
    {
        return $this->goods;
    }

}