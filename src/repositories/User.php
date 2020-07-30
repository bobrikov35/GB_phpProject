<?php

namespace app\repositories;

use app\entities\User as EUser;


/**
 * Class User
 * @package app\repositories
 */
class User extends Repository
{

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return EUser::class;
    }


    /**
     * @param string $email
     * @return mixed
     */
    public function getUser(string $email)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `email` = :email";
        return $this->getDatabase()->readObject($sql, $this->getEntityName(), [':email' => $email]);
    }

    /**
     * @param string $email
     * @return bool|mixed
     */
    public function getPassword(string $email)
    {
        $sql = "SELECT `password` FROM `{$this->getTableName()}` WHERE `email` = :email";
        $result = $this->getDatabase()->readItem($sql, [':email' => $email]);
        if (!$result) {
            return false;
        }
        return $result['password'];
    }

}
