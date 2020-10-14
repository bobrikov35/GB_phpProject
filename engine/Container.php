<?php

namespace app\engine;

use app\services\{DB, RendererTemplate, Request, Paginator};
use app\controllers\{Cart as CCart, Home, Order as COrder, Product as CProduct};
use app\repositories\{Order as ROrder, Product as RProduct, User as RUser};
use app\services\{Authorization, Cart as SCart, Product as SProduct, User as SUser};


/**
 * Class Container
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
 * @property COrder $controllerOrder
 * @property CProduct $controllerProduct
 *
 * @property ROrder $repositoryOrder
 * @property RProduct $repositoryProduct
 * @property RUser $repositoryUser
 *
 * @property SCart $serviceCart
 * @property SProduct $serviceProduct
 * @property SUser $serviceUser
 */
class Container
{

    private array $components = [];
    private array $componentsItems = [];

    /**
     * Container constructor.
     * @param array $components
     */
    public function __construct(array $components)
    {
        $this->components = $components;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (key_exists($name, $this->componentsItems)) {
            return $this->componentsItems[$name];
        }
        if (!key_exists($name, $this->components) or !class_exists($this->components[$name]['class'])) {
            return null;
        }
        $class = $this->components[$name]['class'];
        if (key_exists('config', $this->components[$name])) {
            $config = $this->components[$name]['config'];
            $this->componentsItems[$name] = new $class($config);
        } else {
            $this->componentsItems[$name] = new $class();
        }
        if (method_exists($this->componentsItems[$name], 'setContainer')) {

            $this->componentsItems[$name]->setContainer($this);
        }
        return $this->componentsItems[$name];
    }

}
