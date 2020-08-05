<?php

namespace app\services;

use app\engine\App;
use app\entities\{Entity, User as EUser};


/**
 * Class User
 * @package app\services
 */
class User extends Service
{

    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает товар с данными из POST-запроса
     *
     * @return EUser
     */
    public function getUserFromPost()
    {
        $user = new EUser();
        $this->fillUserFromPost($user);
        return $user;
    }

    /**
     * Сохраняет пользователя в базе данных
     *
     * @return bool|int
     */
    public function save()
    {
        $user = $this->getUserFromPost();
        $userEmail = $this->getUserByEmail($user->getEmail());
        if (!empty($userEmail)) {
            return 0;
        }
        $user->setPassword($this->getPasswordHash($user->getPassword()));
        $user->setId((int)$this->saveUser($user));
        if (empty($user->getId())) {
            return 0;
        }
        $this->setSession('user', [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'admin' => $user->getAdmin(),
        ]);
        return $user->getId();
    }


    public function delete(int $id)
    {
        if (empty($id)) {
            return false;
        }
        if ($this->getUser($id)) {
            return $this->deleteUser($id);
        }
        return false;
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает хешированный пароль
     *
     * @param string $password
     * @return string
     */
    private function getPasswordHash(string $password): string
    {
        $password = App::call()->getSettings('passwordSol') . $password;
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Заполняет товар данными из post-запроса
     *
     * @param EUser $user
     */
    private function fillUserFromPost(EUser $user):void
    {
        $user->setName($this->getPost('name'));
        $user->setEmail($this->getPost('email'));
        $user->setPassword($this->getPost('password'));
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param string $name
     * @param mixed $value
     */
    private function setSession(string $name, $value)
    {
        $this->container->request->setSession($name, $value);
    }

    /**
     * @param int $id
     * @return EUser|Entity|null
     */
    private function getUser(int $id)
    {
        return $this->container->repositoryUser->getSingle($id);
    }

    /**
     * @param string $email
     * @return Entity|EUser|null
     */
    private function  getUserByEmail(string $email)
    {
        return $this->container->repositoryUser->getUser($email);
    }

    /**
     * @param EUser $user
     * @return bool|int
     */
    private function saveUser(EUser $user)
    {
        return $this->container->repositoryUser->save($user);
    }

    /**
     * @param int $id
     * @return bool
     */
    private function deleteUser(int $id)
    {
        return $this->container->repositoryUser->delete($id);
    }

}
