<?php

namespace App\Support\Console;

class Input
{
    protected array $arguments = [];

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Возвращает аргумент по номеру
     *
     * @param int $num
     * @return string
     */
    public function getArgument(int $num): string
    {
        if (!isset($this->arguments[$num])) {
            throw new \InvalidArgumentException("Argument $num does not exist");
        }

        return $this->arguments[$num];
    }

    /**
     * Возвращает весь список аргументов
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}