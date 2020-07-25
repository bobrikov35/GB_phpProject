<?php

namespace app\repositories;

use app\entities\Entity;
use app\services\DB;


abstract class Repository
{

    /**
     * @return string
     */
    abstract public function getTableName(): string;

    /**
     * @return string
     */
    abstract public function getEntityName(): string;

    /**
     * @return DB
     */
    protected function getDatabase(): DB
    {
        return DB::getInstance();
    }


    /**
     * @return int
     */
    public function getQuantityItems(): int
    {
        $sql = "SELECT COUNT(*) AS `count` FROM `{$this->getTableName()}`";
        return (int)$this->getDatabase()->readItem($sql)['count'];
    }

    /**
     * @param int $page
     * @param int $quantity
     * @return array
     */
    public function getItemsByPage(int $page = 1, int $quantity = 12): array
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($quantity < 9) {
            $quantity = 9;
        }
        $start = ($page - 1) * $quantity;
        $sql = "SELECT * FROM `{$this->getTableName()}` LIMIT { $start }, { $quantity }";
        return $this->getDatabase()->readObjectList($sql, $this->getEntityName());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getSingle(int $id)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `id` = :id";
        return $this->getDatabase()->readObject($sql, $this->getEntityName(), [':id' => $id]);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $sql = "SELECT * FROM `{$this->getTableName()}`";
        return $this->getDatabase()->readObjectList($sql, $this->getEntityName());
    }


    /**
     * @param array $vars
     * @return array
     */
    protected function getParams(array $vars): array
    {
        $params = [
            'keys' => [],
            'values' => [],
            'columns' => [],
        ];
        foreach ($vars as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $params['columns'][] = $key;
            $params['keys'][] = ":{$key}";
            $params['values'][":{$key}"] = $value;
        }
        return $params;
    }

    /**
     * @param Entity $entity
     * @return int
     */
    protected function insert(Entity $entity): int
    {
        $params = $this->getParams($entity->getVars());
        $sql = sprintf(
            "INSERT INTO `%s` (`%s`) VALUES (%s)",
            $this->getTableName(),
            implode('`, `', $params['columns']),
            implode(',', $params['keys'])
        );
        if (!$this->getDatabase()->execute($sql, $params['values'])) {
            return 0;
        }
        return $this->getDatabase()->getInsertedId();
    }

    /**
     * @param array $columns
     * @param array $keys
     * @return array
     */
    protected function getSetForUpdate(array $columns, array $keys): array
    {
        $set = [];
        if (count($columns) != count($keys)) {
            return $set;
        }
        for ($i = 0; $i < count($columns); $i++) {
            $set[] = "`{$columns[$i]}` = {$keys[$i]}";
        }
        return $set;
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    protected function update(Entity $entity): bool
    {
        $params = $this->getParams($entity->getVars());
        $sql = sprintf(
            "UPDATE `%s` SET %s WHERE `id` = :id",
            $this->getTableName(),
            implode(', ', $this->getSetForUpdate($params['columns'], $params['keys']))
        );
        $params['values']['id'] = $entity->getId();
        if (!$this->getDatabase()->execute($sql, $params['values'])) {
            return false;
        }
        return true;
    }

    /**
     * @param Entity $entity
     * @return bool|int
     */
    public function save(Entity $entity)
    {
        if (!empty($entity->getId())) {
            return $this->update($entity);
        }
        return $this->insert($entity);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $sql = "DELETE FROM `{$this->getTableName()}` WHERE `id` = :id";
        if (!$this->getDatabase()->execute($sql, [':id' => $id])) {
            return false;
        }
        return true;
    }

}
