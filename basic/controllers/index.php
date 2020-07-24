<?php

function default_action()
{
    echo render('home.php', [
        'title' => 'Главная страница',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/home.css?t=' . POSTFIX . '">',
    ]);
}
