<?php

namespace app\repositories;

use app\entities\User as EUser;


class User extends Repository
{

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return EUser::class;
    }

}
