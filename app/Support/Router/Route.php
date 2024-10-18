<?php

namespace App\Support\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route
{
    /** @var string Шаблон URI */
    private string $pattern;

    /** @var mixed Обработчик */
    private mixed $handler;

    /** @var Method|Method[]  */
    private array $methods;
    private ?string $name;
    private array $attributes = [];

    public function __construct(string $pattern, mixed $handler, array|Method $method = Method::GET, string $name = null,  array $attributes = [])
    {
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->name = $name;
        $this->methods = is_array($method) ? $method : [$method];
        $this->attributes = $attributes;
    }

    /**
     * Статическое создание экземпляра маршрута
     */
    public static function create(string $pattern, mixed $handler, array|Method $method = Method::GET, string $name = null,  array $attributes = []): static
    {
        return new static($pattern, $handler, $method, $name, $attributes);
    }

    /**
     * Проверка
     * @param Method $method
     * @param string $uri
     * @return bool
     */
    public function match(Method $method, string $uri): bool
    {
        if (!$this->checkMethod($method)) {
            return false;
        }

        if ($this->getPattern() == '/' || $this->getPattern() == '') {
            return $uri == '/';
        }

        $pattern = preg_replace_callback('~\{([^\}]+)\}~', fn ($matches) => '(?P<'.$matches[1].'>[^}]+)', $this->getPattern());

        preg_match('~' . $pattern . '~', $uri,$matchesAttributes);

        if (!empty($matchesAttributes)) {
            $attributes = array_filter($matchesAttributes, '\is_string', ARRAY_FILTER_USE_KEY);
            $this->addAttributes($attributes);

            return true;
        }

        return false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function withName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getMethod(): Method
    {
        return $this->methods;
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    public function addAttribute(string $key, string $value): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function addAttributes(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->addAttribute($key, $value);
        }

        return $this;
    }

    private function checkMethod(Method $method): bool
    {
        if (is_array($this->methods)) {
            return in_array($method, $this->methods);
        } else {
            return $this->methods == $method;
        }
    }
}