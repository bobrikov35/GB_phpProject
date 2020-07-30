<?php

namespace app\controllers;


/**
 * Class Cart
 * @package app\controllers
 */
class Cart extends Controller
{

    protected function default_action()
    {
        $this->toLocation('/cart/list');
    }

    /**
     * @return mixed
     */
    protected function list_action()
    {
        $config = $this->getConfig();
        $config['goods'] = $this->app->serviceCart->getList();
        $config['count'] = count($config['goods']);
        return $this->render('cart.twig', $config);
    }

    protected function add_action(): void
    {
        $this->app->serviceCart->add($this->getId());
        $this->toLocation();
    }

    protected function remove_action(): void
    {
        $this->app->serviceCart->remove($this->getId());
        $this->toLocation();
    }

    protected function delete_action(): void
    {
        $this->app->serviceCart->delete($this->getId());
        $this->toLocation();
    }

    protected function clear_action(): void
    {
        $this->app->serviceCart->clear();
        $this->toLocation();
    }

}
