<?php

namespace app\services;

use \Exception;
use \Twig\{Environment, Loader\FilesystemLoader};


/**
 * Class RendererTemplate
 * @package app\services
 */
class RendererTemplate implements IRenderer
{

    protected Environment $twig;

    /**
     * RendererTemplate constructor
     */
    public function __construct()
    {
        $loader = new FilesystemLoader([
            '../views/',
            '../views/layouts',
        ]);
        $this->twig = new Environment($loader, [
            'cache' => 'compilation_cache',
            'auto_reload' => true,
        ]);
    }

    /**
     * @param string $template
     * @param array $params
     * @return mixed|string
     */
    public function render(string $template, array $params = [])
    {
        try {
            return $this->twig->render($template, $params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

}
