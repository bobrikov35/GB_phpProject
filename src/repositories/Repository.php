<?php

namespace app\repositories;

use \PDOStatement;
use app\engine\Container;
use app\services\DB;
use app\entities\Entity;


/**
 * Class Repository
 * @package app\repositories
 */
abstract class Repository
{

    /**
     * С В О Й С Т В А
     */

    protected Container $container;


    /**
     * А Б С Т Р А К Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Должно возвращать название таблицы
     *
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * Должно возвращать имя класса
     *
     * @return string
     */
    abstract protected function getEntityName(): string;


    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    protected function getDatabase(): DB
    {
        return $this->container->database;
    }

    protected function getPost(string $param)
    {
        return $this->container->request->getPost($param);
    }

    protected function getSession(string $param)
    {
        return $this->container->request->getSession($param);
    }

    protected function isAdmin(): bool
    {
        return $this->container->authorization->isAdmin();
    }

    protected function isLogin(): bool
    {
        return $this->container->authorization->isLogin();
    }

    protected function readItem(string $sql, array $params = []): array
    {
        return $this->container->database->readItem($sql, $params);
    }

    protected function readObject(string $sql, string $class, array $params = [])
    {
        return $this->container->database->readObject($sql, $class, $params);
    }

    protected function readTable(string $sql, array $params = []): array
    {
        return $this->container->database->readTable($sql, $params);
    }

    protected function readObjectList(string $sql, string $class, array $params = []): array
    {
        return $this->container->database->readObjectList($sql, $class, $params);
    }

    protected function execute(string $sql, array $params = [])
    {
        return $this->container->database->execute($sql, $params);
    }


    /**
     * S E T T E R ' Ы
     */

    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает количество записей в таблице
     *
     * @return int
     */
    public function getQuantityItems(): int
    {
        $sql = "SELECT COUNT(*) AS `count` FROM `{$this->getTableName()}`";
        if ($result = $this->readItem($sql)) {
            return (int)$result['count'];
        }
        return 0;
    }

    /**
     * Возвращает список объектов на текущей странице
     *
     * @param int $page
     * @param int $quantity
     * @return Entity[]|array
     */
    public function getItemsByPage(int $page = 1, int $quantity = 9): array
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($quantity < 9) {
            $quantity = 9;
        }
        $start = ($page - 1) * $quantity;
        $sql = "SELECT * FROM `{$this->getTableName()}` LIMIT {$start}, {$quantity}";
        return $this->readObjectList($sql, $this->getEntityName());
    }

    /**
     * Возвращает объект из базы данных по id
     *
     * @param int $id
     * @return Entity|null
     */
    public function getSingle(int $id)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `id` = :id";
        return $this->getDatabase()->readObject($sql, $this->getEntityName(), [':id' => $id]);
    }

    /**
     * Возвращает полный список объектов из базы данных
     *
     * @return array
     */
    public function getList(): array
    {
        $sql = "SELECT * FROM `{$this->getTableName()}`";
        return $this->readObjectList($sql, $this->getEntityName());
    }

    /**
     * Сохраняет объект в базе данных
     *
     * @param Entity $entity
     * @return bool|int
     */
    public function save(Entity $entity)
    {
        if (empty($entity->getId())) {
            return $this->insert($entity);
        }
        return $this->update($entity);
    }

    /**
     * Удаляет объект из базы данных
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM `{$this->getTableName()}` WHERE `id` = :id";
        if ($this->execute($sql, [':id' => $id])) {
            return true;
        }
        return false;
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает спискок параметров для запросов на создание и изменение
     *
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
     * Возвращает подготовленный набор column=key для запросов на изменение
     *
     * @param array $columns
     * @param array $keys
     * @return array
     */
    private function getSetForUpdate(array $columns, array $keys): array
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
     * Вставляет объект в базу данных
     *
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
            implode(', ', $params['keys'])
        );
        if ($this->execute($sql, $params['values'])) {
            return $this->getDatabase()->getInsertedId();
        }
        return 0;
    }

    /**
     * Изменяет объект в базе данных
     *
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
        if ($this->execute($sql, $params['values'])) {
            return true;
        }
        return false;
    }

}
