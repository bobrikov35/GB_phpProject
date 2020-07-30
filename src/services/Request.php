<?php

namespace app\services;

use app\engine\Container;


/**
 * Class Request
 * @package app\services
 */
class Request extends Service
{

    private string $URI;
    private array $params;
    private string $controller = '';
    private string $action = '';
    private int $id = 0;
    private int $page = 1;


    /**
     * DB constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        session_start();
        parent::__construct($config);
        $this->URI = $_SERVER['REQUEST_URI'];
        $this->params = [
            'get' => !empty($_GET) ? $_GET : [],
            'post' => !empty($_POST) ? $_POST : [],
            'session' => !empty($_SESSION) ? $_SESSION : [],
        ];
        $this->prepareRequest();
    }

    private function prepareRequest(): void
    {
        $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";
        if (preg_match_all($pattern, $this->URI, $matches)) {
            $this->controller = ucfirst(strtolower($matches['controller'][0]));
            $this->action = strtolower($matches['action'][0]);
        }
        if (is_numeric($this->getParams('get', 'id'))) {
            $this->id = (int)$this->getParams('get', 'id');
        }
        if (is_numeric($this->getParams('get', 'page'))) {
            $this->page = (int)$this->getParams('get', 'page');
        }
    }


    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setSession(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }


    /**
     * @return string
     */
    public function getController(): string
    {
        return "app\\controllers\\{$this->controller}";
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
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
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param string $list ["get', 'post', 'session']
     * @param string $param
     * @return array|string
     */
    public function getParams(string $list, string $param)
    {
        if (empty($param)) {
            return $this->params[$list];
        }
        if (empty($this->params[$list][$param])) {
            return '';
        }
        return $this->params[$list][$param];
    }

    /**
     * @param string $param
     * @return mixed
     */
    public function getPost(string $param = '')
    {
        return $this->getParams('post', $param);
    }

    /**
     * @param string $param
     * @return mixed
     */
    public function getSession(string $param = '')
    {
        return $this->getParams('session', $param);
    }


    /**
     * @param string $location
     * @param string $message
     */
    public function toLocation(string $location = '', string $message = '')
    {
        if ($location != '') {
            header("location: {$location}");
        } elseif (empty($_SERVER['HTTP_REFERER'])) {
            header("location: /");
        } else {
            header("location: {$_SERVER['HTTP_REFERER']}");
        }
    }

}
