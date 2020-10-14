<?php

namespace app\repositories;

use app\entities\{Entity, Order as EOrder};


/**
 * Class Order
 * @package app\repositories
 */
class Order extends Repository
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
        return 'orders';
    }

    /**
     * Возвращает имя класса
     *
     * @return string
     */
    protected function getEntityName(): string
    {
        return EOrder::class;
    }


    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Возвращает количество заказов пользователя
     *
     * @param int $id_user
     * @param array $exception
     * @return int
     */
    public function getQuantity(int $id_user, array $exception = []): int
    {
        if ($id_user < 0) {
            return 0;
        }
        $exception = empty($exception) ? '' : "and `status` not in ('" . implode("', '", $exception) . "')";
        $sql = "SELECT COUNT(*) as `count` FROM `{$this->getTableName()}` WHERE `id_user` = :id_user {$exception}";
        $result = $this->readItem($sql, [':id_user' => $id_user]);
        if ($result) {
            return (int)$result['count'];
        }
        return 0;
    }

    /**
     * Возвращает список возможных статусов
     *
     * @return array
     */
    public function getStatuses(): array
    {
        $sql = "SHOW COLUMNS FROM `{$this->getTableName()}` LIKE 'status'";
        $statuses = $this->readItem($sql)['Type'];
        if (empty($statuses)) {
            return [];
        }
        $statuses = explode('\'', $statuses);
        unset($statuses[0]);
        unset($statuses[count($statuses)]);
        $statuses = array_unique($statuses);
        unset($statuses[array_search(',', $statuses)]);
        return $statuses;
    }

    /**
     * Возвращает количество записей в таблице для текущего пользователя
     *
     * @return int
     */
    public function getQuantityItems(): int
    {
        $user = $this->getUser();
        return $this->getQuantity($user['id']);
    }

    /**
     * Возвращает список объектов на текущей странице для текущего пользователя
     *
     * @param int $page
     * @param int $quantity
     * @param bool $all
     * @return array
     */
    public function getItemsByPage(int $page = 1, int $quantity = 9, bool $all = false): array
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($quantity < 9) {
            $quantity = 9;
        }
        $start = ($page - 1) * $quantity;
        $where = !$all ? 'WHERE `id_user` = :id' : '';
        $sql = "SELECT `{$this->getTableName()}`.`id` as `id`, `{$this->getTableName()}`.`status` as `status`,
                 COUNT(*) as `count`, SUM(`order_product`.`quantity`) as `quantity`,
                 SUM(`order_product`.`price`) as `cost`
            FROM `{$this->getTableName()}`
            LEFT JOIN `order_product` ON `{$this->getTableName()}`.`id` = `order_product`.`id_order`
            {$where}
            GROUP BY `{$this->getTableName()}`.`id`
            ORDER BY `{$this->getTableName()}`.`id` DESC LIMIT {$start}, {$quantity}";
        $user = $this->getUser();
        return $this->readObjectList($sql, $this->getEntityName(), [':id' => $user['id']]);
    }

    /**
     * Получает все товары в заказе
     *
     * @param EOrder|Entity $order
     */
    public function fetchGoods(EOrder $order): void
    {
        $sql = "SELECT `goods`.`id` as `id`, `goods`.`title` as `title`, `order_product`.`quantity` as `quantity`,
                `goods`.`image` as `image`, `order_product`.price as `price`
            FROM `{$this->getTableName()}`
            LEFT JOIN `order_product` ON `{$this->getTableName()}`.`id` = `order_product`.`id_order`
            LEFT JOIN `goods` ON `order_product`.`id_product` = `goods`.`id`
            WHERE `{$this->getTableName()}`.`id` = :id";
        $goods = $this->readTable($sql, [':id' => $order->getId()]);
        $order->setGoods($goods);
    }

    /**
     * Возвращает заказ из базы данных по id
     *
     * @param int $id
     * @return EOrder|Entity|null
     */
    public function getSingle(int $id)
    {
        $sql = "SELECT `id`, `status`, `id_user` as `userId` FROM `{$this->getTableName()}` WHERE `id` = :id";
        $order = $this->readObject($sql, $this->getEntityName(), [':id' => $id]);
        if (!empty($order)) {
            $this->fetchGoods($order);
        }
        return $order;
    }

    /**
     * Возвращает заказ из базы данных по id
     *
     * @param int $id
     * @return EOrder|Entity|null
     */
    public function getSingleWithoutGoods(int $id)
    {
        $sql = "SELECT `id`, `status`, `id_user` as `userId` FROM `{$this->getTableName()}` WHERE `id` = :id";
        return $this->readObject($sql, $this->getEntityName(), [':id' => $id]);
    }

    /**
     * Возвращает полный список заказов из базы данных для текущего пользователя
     *
     * @return array
     */
    public function getList(): array
    {
        $sql = "SELECT `{$this->getTableName()}`.`id` as `id`, `{$this->getTableName()}`.`status` as `status`,
                 COUNT(*) as `count`, SUM(`order_product`.`quantity`) as `quantity`,
                 SUM(`order_product`.`price`) as `cost`
            FROM `{$this->getTableName()}`
            LEFT JOIN `order_product` ON `{$this->getTableName()}`.`id` = `order_product`.`id_order`
            WHERE `id_user` = :id
            GROUP BY `{$this->getTableName()}`.`id`
            ORDER BY `{$this->getTableName()}`.`id` DESC";
        $user = $this->getUser();
        return $this->readObjectList($sql, $this->getEntityName(), [':id' => $user['id']]);
    }

    /**
     * Отменяет заказ
     *
     * @param EOrder $order
     * @return bool
     */
    public function cancel(EOrder $order): bool
    {
        return $this->update($order, 'Отменен');
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Создает заказ в базе данных
     *
     * @param EOrder|Entity $order
     * @return int
     */
    protected function insert(Entity $order): int
    {
        if (empty($cart = $this->getCart())) {
            return 0;
        }
        $sql = "INSERT INTO `{$this->getTableName()}` (`id_user`, `status`) VALUES (:id_user, :status)";
        $result = $this->execute($sql, [
            ':id_user' => $order->getUserId(),
            ':status' => $order->getStatus(),
        ]);
        if (empty($result) or empty($id = $this->getInsertedId())) {
            return 0;
        }
        foreach ($cart as $id_product => $product) {
            $sql = "INSERT INTO `order_product` (`id_order`, `id_product`, `quantity`, `price`)
                    VALUES (:id_order, :id_product, :quantity, :price)";
            $this->execute($sql, [
                ':id_order' => $id,
                ':id_product' => $id_product,
                ':quantity' => $product['quantity'],
                ':price' => $product['price'],
            ]);
        }
        return $id;
    }

    /**
     * Изменяет состояние заказа в базе данных
     *
     * @param EOrder|Entity $order
     * @param string $status
     * @return bool
     */
    protected function update(Entity $order, string $status = ''): bool
    {
        $newStatus = $status == '' ? $this->getPost('status') : $status;
        if (empty($newStatus) or $order->getStatus() == $newStatus or !in_array($newStatus, $this->getStatuses())) {
            return false;
        }
        $sql = "UPDATE `{$this->getTableName()}` SET `status` = :status WHERE `id` = :id";
        $result = $this->execute($sql, [
            ':id' => $order->getId(),
            ':status' => $newStatus,
        ]);
        return !empty($result);
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @return array|mixed|null
     */
    private function getUser()
    {
        return $this->getSession('user');
    }

    /**
     * @return array
     */
    private function getCart(): array
    {
        return $this->container->serviceCart->getList();
    }

    /**
     * @return int
     */
    private function getInsertedId(): int
    {
        return $this->getDatabase()->getInsertedId();
    }

}
