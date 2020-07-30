<?php

namespace app\engine;

use app\services\{DB, RendererTemplate, Request, Paginator};
use app\controllers\{Cart as CCart, Home, Product as CProduct};
use app\repositories\{Product as RProduct, User as RUser};
use app\services\{Authorization, Cart as SCart, Product as SProduct, User as SUser};
use app\traits\TSingleton;


/**
 * Class App
 * @package app\engine
 *
 * @property DB $database
 * @property RendererTemplate $renderer
 * @property Request $request
 * @property Authorization $authorization
 * @property Paginator $paginator
 *
 * @property CCart $controllerCart
 * @property Home $controllerHome
 * @property CProduct $controllerProduct
 *
 * @property RProduct $repositoryProduct
 * @property RUser $repositoryUser
 *
 * @property SCart $serviceCart
 * @property SProduct $serviceProduct
 * @property SUser $serviceUser
 */
class App
{

    use TSingleton;


    private array $config = [];
    private Container $container;


    public function __get($name)
    {
        return $this->container->$name;
    }


    /**
     * @return App
     */
    public static function call()
    {
        return static::getInstance();
    }


    /**
     * @param string $key
     * @param mixed|null $defaultValue
     * @return array|mixed|null
     */
    public function getSettings(string $key = '', $defaultValue = null)
    {
        if (empty($key)) {
            return $this->config;
        }
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        }
        return $defaultValue;
    }

    /**
     * @param array $config
     * @return mixed
     */
    public function run(array $config)
    {
        $this->config = $config;
        $this->setContainer();
        return $this->runController();
    }

    private function setContainer(): void
    {
        $this->container = new Container(
            $this->config['components']
        );
    }

    /**
     * @return mixed
     */
    private function runController()
    {
        $controllerName = $this->request->getController();
        if (!class_exists($controllerName)) {
            $controllerName = "app\\controllers\\{$this->config['controllerDefault']}";
        }
        $controller = new $controllerName($this);
        return $controller->run($this->request->getAction());
    }

}
