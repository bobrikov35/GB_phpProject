<?php

namespace app\controllers;


class Home extends Controller
{

    protected function default_action()
    {
        return $this->render('home.twig', $this->getConfig());
    }

}
