<?php

namespace app\services;

use app\engine\App;
use app\entities\User as EUser;


/**
 * Class Authorization
 * @package app\services
 */
class Authorization extends Service
{

    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param string $key
     * @return mixed|null
     */
    private function getSettings(string $key)
    {
        return App::call()->getSettings($key);
    }

    /**
     * @param string $email
     * @return string|bool
     */
    private function getPassword(string $email)
    {
        return $this->container->repositoryUser->getPassword($email);
    }

    /**
     * @param string $email
     * @return EUser|bool
     */
    private function getUser(string $email)
    {
        return $this->container->repositoryUser->getUser($email);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    private function setSession(string $name, $value)
    {
        $this->request->setSession($name, $value);
    }

    /**
     * @param string $param
     * @return mixed
     */
    private function getSession(string $param)
    {
        return $this->request->getSession($param);
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Проверка на вход в аккаунт
     *
     * @return bool
     */
    public function isLogin(): bool
    {
        $user = $this->getSession('user');
        return empty($user);
    }

    /**
     * Проверка на наличие прав администратора
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        $user = $this->getSession('user');
        return !empty($user) and $user['admin'];
    }

    /**
     * Вход в аккаунт
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        if (!$this->verifyPassword($email, $password)) {
            $this->logout();
            return false;
        }
        $user = $this->getUser($email);
        if (!$user) {
            $this->logout();
            return false;
        }
        $this->setSession('login', true);
        $this->setSession('user', [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'admin' => $user->getAdmin(),
        ]);
        return true;
    }

    /**
     * Выход из аккаунта
     */
    public function logout(): void
    {
        $this->setSession('user', []);
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает пароль с солью
     *
     * @param string $password
     * @return string
     */
    private function getPasswordWithSol(string $password): string
    {
        return $this->getSettings('passwordSol') . $password;
    }

    /**
     * Проверка пароля
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    private function verifyPassword(string $email, string $password): bool
    {
        if (empty($email)) {
            return false;
        }
        $hashPassword = $this->getPassword($email);
        if (empty($hashPassword)) {
            return false;
        }
        return password_verify($this->getPasswordWithSol($password), $hashPassword);
    }

}