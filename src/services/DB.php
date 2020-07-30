<?php

namespace app\services;

use \PDO, \PDOStatement;


/**
 * Class DB
 * @package app\services
 */
class DB extends Service
{

    private PDO $connect;


    /**
     * DB constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->makeConnect();
    }

    private function makeConnect(): void
    {
        $this->connect = new PDO(
            $this->getPrepareDsn(),
            $this->config['user'],
            $this->config['password']
        );
        $this->connect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
    }

    /**
     * @return string
     */
    private function getPrepareDsn(): string
    {
        return sprintf(
            "%s:host=%s;dbname=%s;charset=%s;port=%d",
            $this->config['driver'],
            $this->config['host'],
            $this->config['dbname'],
            $this->config['charset'],
            $this->config['port'],
        );
    }


    /**
     * @return int
     */
    public function getInsertedId(): int
    {
        return (int)$this->connect->lastInsertId();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool|PDOStatement
     */
    private function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->connect->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function readItem(string $sql, array $params = []): array
    {
        $result = $this->query($sql, $params)->fetch();
        if ($result) {
            return $result;
        }
        return [];
    }

    /**
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return mixed
     */
    public function readObject(string $sql, string $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetch();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function readTable(string $sql, array $params = []): array
    {
        $result = $this->query($sql, $params)->fetchAll();
        if ($result) {
            return $result;
        }
        return [];
    }

    /**
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return array
     */
    public function readObjectList(string $sql, string $class, array $params = []): array
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
        $result = $PDOStatement->fetchAll();
        if ($result) {
            return $result;
        }
        return [];
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool|PDOStatement
     */
    public function execute(string $sql, array $params = [])
    {
        return $this->query($sql, $params);
    }

}
