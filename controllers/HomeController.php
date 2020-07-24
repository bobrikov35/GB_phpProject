<?php

namespace app\controllers;


class HomeController extends Controller
{

    protected function default_action()
    {
        return $this->render('home',
            [
                'title' => 'Главная',
                'menu' => $this->getMenu(),
            ]
        );
    }

}
