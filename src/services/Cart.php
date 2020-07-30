<?php

namespace app\services;


/**
 * Class Cart
 * @package app\services
 */
class Cart extends Service
{

    /**
     * @return int
     */
    private function getQuantity(): int
    {
        $quantity = $this->request->getParams('get', 'quantity');
        if (empty($quantity) or !is_numeric($quantity)) {
            return 1;
        }
        return (int)$quantity;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $cart = $this->request->getSession('cart');
        if (empty($cart)) {
            return [];
        };
        return $cart;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function add(int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        $cart = $this->request->getSession('cart');
        if (empty($cart)) {
            $cart = [];
        }
        if (key_exists($id, $cart)) {
            $cart[$id]['quantity'] += $this->getQuantity();
            $this->request->setSession('cart', $cart);
            return true;
        }
        $product = $this->container->repositoryProduct->getSingle($id);
        if (empty($product)) {
            $this->request->setSession('cart', $cart);
            return false;
        }
        $cart[$id] = [
            'time' => time(),
            'title' => $product->getTitle(),
            'image' => $product->getImage(),
            'price' => $product->getPrice(),
            'quantity' => $this->getQuantity(),
        ];
        $this->request->setSession('cart', $cart);
        return true;
    }

    /**
     * @param int $id
     * @param bool $all
     * @return bool
     */
    public function remove(int $id, bool $all = false): bool
    {
        if (empty($id)) {
            return false;
        }
        $cart = $this->request->getSession('cart');
        if (empty($cart)) {
            $cart = [];
            $this->request->setSession('cart', $cart);
            return false;
        }
        if (!key_exists($id, $cart)) {
            return false;
        }
        if ($all or $cart[$id]['quantity'] <= $this->getQuantity()) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] -= $this->getQuantity();
        }
        $this->request->setSession('cart', $cart);
        return true;
    }

    public function delete(int $id): bool
    {
        return $this->remove($id, true);
    }

    public function clear(): void
    {
        $this->request->setSession('cart', []);
    }

}
