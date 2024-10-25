<?php

namespace Modules;

class Config
{
    public const string SEPARATOR = '.';

    private array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function __invoke(string $key, mixed $default = null): string|array|int|float|bool|null
    {
        return $this->get($key, $default);
    }

    /**
     * Возвращает параметр по ключу
     *
     * @param string $key
     * @param mixed|null $default
     * @return string|array|int|float|bool|null
     */
    public function get(string $key, mixed $default = null): string|array|int|float|bool|null
    {
        if (str_contains($key, self::SEPARATOR)) {
            return $this->withSeparator($this->options, explode(self::SEPARATOR, $key), $default);
        }

        return $this->options[$key] ?? $default;
    }

    /**
     * Рекурсивно перебирает массив параметров с разделителем
     *
     * @param array|null $array
     * @param array $keys
     * @param mixed|null $default
     * @return mixed
     */
    private function withSeparator(array|null $array, array $keys, mixed $default = null): mixed
    {
        $stack = $keys;
        $first = array_shift($stack);

        if (isset($array[$first])) {
            if (empty($stack)) {
                return $array[$first];
            }

            if (is_array($array[$first])) {
                return $this->withSeparator($array[$first], $stack, $default);
            }
        }

        return $default;
    }
}