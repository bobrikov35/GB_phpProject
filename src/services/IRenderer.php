<?php

namespace app\services;


/**
 * Interface IRenderer
 * @package app\services
 */
interface IRenderer
{

    /**
     * П У Б Л И Ч Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * Вывод шаблона
     *
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render(string $template, array $params = []);

}
