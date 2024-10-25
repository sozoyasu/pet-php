<?php

namespace Modules\View;

use InvalidArgumentException;
use SplStack;

class ViewRender
{
    private string $path;
    private array $extensions = [];
    private array $cachedExtensions = [];
    private array $content = [];
    private SplStack $sectionsStack;
    private string|null $extend = null;

    public function __construct(string $path, array $extensions = [])
    {
        $this->path = $path;
        $this->extensions = $extensions;
        $this->sectionsStack = new SplStack();
    }

    public function render(string $template, array $attributes = []): string
    {
        extract($attributes, EXTR_OVERWRITE);

        ob_start();
        include $this->getTemplatePath($template);
        $rendered = ob_get_clean();

        if (empty($this->extend)) {
            return $rendered;
        }

        $template = $this->extend;
        $this->extend = null;


        return $this->render($template, $attributes);
    }

    private function getTemplatePath(string $template): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $template . '.php';
    }

    // ------------------------------------------------
    // Extends & Sections
    // ------------------------------------------------

    public function extend(string $template): static
    {
        $this->extend = $template;

        return $this;
    }

    public function content(string $name): string
    {
        return $this->content[$name] ?? '';
    }

    public function section(string $name): void
    {
        $this->sectionsStack->push($name);
        ob_start();
    }

    public function endSection(): void
    {
        $this->content[$this->sectionsStack->pop()] = ob_get_clean();
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
}