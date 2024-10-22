<?php

namespace App\Console;

use App\Support\Console\Command;
use App\Support\Console\Input;
use App\Support\Console\Output;

class HelloWorldCommand extends Command
{
    public function execute(Input $input, Output $output): void
    {
        $output->success('Hello World!');
    }
}