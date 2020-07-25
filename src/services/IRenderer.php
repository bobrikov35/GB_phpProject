<?php

namespace app\services;


interface IRenderer
{

    /**
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render(string $template, array $params = []);

}
