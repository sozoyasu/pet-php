<?php

namespace App\Support\View;

class ViewRender
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $template, array $attributes = []): string
    {
        return $this->buffer($this->getTemplatePath($template), $attributes);
    }

    private function getTemplatePath(string $template): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $template . '.php';
    }

    private function buffer(string $path, array $attributes = []): string
    {
        extract($attributes, EXTR_OVERWRITE);
        ob_start();
        include $path;
        return ob_get_clean();
    }
}