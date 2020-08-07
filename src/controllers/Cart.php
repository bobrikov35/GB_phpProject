<?php

namespace app\controllers;


/**
 * Class Cart
 * @package app\controllers
 */
class Cart extends Controller
{

    /**
     * Действие по умолчанию
     */
    protected function default_action()
    {
        $this->toLocation('/cart/list');
    }

    /**
     * Выводит корзину
     *
     * @return string
     */
    protected function list_action()
    {
        $config = $this->getConfig();
        $config['goods'] = $this->getList();
        $config['count'] = count($config['goods']);
        return $this->render('cart.twig', $config);
    }

    /**
     * Добавляет в корзину
     */
    protected function add_action(): void
    {
        $this->add();
        $this->toLocation();
    }

    /**
     * Убирает из корзины
     */
    protected function remove_action(): void
    {
        $this->remove();
        $this->toLocation();
    }

    /**
     * Удаляет из корзины
     */
    protected function delete_action(): void
    {
        $this->delete();
        $this->toLocation();
    }

    /**
     * Очищает корзину
     */
    protected function clear_action(): void
    {
        $this->clear();
        $this->toLocation();
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @return array
     */
    private function getList(): array
    {
        return $this->app->serviceCart->getList();
    }

    /**
     * @return bool
     */
    private function add(): bool
    {
        return $this->app->serviceCart->add($this->getId());
    }

    /**
     * @return bool
     */
    private function remove(): bool
    {
        return $this->app->serviceCart->remove($this->getId());
    }

    /**
     * @return bool
     */
    private function delete(): bool
    {
        return $this->app->serviceCart->delete($this->getId());
    }

    private function clear()
    {
        $this->app->serviceCart->clear();
    }



    /**
     * Помощник ide (не вызывать)
     */
    protected function __ideHelper()
    {
        /** Функции вызываются динамически (см. class Controller) */
        $this->default_action();
        $this->list_action();
        $this->add_action();
        $this->remove_action();
        $this->delete_action();
        $this->clear_action();
    }

}
