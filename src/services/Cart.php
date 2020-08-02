<?php

namespace app\services;

use app\entities\Product as EProduct;


/**
 * Class Cart
 * @package app\services
 */
class Cart extends Service
{

    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param int $id
     * @return EProduct|bool
     */
    private function getSingleProduct(int $id)
    {
        return $this->container->repositoryProduct->getSingle($id);
    }

    /**
     * @param string $param
     * @return mixed
     */
    private function getParams(string $param)
    {
        return $this->request->getParams('get', $param);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    private function setSession(string $name, $value)
    {
        $this->request->setSession($name, $value);
    }

    /**
     * @param string $param
     * @return mixed
     */
    private function getSession(string $param)
    {
        return $this->request->getSession($param);
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает содержимое корзины
     *
     * @return array
     */
    public function getList(): array
    {
        $cart = $this->getSession('cart');
        if (empty($cart)) {
            return [];
        };
        return $cart;
    }

    /**
     * Добвляет товар в корзину
     *
     * @param int $id_product
     * @return bool
     */
    public function add(int $id_product): bool
    {
        if (empty($id_product)) {
            return false;
        }
        $cart = $this->getSession('cart');
        if (empty($cart)) {
            $cart = [];
        }
        if (key_exists($id_product, $cart)) {
            $cart[$id_product]['quantity'] += $this->getQuantity();
            $this->setSession('cart', $cart);
            return true;
        }
        $product = $this->getSingleProduct($id_product);
        if (empty($product)) {
            $this->setSession('cart', $cart);
            return false;
        }
        $cart[$id_product] = [
            'time' => time(),
            'title' => $product->getTitle(),
            'image' => $product->getImage(),
            'price' => $product->getPrice(),
            'quantity' => $this->getQuantity(),
        ];
        $this->setSession('cart', $cart);
        return true;
    }

    /**
     * Убирает товар из корзины
     *
     * @param int $id_product
     * @param bool $all
     * @return bool
     */
    public function remove(int $id_product, bool $all = false): bool
    {
        if (empty($id_product)) {
            return false;
        }
        $cart = $this->getSession('cart');
        if (empty($cart)) {
            $this->clear();
            return false;
        }
        if (!key_exists($id_product, $cart)) {
            return false;
        }
        if ($all or $cart[$id_product]['quantity'] <= $this->getQuantity()) {
            unset($cart[$id_product]);
        } else {
            $cart[$id_product]['quantity'] -= $this->getQuantity();
        }
        $this->setSession('cart', $cart);
        return true;
    }

    public function delete(int $id_product): bool
    {
        return $this->remove($id_product, true);
    }

    public function clear(): void
    {
        $this->setSession('cart', []);
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает количество товара (для добавления или удаления)
     *
     * @return int    по умолчанию: 1
     */
    private function getQuantity(): int
    {
        $quantity = $this->getParams('quantity');
        if (empty($quantity) or !is_numeric($quantity) or (int)$quantity < 0) {
            return 1;
        }
        return (int)$quantity;
    }

}
