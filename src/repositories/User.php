<?php

namespace app\repositories;

use app\entities\{Entity, User as EUser};


/**
 * Class User
 * @package app\repositories
 */
class User extends Repository
{

    /**
     * О Б Я З А Т Е Л Ь Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает название таблицы
     *
     * @return string
     */
    protected function getTableName(): string
    {
        return 'users';
    }

    /**
     * Возвращает имя класса
     *
     * @return string
     */
    protected function getEntityName(): string
    {
        return EUser::class;
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает пользователя
     *
     * @param string $email
     * @return Entity|EUser|null
     */
    public function getUser(string $email)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `email` = :email";
        return $this->readObject($sql, $this->getEntityName(), [':email' => $email]);
    }

    /**
     * Возвращает пароль пользователя
     *
     * @param string $email
     * @return string|bool
     */
    public function getPassword(string $email)
    {
        $sql = "SELECT `password` FROM `{$this->getTableName()}` WHERE `email` = :email";
        if ($result = $this->readItem($sql, [':email' => $email])) {
            return $result['password'];
        }
        return false;
    }

}
