<?php

namespace Modules\View;

use InvalidArgumentException;

class ViewRender
{
    private string $path;
    private array $extensions = [];
    private array $cachedExtensions = [];

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

        ob_start();
        include $path;
        return ob_get_clean();
    }

    // ------------------------------------------------
    // Extensions
    // ------------------------------------------------

    /**
     * Расширяет рендер
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function expand(string $name, callable $callback): void
    {
        $this->extensions[$name] = $callback;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->cachedExtensions)) {
            return $this->cachedExtensions[$name];
        }

        if (array_key_exists($name, $this->extensions)) {
            $callable = $this->extensions[$name];

            return $this->cachedExtensions[$name] = $callable();
        }

        throw new InvalidArgumentException('Invalid view extension: ' . $name);
    }

//    public function __call(string $name, array $arguments)
//    {
//        if (array_key_exists($name, $this->cachedExtensions) && (is_object($this->cachedExtensions[$name]) || is_callable($this->cachedExtensions[$name]))) {
//            $object = $this->cachedExtensions[$name];
//
//            return $object(...$arguments);
//        }
//
//        if (array_key_exists($name, $this->extensions)) {
//            $callable = $this->extensions[$name];
//
//            return $this->cachedExtensions[$name] = $callable()(...$arguments);
//        }
//
//        throw new InvalidArgumentException('Invalid view extension: ' . $name);
//    }
}