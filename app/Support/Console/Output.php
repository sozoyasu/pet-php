<?php

namespace App\Support\Console;

class Output
{
    /**
     * Выводит текст в консоль
     *
     * @param string $message
     * @return Output
     */
    public function write(string $message): static
    {
        echo $message;

        return $this;
    }

    /**
     * Выводит текст в консоль и переносит на следующую строку
     *
     * @param string $message
     * @return Output
     */
    public function writeln(string $message): static
    {
        echo $message . PHP_EOL;

        return $this;
    }

    /**
     * Предупреждение (желтый цвет)
     *
     * @param string $message
     * @return $this
     */
    public function warning(string $message): static
    {
        $this->writeln(
            $this->withColor(33, $message)
        );

        return $this;
    }

    /**
     * Информация (голубой цвет)
     *
     * @param string $message
     * @return $this
     */
    public function info(string $message): static
    {
        $this->writeln(
            $this->withColor(36, $message)
        );

        return $this;
    }

    /**
     * Сообщение об ошибке (красный цвет)
     *
     * @param string $message
     * @return $this
     */
    public function error(string $message): static
    {
        $this->writeln(
            $this->withColor(31, $message)
        );

        return $this;
    }

    /**
     * Сообщение об успехе (зеленый цвет)
     *
     * @param string $message
     * @return $this
     */
    public function success(string $message): static
    {
        $this->writeln(
            $this->withColor(32, $message)
        );

        return $this;
    }

    /**
     * Возвращает текст с escape-символом цвета в начале и возвращением на исходный в конце
     *
     * @param int $colorNumber
     * @param string $string
     * @return string
     */
    public function withColor(int $colorNumber, string $string): string
    {
        return "\033[" . $colorNumber . "m" . $string . "\033[0m";
    }
}