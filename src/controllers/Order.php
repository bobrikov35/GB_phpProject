<?php

namespace app\controllers;

use app\entities\Order as EOrder;


/**
 * Class Order
 * @package app\controllers
 */
class Order extends Controller
{

    /**
     * Д Е Й С Т В И Я
     */

    /**
     * Действие по умолчанию
     *
     * @return string
     */
    protected function default_action()
    {
        $config = $this->getListConfig('single');
        return $this->render('/index.twig', ['data' => var_dump($config)]);
//        $this->toLocation('/order/list/?page=1');
    }

    /**
     * Выводит список заказов
     *
     * @return string|void
     */
    protected function list_action()
    {
        if (!$this->permission('user')) {
            $this->toLocation('/user/login');
            return;
        }
        $config = $this->getListConfig('list');
        return $this->render('/order/index.twig', $config);
    }

    /**
     * Выводит одиночный заказ
     *
     * @return string|void
     */
    protected function single_action()
    {
        if (!$this->permission('user')) {
            $this->toLocation('/user/login');
            return;
        }
        $config = $this->getConfig();
        $config['order'] = $this->app->repositoryOrder->getSingle($this->getId());
        if (empty($config['order'])) {
            $this->toLocation('/order/list/?page=1');
            return;
        }
        if ($config['order']->getUserId() != $this->getUser('id') and !$this->permission('admin')) {
            $this->toLocation('/order/list/?page=1');
            return;
        }
        return $this->render('/order/single.twig',  $config);
    }

    protected function cancel_action(): void
    {
        if (!$this->permission('user')) {
            $this->toLocation('/user/login');
            return;
        }
        $config = $this->getConfig();
        $config['order'] = $this->app->repositoryOrder->getSingleWithoutGoods($this->getId());
        if (empty($config['order'])) {
            $this->toLocation('/order/list/?page=1');
            return;
        }
        $this->app->repositoryOrder->cancel($config['order']);
        $this->toLocation();
    }


    /**
     * П Р И В А Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * @param string $action
     * @return array
     */
    private function getListConfig(string $action): array
    {
        $config = $this->getConfig();
        $this->configurePaginator($this->app->repositoryOrder, "/product/{$action}/?page=", $this->getPage());
        $config['orders'] = $this->app->paginator->getItems();
        $config['count'] = count($config['orders']);
        $config['pages'] = [
            'links' => $this->app->paginator->getUrls(),
            'current' => $this->getPage(),
        ];
        $config['pages']['count'] = count($config['pages']['links']);
        return $config;
    }









    protected function make_action(): void
    {
        if (!$this->permission('user')) {
            $this->toLocation('/user/login');
            return;
        }
        $order = new EOrder();
        $order->setUserId($this->getUser('id'));
        $order->setStatus('Передан на обработку');
        if (empty($this->app->repositoryOrder->save($order))) {
            $this->toLocation('/product/list');
            return;
        }
        $this->toLocation('/order/list');
    }







//    function change_action(): void {
//        if (empty($_SESSION['login']) or !$_SESSION['login'] or empty($_SESSION['admin']) or !$_SESSION['admin']) {
//            changeLocation('/?p=goods');
//            return;
//        }
//        if (empty($_GET['id']) or !is_numeric($_GET['id']) or empty($_GET['status']) or $_GET['status'] == '') {
//            changeLocation();
//            return;
//        }
//        $id = (int)$_GET['id'];
//        $status = $_GET['status'];
//        if (!in_array($status, getStatuses())) {
//            changeLocation();
//            return;
//        }
//        $sql = "UPDATE `orders` SET `status` = '{$status}' WHERE `id` = {$id}";
//        $result = mysqli_query(getDatabase(), $sql);
//        changeLocation();
//    }

//    function table_action(): void {
//        if (empty($_SESSION['login']) or !$_SESSION['login'] or empty($_SESSION['admin']) or !$_SESSION['admin']) {
//            changeLocation('/?p=goods');
//            return;
//        }
//        $statuses = getStatuses();
//        $orders = getOrders(true);
//        echo render('orders/table.php', [
//            'title' => 'Товары',
//            'styles' => '<link rel="stylesheet" type="text/css" href="/css/orders.css?t=' . POSTFIX . '">',
//            'orders' => $orders,
//            'statuses' => $statuses,
//            'noOrders' => count($orders) == 0,
//        ]);
//    }





}
