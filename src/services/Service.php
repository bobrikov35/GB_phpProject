<?php

namespace app\services;

use app\engine\Container;


/**
 * Class Service
 * @package app\services
 */
abstract class Service
{

    /**
     * С В О Й С Т В А
     */

    protected array $config;
    protected Container $container;
    protected Request $request;


    /**
     * М А Г И Ч Е С К И Е   Ф У Н К Ц И И
     */

    /**
     * Service constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
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
        $this->request = $container->request;
    }



    /**
     * С И Н Т А К С И Ч Е С К И Й   С А Х А Р
     */

    /**
     * @param string $param
     * @return array|mixed|null
     */
    protected function getPost(string $param = '')
    {
        return $this->container->request->getPost($param);
    }

}
