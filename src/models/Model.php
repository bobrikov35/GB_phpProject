<?php

namespace app\models;

use \PDOStatement;
use app\services\DB;


abstract class Model
{

    protected int $id = 0;


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


    /**
     * @return int
     */
    public function getQuantityItems(): int
    {
        $sql = 'SELECT COUNT(*) AS `count` FROM `' . static::getTableName() . '`';
        return (int)static::getDatabase()->readItem($sql)['count'];
    }

    /**
     * @param int $page
     * @param int $quantity
     * @return array
     */
    public function getItemsOnPage(int $page = 1, int $quantity = 12): array
    {
        $start = ($page - 1) * $quantity;
        $sql = "SELECT * FROM `" . static::getTableName() . "` LIMIT {$start}, {$quantity}";
        return static::getDatabase()->readObjectList($sql, static::class);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function getSingle(int $id)
    {
        $sql = "SELECT * FROM `" . static::getTableName() . "` WHERE `id` = :id";
        return static::getDatabase()->readObject($sql, static::class, [':id' => $id]);
    }

    /**
     * @return array
     */
    public static function getList(): array
    {
        $sql = "SELECT * FROM `" . static::getTableName() . "`";
        return static::getDatabase()->readObjectList($sql, static::class);
    }

    /**
     * @return array
     */
    private function getParams(): array
    {
        $params = [
            'keys' => [],
            'values' => [],
            'columns' => [],
        ];
        foreach ($this as $key => $value) {
            if ($key == 'id' or empty($value)) {
                continue;
            }
            $params['columns'][] = $key;
            $params['keys'][] = ":{$key}";
            $params['values'][":{$key}"] = $value;
        }
        return $params;
    }

    /**
     * @return int
     */
    protected function insert(): int
    {
        $params = $this->getParams();
        $sql = sprintf(
            'INSERT INTO `%s` (`%s`) VALUES (%s)',
            static::getTableName(),
            implode('`, `', $params['columns']),
            implode(',', $params['keys'])
        );
        if (!static::getDatabase()->execute($sql, $params['values'])) {
            return 0;
        }
        $this->id = static::getDatabase()->getInsertedId();
        return $this->id;
    }

    /**
     * @param array $columns
     * @param array $keys
     * @return array
     */
    private function getSetForUpdate(array $columns, array $keys): array
    {
        $columnKey = [];
        if (count($columns) != count($columns)) {
            return $columnKey;
        }
        for ($i = 0; $i < count($columns); $i++) {
            $columnKey[] = "`{$columns[$i]}` = {$keys[$i]}";
        }
        return $columnKey;
    }

    /**
     * @return bool
     */
    protected function update(): bool
    {
        $params = $this->getParams();
        $sql = sprintf(
            'UPDATE `%s` SET %s WHERE `id` = :id',
            static::getTableName(),
            implode(',', $this->getSetForUpdate($params['columns'], $params['keys']))
        );
        $params['values']['id'] = $this->getId();
        if (!static::getDatabase()->execute($sql, $params['values'])) {
            return false;
        }
        return true;
    }

    /**
     * @return bool|int
     */
    public function save()
    {
        if (empty($this->id)) {
            return $this->insert();
        }
        return $this->update();
    }

    /**
     * @return bool|PDOStatement
     */
    public function delete()
    {
        $sql = 'DELETE FROM `' . $this->getTableName() . '` WHERE `id` = :id';
        if (!static::getDatabase()->execute($sql, [':id' => $this->id])) {
            return false;
        }
        return true;
    }

}
