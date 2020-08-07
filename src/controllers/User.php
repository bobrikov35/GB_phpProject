<?php

namespace app\controllers;

use app\entities\User as EUser;


/**
 * Class User
 * @package app\controllers
 */
class User extends Controller
{

    /**
     * Д Е Й С Т В И Я
     */

    /**
     * Действие по умолчанию
     */
    protected function default_action()
    {
        if ($this->isLogin()) {
            $this->toLocation('/user/account/');
            return;
        }
        $this->toLocation('/user/login/');
    }

    /**
     * Выводит личный кабинет пользователя
     *
     * @return string|void
     */
    protected function account_action()
    {
        if (!$this->isLogin()) {
            $this->toLocation('/user/login/');
            return;
        }
        $config = $this->getConfig();
        $config['user'] = $this->getUser();
        $config['admin'] = $this->getUser('admin') ? 'присутствуют' : 'отсутствуют';
        return $this->render('account/index.twig', $config);
    }

    /**
     * Возвращает форму входа в личный кабинет или выполняет вход
     *
     * @return string|void
     */
    protected function login_action()
    {
        if ($this->isLogin()) {
            $this->toLocation('/user/account/');
            return;
        }
        $config = $this->getConfig();
        if (empty($this->getPost())) {
            $config['user'] = new EUser();
            return $this->render('account/login.twig', $config);
        }
        $config['user'] = $this->getUserFromPost();
        if (empty($config['user']->getEmail()) or empty($config['user']->getPassword())) {
            return $this->render('account/login.twig', $config);
        }
        if ($this->login($config['user'])) {
            $this->toLocation('/user/account');
            return;
        }
        return $this->render('/account/login.twig', $config);
    }

    /**
     * Выполняет выход из личного кабинета
     */
    protected function logout_action()
    {
        $this->logout();
        $this->toLocation();
    }

    /**
     * Возвращает форму для создания аккаунта или создает его
     *
     * @return string|void
     */
    protected function create_action()
    {
        $config = $this->getConfig();
        if (empty($this->getPost())) {
            $config['user'] = new EUser();
            return $this->render('account/create.twig', $config);
        }
        if ($this->checkRequiredParams() and $this->saveUser()) {
            $this->toLocation('/user/account');
            return;
        }
        $config['user'] = $this->getUserFromPost();
        return $this->render('account/create.twig', $config);
    }

    /**
     * Удаляет аккаунт
     */
    protected function delete_action()
    {
        if (!$this->isLogin()) {
            $this->toLocation('/user/login');
            return;
        }
        if ($this->deleteUser()) {
            $this->logout();
            $this->toLocation('/user/login');
            return;
        }
        $this->toLocation('/user/account');
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Проверка заполненности обязательных параметров
     *
     * @return bool
     */
    private function checkRequiredParams(): bool
    {
        return !empty($this->getPost('name')) and !empty($this->getPost('email'))
            and !empty($this->getPost('password'));
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param EUser $user
     * @return bool
     */
    private function login(EUser $user): bool
    {
        return $this->app->authorization->login($user->getEmail(), $user->getPassword());
    }

    private function logout()
    {
        $this->app->authorization->logout();
    }

    /**
     * @return EUser
     */
    private function getUserFromPost()
    {
        return $this->app->serviceUser->getUserFromPost();
    }

    /**
     * @return bool|int
     */
    private function saveUser()
    {
        return $this->app->serviceUser->save();
    }

    /**
     * @return bool
     */
    private function deleteUser(): bool
    {
        return $this->app->serviceUser->delete($this->getUser('id'));
    }



    /**
     * Помощник ide (не вызывать)
     */
    protected function __ideHelper()
    {
        /** Функции вызываются динамически (см. class Controller) */
        $this->default_action();
        $this->account_action();
        $this->login_action();
        $this->logout_action();
        $this->create_action();
        $this->delete_action();
    }

}
