<?php

namespace app\controllers;


/**
 * Class Home
 * @package app\controllers
 */
class Home extends Controller
{

    /**
     * Д Е Й С Т В И Я
     */

    /**
     * Действие по умолчанию
     */
    protected function default_action()
    {
        $this->toLocation('/home/index');
    }

    /**
     * Выводит домашнюю страницу
     *
     * @return string
     */
    protected function index_action()
    {
        return $this->render('home.twig', $this->getConfig());
    }

}
