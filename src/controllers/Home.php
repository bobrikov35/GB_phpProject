<?php

namespace app\controllers;


/**
 * Class Home
 * @package app\controllers
 */
class Home extends Controller
{

    protected function default_action()
    {
        $this->toLocation('/home/index');
    }

    protected function index_action()
    {
        return $this->render('home.twig', $this->getConfig());
    }

}
