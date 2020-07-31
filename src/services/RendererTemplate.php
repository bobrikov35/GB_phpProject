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

    /**
     * С В О Й С Т В А
     */

    protected Environment $twig;


    /**
     * М А Г И Ч Е С К И Е   Ф У Н К Ц И И
     */

    /**
     * RendererTemplate constructor.
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
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Вывод шаблона
     *
     * @param string $template
     * @param array $params
     * @return string
     */
    public function render(string $template, array $params = []): string
    {
        try {
            return $this->twig->render($template, $params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

}
