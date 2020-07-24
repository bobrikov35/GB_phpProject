<?php

/**
 * @param int $order
 * @return array
 */
function getGoods(int $order): array {
    $sql = "SELECT `orders`.id as `order`, `orders`.status as `status`, `goods`.`id` as `product`,
                   `goods`.`name` as `name`, `goods`.`title` as `title`, `goods`.`image` as `image`,
                   `order_product`.`price` as `price`, `order_product`.`quantity` as `quantity` FROM `orders`
            LEFT JOIN `order_product` ON `orders`.`id`=`order_product`.`id_order`
            LEFT JOIN `goods` ON `order_product`.`id_product`=`goods`.`id`
            WHERE `orders`.`id` = {$order}";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
}

/**
 * @param bool $all
 * @return array
 */
function getOrders($all = false): array {
    $id = getUserID();
    $sql = "SELECT `orders`.`id` as `order`, `users`.`email` as `user`, `orders`.`status` as `status`,
                   SUM(`order_product`.`price`) as `cost`, SUM(`order_product`.`quantity`) as `quantity`,
                   COUNT(`order_product`.`quantity`) as `count` FROM `orders`
            LEFT JOIN `order_product` ON `orders`.`id` = `order_product`.`id_order`
            LEFT JOIN `users` ON `orders`.`id_user` = `users`.`id`";
    if (!$all) {
        $sql .= " WHERE `id_user` = {$id}";
    }
    $sql .= ' GROUP BY `orders`.`id` ORDER BY `orders`.`id` DESC';
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
}

/**
 * @return array
 */
function getStatuses(): array {
    $sql = "SHOW COLUMNS FROM `orders` LIKE 'status'";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        $types = mysqli_fetch_assoc($result)['Type'];
        $types = explode('\'', $types);
        $result = [];
        for ($i = 1; $i < count($types); $i += 2) {
            $result[] = $types[$i];
        }
        return $result;
    }
    return [];
}


function default_action(): void {
    $userId = getUserID();
    if ($userId < 0) {
        changeLocation('/?p=goods');
        return;
    }
    $orderList = getOrders();
    echo render('orders/index.php', [
        'title' => 'Заказы',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/orders.css?t=' . POSTFIX . '">',
        'orderList' => $orderList,
        'noOrders' => count($orderList) == 0,
    ]);
}

function view_action(): void {
    $userId = getUserID();
    $id = getOrderID();
    if ($id < 0 or $userId < 0) {
        changeLocation('/?p=orders');
        return;
    }
    $goods = getGoods($id);
    echo render('orders/order.php', [
        'title' => "Заказ №{$id}",
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/orders.css?t=' . POSTFIX . '">',
        'goods' => $goods,
    ]);
}

function make_action(): void {
    if (count($_SESSION['cart']) == 0) {
        changeLocation('/?p=cart');
        return;
    }
    $userId = getUserID();
    $sql = "INSERT INTO `orders` (`id_user`, `status`) VALUES ({$userId}, 'Передан на обработку')";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        $orderId = mysqli_insert_id(getDatabase());
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $sql = "SELECT `price` FROM `goods` WHERE `id` = {$id}";
            $result = mysqli_query(getDatabase(), $sql);
            $price = mysqli_fetch_assoc($result)['price'];
            $sql = "INSERT INTO `order_product` (`id_order`, `id_product`, `price`, `quantity`)
                    VALUES ({$orderId}, {$id}, '{$price}', {$quantity})";
            mysqli_query(getDatabase(), $sql);
        }
        unset($_SESSION['cart']);
        changeLocation('/?p=orders');
        return;
    }
    changeLocation();
}

function cancel_action(): void {
    $userId = getUserID();
    $orderId = getOrderID();
    $sql = "UPDATE `orders` SET `status` = 'Отменен' WHERE `id` = {$orderId} and `id_user` = {$userId}";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        changeLocation('/?p=orders');
        return;
    }
    changeLocation();
}

function change_action(): void {
    if (empty($_SESSION['login']) or !$_SESSION['login'] or empty($_SESSION['admin']) or !$_SESSION['admin']) {
        changeLocation('/?p=goods');
        return;
    }
    if (empty($_GET['id']) or !is_numeric($_GET['id']) or empty($_GET['status']) or $_GET['status'] == '') {
        changeLocation();
        return;
    }
    $id = (int)$_GET['id'];
    $status = $_GET['status'];
    if (!in_array($status, getStatuses())) {
        changeLocation();
        return;
    }
    $sql = "UPDATE `orders` SET `status` = '{$status}' WHERE `id` = {$id}";
    $result = mysqli_query(getDatabase(), $sql);
    changeLocation();
}

function table_action(): void {
    if (empty($_SESSION['login']) or !$_SESSION['login'] or empty($_SESSION['admin']) or !$_SESSION['admin']) {
        changeLocation('/?p=goods');
        return;
    }
    $statuses = getStatuses();
    $orders = getOrders(true);
    echo render('orders/table.php', [
        'title' => 'Товары',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/orders.css?t=' . POSTFIX . '">',
        'orders' => $orders,
        'statuses' => $statuses,
        'noOrders' => count($orders) == 0,
    ]);
}
