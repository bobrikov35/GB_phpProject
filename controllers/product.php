<?php

/**
 * @return bool
 */
function checkData(): bool {
    if (empty($_SESSION['product'])) return false;
    foreach ($_SESSION['product'] as $field) {
        if ($field == '') return false;
    }
    return true;
}


/**
 * @param array $DATA
 */
function setData(array $DATA): void {
    unset($_SESSION['product']['id']);
    $_SESSION['product']['name'] = (isset($DATA['name']) and $DATA['name'] != '') ? $DATA['name'] : null;
    $_SESSION['product']['title'] = (isset($DATA['title']) and $DATA['title'] != '') ? $DATA['title'] : null;
    $_SESSION['product']['description'] = (isset($DATA['description']) and $DATA['description'] != '') ?
        $DATA['description'] : null;
    $_SESSION['product']['image'] = (isset($DATA['image']) and $DATA['image'] != '') ? $DATA['image'] : null;
    $_SESSION['product']['price'] = (isset($DATA['price']) and is_numeric($DATA['price'])) ?
        floatval($DATA['price']) : null;
    $_SESSION['product']['images'] = (isset($DATA['images'])) ?
        explode(PHP_EOL, $DATA['images']) : [''];
}


/**
 * @param int $id
 * @return bool|string[]|null
 */
function getProduct(int $id) {
    $sql = "SELECT `id`, `name`, `title`, `description`, `image`, `price` FROM `goods` WHERE `id` = {$id}";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

/**
 * @param int $id
 * @return array
 */
function getImages(int $id): array {
    $sql = "SELECT `link` FROM `images` WHERE `id_product` = {$id}";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
}

/**
 * @param $id
 * @return array
 */
function getFeedbacks($id): array {
    $sql = "SELECT `name`, `email`, `comment` FROM `feedbacks` WHERE `id_product` = {$id} ORDER BY `id` DESC";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
}

/**
 * @return array
 */
function getData(): array {
    $result['name'] = (isset($_SESSION['product']['name'])) ? $_SESSION['product']['name'] : '';
    $result['title'] = (isset($_SESSION['product']['title'])) ? $_SESSION['product']['title'] : '';
    $result['description'] = (isset($_SESSION['product']['description'])) ? $_SESSION['product']['description'] : '';
    $result['image'] = (isset($_SESSION['product']['image'])) ? $_SESSION['product']['image'] : '';
    $result['price'] = (isset($_SESSION['product']['price'])) ? $_SESSION['product']['price'] : '';
    $result['images'] = (isset($_SESSION['product']['images']) and count($_SESSION['product']['images']) > 0) ?
        implode(PHP_EOL, $_SESSION['product']['images']) : '';
    return $result;
}


function default_action(): void {
    $id = getProductID();
    $result = getProduct($id);
    if (!$result) {
        changeLocation('/?p=goods');
        return;
    }
    echo render('product/index.php', [
        'title' => 'Товар',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/product.css?t=' . POSTFIX . '">',
        'product' => $result,
        'images' => getImages($id),
        'feedbacks' => getFeedbacks($id),
    ]);
}

function insert_action(): void {
    if (!isAdmin()) {
        changeLocation('/?p=goods');
        return;
    }
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $page = [
            'id' => null,
            'action' => '/?p=product&a=insert',
            'button' => 'Добавить',
        ];
        echo render('product/edit.php', [
            'title' => 'Добавление товара',
            'styles' => '<link rel="stylesheet" type="text/css" href="/css/product.css?t=/' . POSTFIX . '">',
            'page' => $page,
            'data' => getData(),
        ]);
        return;
    }
    setData($_POST);
    if (!checkData()) {
        changeLocation('/?p=product&a=insert');
        return;
    }
    $sql = "INSERT INTO `goods` (`name`, `title`, `description`, `image`, `price`)
            VALUES ('{$_SESSION['product']['name']}', '{$_SESSION['product']['title']}',
            '{$_SESSION['product']['description']}', '{$_SESSION['product']['image']}',
            {$_SESSION['product']['price']})";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        $id = mysqli_insert_id(getDatabase());
        foreach ($_SESSION['product']['images'] as $image) {
            if ($image == '') continue;
            $sql = "INSERT INTO `images` (`link`, `id_product`) VALUES ('{$image}', '{$id}')";
            mysqli_query(getDatabase(), $sql);
        }
        unset($_SESSION['product']);
        changeLocation('/?p=goods&a=table');
        return;
    }
    changeLocation();
}

function update_action(): void {
    if (!isAdmin()) {
        changeLocation('/?p=goods');
        return;
    }
    $id = getProductID();
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $page = [
            'id' => $id,
            'action' => "/?p=product&a=update&id={$id}",
            'button' => 'Изменить',
        ];
        $result = getProduct($id);
        if (!$result) {
            changeLocation();
            return;
        }
        $result['images'] = getImages($id);
        for ($i = 0; $i < count($result['images']); $i++) {
            $result['images'][$i] = $result['images'][$i]['link'];
        }
        $result['images'] = implode(PHP_EOL, $result['images']);
        echo render('product/edit.php', [
            'title' => 'Редактирование товара',
            'styles' => '<link rel="stylesheet" type="text/css" href="/css/product.css?t=' . POSTFIX . '">',
            'page' => $page,
            'data' => $result,
        ]);
        return;
    }
    setData($_POST);
    if (!checkData()) {
        changeLocation('/?p=product&a=update');
        return;
    }
    $sql = "UPDATE `goods`
            SET `name` = '{$_SESSION['product']['name']}', `title` = '{$_SESSION['product']['title']}',
                `description` = '{$_SESSION['product']['description']}', `image` = '{$_SESSION['product']['image']}',
                `price` = '{$_SESSION['product']['price']}'
            WHERE `id` = {$id}";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        $sql = "SELECT `id`, `link` FROM `images` WHERE `id_product` = {$id}";
        $result = mysqli_query(getDatabase(), $sql);
        $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($images as $key => $image) {
            if (in_array($image['link'], $_SESSION['product']['images'])) continue;
            $sql = "DELETE FROM `images` WHERE `id` = {$image['id']}";
            mysqli_query(getDatabase(), $sql);
            $images[$key] = $image['link'];
        }
        foreach ($_SESSION['product']['images'] as $image) {
            if (in_array($image, $images)) continue;
            $sql = "INSERT INTO `images` (`link`, `id_product`) VALUES ('{$image}', '{$id}')";
            mysqli_query(getDatabase(), $sql);
        }
        unset($_SESSION['product']);
        changeLocation('/?p=goods&a=table');
        return;
    }
    changeLocation();
}

function delete_action(): void {
    if (!isAdmin()) {
        changeLocation('/?p=goods');
        return;
    }
    $id = getProductID();
    if ($id < 0) {
        changeLocation();
        return;
    }
    $sql = "DELETE FROM `goods` WHERE `id` = {$id}";
    mysqli_query(getDatabase(), $sql);
    changeLocation();
}
