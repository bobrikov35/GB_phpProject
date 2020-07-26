<?php

namespace app\services;

use app\repositories\Product as RProduct;


class Cart
{

    private Request $request;


    /**
     * Product constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @return int
     */
    private function getQuantity(): int
    {
        $quantity = $this->request->getParams('get', 'quantity', 'int');
        if ($quantity < 1) {
            return 1;
        }
        return $quantity;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        if (!empty($cart = $this->request->getSession('cart'))) {
            return $cart;
        };
        return [];
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
        if (empty($cart = $this->request->getSession('cart'))) {
            $cart = [];
        }
        if (key_exists($id, $cart)) {
            $cart[$id]['quantity'] += $this->getQuantity();
            $this->request->setSession('cart', $cart);
            return true;
        }
        $product = (new RProduct())->getSingle($id);
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
        if (empty($cart = $this->request->getSession('cart'))) {
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
