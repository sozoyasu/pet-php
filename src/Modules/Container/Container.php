<?php

namespace Modules\Container;

use Modules\Container\Exceptions\ContainerException;
use Modules\Container\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private array $definitions = [];
    private array $cache = [];

    public function __construct(array $set = [])
    {
        $this->definitions = $set;
    }

    /**
     * Возвращает сервис по ключу
     * @param string $id
     * @return mixed
     * @throws ContainerException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function get(string $id): mixed
    {
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }

        if (!$this->has($id)) {
            if (class_exists($id)) {
                $reflection = new ReflectionClass($id);

                if ($constructor = $reflection->getConstructor()) {
                    $attributes = [];

                    foreach ($constructor->getParameters() as $param) {
                        $className = $param->getType()->getName();

                        // Если запрашивается объект контейнера - инжектим текущий объект
                        if (is_a($this, $className) || is_a(ContainerInterface::class, $className)) {
                            $attributes[] = $this;
                        // Если существует класс, дергаем его из контейнера
                        } elseif ($this->has($className) || class_exists($className)) {
                            $attributes[] = $this->get($className);
                        } else {
                            throw new ContainerException('Unsupported parameter type: ' . $param->getType()->getName());
                        }
                    }

                    $instance = $reflection->newInstanceArgs($attributes);
                } else {
                    $instance = new $id();
                }

                return $this->cache[$id] = $instance;
            }

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