<?php

namespace App\Support\Console;

abstract class Command
{
    /**
     * Выполняет команду
     *
     * @param Input $input
     * @param Output $output
     * @return void
     */
    abstract public function execute(Input $input, Output $output): void;
}