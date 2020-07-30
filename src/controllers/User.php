<?php

namespace app\controllers;

use app\entities\User as EUser;


/**
 * Class User
 * @package app\controllers
 */
class User extends Controller
{

    protected function default_action()
    {
        if ($this->app->authorization->isLogin()) {
            $this->request->toLocation('/user/account/');
            return;
        }
        $this->request->toLocation('/user/login/');
    }

    /**
     * @return bool
     */
    protected function checkRequiredParams(): bool
    {
        return !empty($this->request->getPost('name'))
            and !empty($this->request->getPost('email'));
    }

    /**
     * @return mixed|void
     */
    protected function account_action()
    {
        if (!$this->app->authorization->isLogin()) {
            $this->request->toLocation('/user/login/');
            return;
        }
        $config = $this->getConfig();
        $config['user'] = $this->request->getSession('user');
        $config['admin'] = $config['user']['admin'] ? 'присутствуют' : 'отсутствуют';
        return $this->render('account/index.twig', $config);
    }

    /**
     * @return mixed|void
     */
    protected function login_action()
    {
        $config = $this->getConfig();
        if ($this->app->authorization->isLogin()) {
            $this->request->toLocation('/user/account/');
            return;
        }
        $config['user'] = new EUser();
        if (empty($this->request->getPost())) {
            return $this->render('account/login.twig', $config);
        }
        $config['user']->setEmail($this->request->getPost('email'));
        $config['user']->setPassword($this->request->getPost('password'));
        if (empty($config['user']->getEmail()) or empty($config['user']->getPassword())) {
            return $this->render('account/login.twig', $config);
        }
        if (!$this->app->authorization->login($config['user']->getEmail(), $config['user']->getPassword())) {
            return $this->render('account/login.twig', $config);
        }
        $this->toLocation('/user/login');
    }

    protected function logout_action()
    {
        $this->app->authorization->logout();
        $this->toLocation();
    }

//    protected function create_action()
//    {
//        if (empty($this->request->getPost())) {
//            $config['product'] = new EProduct();
//            return $this->render('product/edit.twig', $config);
//        }
//        if ($this->checkRequiredParams() and $this->app->serviceProduct->save($this->getId())) {
//            $this->toLocation('/product/table');
//            return;
//        }
//        $config['product'] = new EProduct();
//        $this->app->serviceProduct->fillProductFromPost($config['product']);
//        return $this->render('product/edit.twig', $config);
//    }

//    function create_action(bool $admin = false): void
//    {
//        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
//            echo render('account/create.twig', [
//                'title' => 'Создание аккаунта',
//                'styles' => '<link rel="stylesheet" type="text/css" href="/css/account.css?t=' . POSTFIX . '">',
//            ]);
//            return;
//        }
//        if (empty($_POST['name']) or empty($_POST['email']) or empty($_POST['password'])) {
//            sessionLogout();
//            changeLocation('/?p=account&a=create');
//            return;
//        }
//        $admin = $admin ? 1 : 0;
//        $password = password_hash(joinSol($_POST['password']), PASSWORD_DEFAULT );
//        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `admin`)
//            VALUES ('{$_POST['name']}', '{$_POST['email']}', '{$password}', {$admin})";
//        $result = mysqli_query(getDatabase(), $sql);
//        if ($result) {
//            sessionLogin($_POST['name'], $_POST['email']);
//            changeLocation('/?p=account');
//            return;
//        }
//        sessionLogout();
//        changeLocation('/?p=account&a=create');
//    }

}
