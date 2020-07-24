<?php

namespace app\services;


class RendererTemplate implements IRenderer
{

    /**
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render(string $template, array $params = [])
    {
        $content = $this->rendererTemplate($template, $params);
        return $this->rendererTemplate(
            'layouts/main',
            [
                'title' => $params['title'],
                'menu' => $params['menu'],
                'content' => $content,
            ]
        );
    }

    /**
     * @param string $template
     * @param array $params
     * @return mixed
     */
    private function rendererTemplate(string $template, array $params = [])
    {
        ob_start();
        extract($params);
        include dirname(__DIR__) . "/views/{$template}.php";
        return ob_get_clean();
    }

}
