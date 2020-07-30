<?php

namespace app\services;

use app\engine\App;


/**
 * Class Authorization
 * @package app\services
 */
class Authorization extends Service
{

    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        $login = $this->request->getSession('login');
        if (empty($login)) {
            return false;
        }
        return $login;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        $user = $this->request->getSession('user');
        if (empty($user)) {
            return false;
        }
        return $user['admin'];
    }


    /**
     * @param string $password
     * @return string
     */
    private function joinSol(string $password): string
    {
        return App::call()->getSettings('passwordSol') . $password;
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    private function verifyPassword(string $email, string $password): bool
    {
        if ($email == '' or $password == '') {
            return false;
        }
        $hashPassword = $this->container->repositoryUser->getPassword($email);
        if (empty($hashPassword) and $hashPassword !== '') {
            return false;
        }
        if (password_verify($this->joinSol($password), $hashPassword)) {
            return true;
        }
        return false;
    }


    /**
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
        $user = $this->container->repositoryUser->getUser($email);
        if (!$user) {
            $this->logout();
            return false;
        }
        $this->request->setSession('login', true);
        $this->request->setSession('user',
            [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'admin' => $user->getAdmin(),
            ]
        );
        return true;
    }

    public function logout(): void
    {
        $this->request->setSession('user', []);
        $this->request->setSession('login', false);
    }

}
