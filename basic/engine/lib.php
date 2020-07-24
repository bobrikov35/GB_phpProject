<?php

session_start();
define('ROOT_DIR', dirname(__DIR__));
define('POSTFIX', microtime(true).rand());


/**
 * @return mysqli
 */
function getDatabase(): mysqli
{
    static $database;
    if (empty($database)) {
        $database = mysqli_connect('localhost', 'root', 'root','php_shop', '3366');
    }
    return $database;
}


/**
 * @param int $id
 * @return bool
 */
function hasProduct(int $id): bool
{
    $sql = "SELECT COUNT(*) as `count` FROM `goods` WHERE `id` = {$id}";
    $result = mysqli_query(getDatabase(), $sql);
    $row = mysqli_fetch_assoc($result);
    return (int)$row['count'] > 0;
}

/**
 * @param int $id
 * @return bool
 */
function hasOrder(int $id): bool
{
    $id_user = getUserID();
    $sql = "SELECT COUNT(*) as `count` FROM `orders` WHERE `id` = {$id} and `id_user` = {$id_user}";
    $result = mysqli_query(getDatabase(), $sql);
    $row = mysqli_fetch_assoc($result);
    return (int)$row['count'] > 0;
}

/**
 * @return bool
 */
function isAdmin(): bool
{
    return isset($_SESSION['login']) and $_SESSION['login'] and isset($_SESSION['admin']) and $_SESSION['admin'];
}

/**
 * @param string $location
 */
function changeLocation(string $location = ''): void
{
    if ($location != '') {
        header("location: {$location}");
    } elseif (isset($_SERVER['HTTP_REFERER'])) {
        header("location: {$_SERVER['HTTP_REFERER']}");
    } else {
        header("location: /");
    }
}


/**
 * @param string $filename
 * @return string
 */
function getPathController(string $filename): string
{
    return ROOT_DIR . "/controllers/{$filename}.php";
}

/**
 * @param string $template
 * @return string
 */
function getPathView(string $template): string
{
    return ROOT_DIR . "/views/{$template}";
}

/**
 * @param string $layout
 * @return string
 */
function getPathLayout(string $layout): string
{
    return "/layouts/{$layout}";
}

/**
 * @return int
 */
function getUserId(): int
{
    static $id;
    if (empty($_SESSION['user']) or empty($_SESSION['user']['email'])) {
        $id = -1;
    } elseif (empty($id)) {
        $sql = "SELECT `id` FROM `users` WHERE `email` = '{$_SESSION['user']['email']}'";
        $result = mysqli_query(getDatabase(), $sql);
        $row = mysqli_fetch_assoc($result);
        $id = (int)$row['id'];
    }
    return $id;
}

/**
 * @return int
 */
function getProductId(): int
{
    if (isset($_GET['id']) and is_numeric($_GET['id'])) {
        $id = (int)$_GET['id'];
        if (hasProduct($id)) return $id;
    }
    return 0;
}

/**
 * @return int
 */
function getOrderId(): int
{
    if (isset($_GET['id']) and is_numeric($_GET['id'])) {
        $id = (int)$_GET['id'];
        if (hasOrder($id)) return $id;
    }
    return -1;
}

/**
 * @param bool $admin
 * @return array
 */
function getMenu($admin = false): array
{
    $result[] = [
        'title' => 'Главная',
        'link' => '/?p=home',
    ];
    $result[] = [
        'title' => 'Товары',
        'link' => '/?p=goods',
    ];
    if (isset($_SESSION['login']) and $_SESSION['login']) {
        $result[] = [
            'title' => 'Заказы' . (countOrders() > 0 ? ' (' . countOrders() . ')' : ''),
            'link' => '/?p=orders',
        ];
    }
    $result[] = [
        'title' => 'Корзина' . (countCart() > 0 ? ' (' . countCart() . ')' : ''),
        'link' => '/?p=cart',
    ];
    if (isAdmin()) {
        $result[] = [
            'title' => 'Работа с <br> товарами',
            'link' => '/?p=goods&a=table',
        ];
        $result[] = [
            'title' => 'Работа с <br> заказами',
            'link' => '/?p=orders&a=table',
        ];
    }
    if (isset($_SESSION['login']) and $_SESSION['login']) {
        $result[] = [
            'title' => $_SESSION['user']['name'],
            'link' => '/?p=account',
        ];
    }
    $result[] = [
        'title' => (isset($_SESSION['login']) and $_SESSION['login']) ? 'Выйти' : 'Войти',
        'link' => (isset($_SESSION['login']) and $_SESSION['login']) ? '/?p=account&a=logout' : '/?p=account&a=login',
    ];
    return $result;
}


/**
 * @return int
 */
function countCart(): int
{
    if (!array_key_exists('cart', $_SESSION)) {
        return 0;
    }
    return count(array_keys($_SESSION['cart']));
}

/**
 * @return int
 */
function countOrders(): int
{
    $userID = getUserID();
    if ($userID < 0) {
        return 0;
    }
    $sql = "SELECT COUNT(*) as count FROM `orders`
            WHERE `id_user` = { $userID } and `status` not in ('Отменен', 'Выполнен')";
    if ($result = mysqli_query(getDatabase(), $sql)) {
        return mysqli_fetch_assoc($result)['count'];
    }
    return 0;
}


function run(): void
{
    $controller = ROOT_DIR . '/controllers/index.php';
    if (isset($_GET['p']) and is_file(getPathController($_GET['p']))) {
        $controller = getPathController($_GET['p']);
    }

    include_once $controller;

    $action = 'default_action';
    if (isset($_GET['a']) and function_exists($_GET['a'] . '_action')) {
        $action = $_GET['a'] . '_action';
    }
    $action();
}


/**
 * @param string $template
 * @param array $params
 * @return string
 */
function renderTemplate(string $template, array $params = []): string
{
    ob_start();
    extract($params);
    include_once getPathView($template);
    return ob_get_clean();
}

/**
 * @param string $template
 * @param array $params
 * @param string $layout
 * @return string
 */
function render(string $template, array $params = [], string $layout = 'main.php'): string
{
    $content = renderTemplate($template, $params);
    $title = 'Интернет-магазин';
    if (isset($params['title'])) {
        $title = $params['title'];
    }
    return renderTemplate(getPathLayout($layout), [
        'content' => $content,
        'title' => $title,
        'menu' => getMenu(isAdmin()),
    ]);
}
