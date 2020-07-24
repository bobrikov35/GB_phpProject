<?php

namespace app\models;


class User extends Model
{

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public bool $admin = false;


    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'users';
    }

}
