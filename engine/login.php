<?php

/**
 * @param string $password
 * @return string
 */
function joinSol(string $password): string
{
    return "FR4jO8mH4yAe{$password}";
}


/**
 * @param string $login
 * @param string $password
 * @return bool|string[]|null
 */
function verifyPassword(string $login, string $password)
{
    if ($login == '' || $password == '') {
        return false;
    }
    $sql = <<<QUERY
        SELECT `id`, `name`, `email`, `password`, `admin` FROM `users`
        WHERE `email` = '{$login}'
QUERY;
    $result = mysqli_query(getDatabase(), $sql);
    if (!$result) {
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    if (!password_verify(joinSol($password), $row['password'])) {
        return false;
    }
    return $row;
}


/**
 * @return bool
 */
function login(): bool
{
    if (!$_SESSION['login'] or empty($_SESSION['user'])) {
        sessionLogout();
        return false;
    }
    if (empty($_SESSION['user']['name']) or empty($_SESSION['user']['email'])) {
        sessionLogout();
        return false;
    }
    return true;
}

/**
 * @param string $name
 * @param string $email
 * @param bool $admin
 */
function sessionLogin(string $name, string $email, bool $admin = false): void
{
    $_SESSION['login'] = true;
    $_SESSION['admin'] = $admin;
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
}

function sessionLogout(): void
{
    $_SESSION['login'] = false;
    $_SESSION['admin'] = false;
    unset($_SESSION['user']);
}
