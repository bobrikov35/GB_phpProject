<?php

/**
 * @return array
 */
function getGoods(): array
{
    $sql = 'SELECT * FROM `goods`';
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
}


function default_action(): void
{
    $goods = getGoods();
    echo render('goods/index.php', [
        'title' => 'Товары',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/goods.css?t=' . POSTFIX . '">',
        'goods' => $goods,
        'noGoods' => count($goods) == 0,
    ]);
}

function table_action(): void
{
    if (empty($_SESSION['login']) or !$_SESSION['login'] or empty($_SESSION['admin']) or !$_SESSION['admin']) {
        changeLocation('/?p=goods');
        return;
    }
    $goods = getGoods();
    echo render('goods/table.php', [
        'title' => 'Товары',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/goods.css?t=' . POSTFIX . '">',
        'goods' => $goods,
        'noGoods' => count($goods) == 0,
    ]);
}
