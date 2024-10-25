<?php

namespace Modules\View;

class ViewRender
{
    private string $path;
    private array $extensions = [];

    public function __construct(string $path, array $extensions = [])
    {
        $this->path = $path;
        $this->extensions = $extensions;
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
        extract($this->extensions, EXTR_OVERWRITE);

        ob_start();
        include $path;
        return ob_get_clean();
    }
}