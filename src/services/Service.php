<?php

namespace app\services;

use app\engine\Container;


/**
 * Class Service
 * @package app\services
 */
abstract class Service
{

    protected array $config;
    protected Container $container;
    protected Request $request;


    /**
     * DB constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }


    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
        $this->request = $container->request;
    }

}
