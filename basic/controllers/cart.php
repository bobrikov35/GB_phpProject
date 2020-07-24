<?php

/**
 * @return array
 */
function getGoods(): array
{
    if (!array_key_exists('cart', $_SESSION)) {
        return [];
    }
    $goods = array_keys($_SESSION['cart']);
    if (count($goods) == 0) {
        return [];
    }
    $goods = implode(',', $goods);
    $sql = "SELECT * FROM `goods` WHERE `id` in ({$goods})";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['quantity'] = $_SESSION['cart'][$result[$i]['id']];
        }
        return $result;
    }
    return [];
}


function default_action(): void
{
    $goods = getGoods();
    echo render('cart.php', [
        'title' => 'Корзина',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/cart.css?t=' . POSTFIX . '">',
        'cartItems' => $goods,
        'cartEmpty' => count($goods) == 0,
    ]);
}

function add_action(): void
{
    $id = getProductID();
    if ($id < 0) {
        changeLocation();
        return;
    }
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (empty($_SESSION['cart'][$id]) or $_SESSION['cart'][$id] < 0) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id] += 1;
    }
    changeLocation();
}

/**
 * @param bool $all
 */
function remove_action(bool $all = false): void
{
    $id = getProductID();
    if ($id < 0) {
        changeLocation();
        return;
    }
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$id]) and $_SESSION['cart'][$id] > 1 and !$all) {
        $_SESSION['cart'][$id] -= 1;
    } else {
        unset($_SESSION['cart'][$id]);
    }
    changeLocation();
}

function removeAll_action(): void
{
    remove_action(true);
}
