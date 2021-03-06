<?php

namespace app\services;


class Request
{

    private const CONTROLLER_DEFAULT = 'home';

    private string $URI;
    private string $controller = 'home';
    private string $action = 'default';
    private int $id = 0;
    private int $page = 1;
    private array $params;


    /**
     * Request constructor.
     */
    public function __construct()
    {
        session_start();
        $this->URI = $_SERVER['REQUEST_URI'];
        $this->params = [
            'get' => $_GET,
            'post' => $_POST,
            'session' => $_SESSION,
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
        if (!class_exists("app\\controllers\\{$this->controller}")) {
            $this->controller = self::CONTROLLER_DEFAULT;
        }
        return  "app\\controllers\\{$this->controller}";
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
     * @param string $type
     * @return mixed
     */
    public function getParams(string $list, string $param, string $type = 'string')
    {
        if (empty($param)) {
            return $this->params[$list];
        }
        if (empty($this->params[$list][$param])) {
            $result = '';
        } else {
            $result = $this->params[$list][$param];
        }
        if (gettype($result) == $type) {
            return $result;
        }
        if ($type == 'int') {
            if (is_numeric($result)) {
                return (int)$result;
            }
            return 0;
        }
        if ($type == 'float') {
            if (is_numeric($result)) {
                return (float)$result;
            }
            return 0;
        }
        if ($type == 'array') {
            if ($list = explode(PHP_EOL, $result)) {
                return $list;
            }
            return [];
        }
        return $result;
    }

    /**
     * @param string $param
     * @param string $type
     * @return mixed
     */
    public function getPost(string $param = '', string $type = 'string')
    {
        return $this->getParams('post', $param, $type);
    }

    /**
     * @param string $param
     * @param string $type
     * @return mixed
     */
    public function getSession(string $param = '', string $type = 'string')
    {
        return $this->getParams('session', $param, $type);
    }

}
