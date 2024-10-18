<?php

namespace App\Support\Container;

use App\Support\Container\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $definitions = [];
    private array $cache = [];

    /**
     * Возвращает сервис по ключу
     * @throws NotFoundException
     */
    public function get(string $id): mixed
    {
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }

        if (!$this->has($id)) {
            throw new NotFoundException("Service #{$id} not found");
        }

        $definition = $this->definitions[$id];

        if (is_callable($definition)) {
            $definition = call_user_func($definition, $this);
        }

        return $this->cache[$id] = $definition;
    }

    /**
     * Записывает содержимое $content по ключу $id
     */
    public function set(string $id, mixed $content): static
    {
        $this->definitions[$id] = $content;

        if (isset($this->cache[$id])) {
            unset($this->cache[$id]);
        }

        return $this;
    }

    /**
     * Проверяет, существует ли сервис по $id в списке сервисов
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->definitions[$id]);
    }
}