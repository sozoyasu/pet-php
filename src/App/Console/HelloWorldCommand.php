<?php

namespace App\Console;

use Modules\Console\Command;
use Modules\Console\Input;
use Modules\Console\Output;

class HelloWorldCommand extends Command
{
    public function execute(Input $input, Output $output): void
    {
        $output->success('Hello World!');
    }
}