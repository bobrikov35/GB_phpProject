<?php

function default_action(): void
{
    if (empty($_SESSION['login']) or !$_SESSION['login']) {
        changeLocation('/?p=account&a=login');
        return;
    }
    $admin = $_SESSION['admin'] ? 'присутствуют' : 'отсутствуют';
    echo render('account/index.php', [
        'title' => 'Личный кабинет',
        'styles' => '<link rel="stylesheet" type="text/css" href="/css/account.css?t=' . POSTFIX . '">',
        'admin' => $admin,
    ]);
}

function create_action(bool $admin = false): void
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo render('account/create.php', [
            'title' => 'Создание аккаунта',
            'styles' => '<link rel="stylesheet" type="text/css" href="/css/account.css?t=' . POSTFIX . '">',
        ]);
        return;
    }
    if (empty($_POST['name']) or empty($_POST['email']) or empty($_POST['password'])) {
        sessionLogout();
        changeLocation('/?p=account&a=create');
        return;
    }
    $admin = $admin ? 1 : 0;
    $password = password_hash(joinSol($_POST['password']), PASSWORD_DEFAULT );
    $sql = "INSERT INTO `users` (`name`, `email`, `password`, `admin`)
            VALUES ('{$_POST['name']}', '{$_POST['email']}', '{$password}', {$admin})";
    $result = mysqli_query(getDatabase(), $sql);
    if ($result) {
        sessionLogin($_POST['name'], $_POST['email']);
        changeLocation('/?p=account');
        return;
    }
    sessionLogout();
    changeLocation('/?p=account&a=create');
}

function login_action(): void
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo render('account/login.php', [
            'title' => 'Вход в аккаунт',
            'styles' => '<link rel="stylesheet" type="text/css" href="/css/account.css?t=' . POSTFIX . '">',
        ]);
        return;
    }
    if (empty($_POST['email']) or empty($_POST['password'])) {
        sessionLogout();
        changeLocation('/?p=account&a=login');
        return;
    }
    $result = verifyPassword($_POST['email'], $_POST['password']);
    if ($result) {
        sessionLogin($result['name'], $_POST['email'], $result['admin'] > 0);
        changeLocation('/?p=account');
        return;
    }
    changeLocation('/?p=account&a=login');
}

function logout_action(): void
{
    sessionLogout();
    changeLocation();
}
