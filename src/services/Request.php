<?php

namespace app\services;

use app\engine\Container;


/**
 * Class Request
 * @package app\services
 */
class Request extends Service
{

    /**
     * С В О Й С Т В А
     */

    private string $URI;
    private array $params;
    private string $controller = '';
    private string $action = '';
    private int $id = 0;
    private int $page = 1;


    /**
     * М А Г И Ч Е С К И Е   Ф У Н К Ц И И
     */

    /**
     * Request constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        session_start();
        $this->URI = $_SERVER['REQUEST_URI'];
        $this->params = [
            'get' => !empty($_GET) ? $_GET : [],
            'post' => !empty($_POST) ? $_POST : [],
            'session' => !empty($_SESSION) ? $_SESSION : [],
        ];
        $this->prepareRequest();
    }

    /**
     * Заполняет свойства
     */
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
     * G E T T E R ' Ы
     */

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return "app\\controllers\\{$this->controller}";
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
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Записывает данные в сессию
     *
     * @param string $name
     * @param mixed $value
     */
    public function setSession(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Возвращает массив (get, post или session) или параметр из массива
     *
     * @param string $list
     * @param string $param
     * @return array|mixed|null
     */
    public function getParams(string $list = 'get', string $param = '')
    {
        if (!in_array($list, ['get', 'post', 'session'])) {
            return null;
        }
        if (empty($param)) {
            return $this->params[$list];
        }
        if (empty($this->params[$list][$param])) {
            return null;
        }
        return $this->params[$list][$param];
    }

    /**
     * Возвращает post-массив или параметр из массива
     *
     * @param string $param
     * @return array|mixed|null
     */
    public function getPost(string $param = '')
    {
        return $this->getParams('post', $param);
    }

    /**
     * Возвращает session-массив или параметр из массива
     *
     * @param string $param
     * @return array|mixed|null
     */
    public function getSession(string $param = '')
    {
        return $this->getParams('session', $param);
    }

    /**
     * Изменение локации (перенаправление)
     *
     * @param string $location
     * @param string $message
     */
    public function toLocation(string $location = '', string $message = ''): void
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
