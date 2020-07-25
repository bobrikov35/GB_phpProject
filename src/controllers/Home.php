<?php

namespace app\controllers;


class Home extends Controller
{

    protected function default_action()
    {
        return $this->render('home.twig',
            [
                'sol' => $this->getSol(),
                'menu' => $this->getMenu(),
            ]
        );
    }

}
