<?php

namespace app\services;

use \PDO, \PDOStatement;
use app\entities\Entity;


/**
 * Class DB
 * @package app\services
 */
class DB extends Service
{

    /**
     * С В О Й С Т В А
     */

    private PDO $connect;


    /**
     * М А Г И Ч Е С К И Е   Ф У Н К Ц И И
     */

    /**
     * DB constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->makeConnect();
    }

    /**
     * Соединение с базой данных
     */
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
     * Возвращает DSN-строку для PDO
     *
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
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает последний добавленный id в базу данных
     *
     * @return int
     */
    public function getInsertedId(): int
    {
        return (int)$this->connect->lastInsertId();
    }

    /**
     * Возвращает первую строку результата выполнения запроса
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function readItem(string $sql, array $params = []): array
    {
        if ($result = $this->query($sql, $params)->fetch()) {
            return $result;
        }
        return [];
    }

    /**
     * Возвращает первую строку результата выполнения запроса в объект
     *
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return Entity|null
     */
    public function readObject(string $sql, string $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
        if ($result = $PDOStatement->fetch()) {
            return $result;
        }
        return null;
    }

    /**
     * Возвращает все строки результата выполнения запроса
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function readTable(string $sql, array $params = []): array
    {
        if ($result = $this->query($sql, $params)->fetchAll()) {
            return $result;
        }
        return [];
    }

    /**
     * Возвращает все строки результата выполнения запроса в виде списка объектов
     *
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return Entity[]|array
     */
    public function readObjectList(string $sql, string $class, array $params = []): array
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
        if ($result = $PDOStatement->fetchAll()) {
            return $result;
        }
        return [];
    }

    /**
     * Выполняет запрос
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement|bool
     */
    public function execute(string $sql, array $params = [])
    {
        if ($this->query($sql, $params)) {
            return true;
        };
        return false;
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает результат выполнения запроса
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement|bool
     */
    private function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->connect->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

}
