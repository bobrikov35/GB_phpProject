<?php

namespace app\controllers;

use app\services\Cart as SCart;


class Cart extends Controller
{

    protected function default_action()
    {
        return $this->list_action();
    }

    protected function list_action()
    {
        $config = $this->getConfig();
        $config['goods'] = (new SCart($this->request))->getList();
        $config['count'] = count($config['goods']);
        return $this->render('cart.twig', $config);
    }


    protected function add_action()
    {
        (new SCart($this->request))->add($this->getId());
        $this->changeLocation();
    }

    protected function remove_action()
    {
        (new SCart($this->request))->remove($this->getId());
        $this->changeLocation();
    }

    protected function delete_action()
    {
        (new SCart($this->request))->delete($this->getId());
        $this->changeLocation();
    }

    protected function clear_action()
    {
        (new SCart($this->request))->clear();
        $this->changeLocation();
    }

}
