<?php

namespace App\Console;

use App\Support\Console\Command;
use App\Support\Console\Input;
use App\Support\Console\Output;
use App\Support\Migration\Migrator;

class MigrationDownCommand extends Command
{
    public function __construct(
        private Migrator $migrator
    ){}

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('Migrating database...');
        $this->migrator->down();
        $output->success('Migration success removed');
    }
}