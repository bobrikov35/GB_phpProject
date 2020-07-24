<?php

namespace app\models;

use \PDOStatement;
use app\services\DB;


abstract class Model
{

    protected int $id;


    /**
     * @return string
     */
    abstract public static function getTableName(): string;


    /**
     * @return DB
     */
    protected static function getDatabase(): DB
    {
        return DB::getInstance();
    }


    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
