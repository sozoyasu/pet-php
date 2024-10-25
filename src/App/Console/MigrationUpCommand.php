<?php

namespace App\Console;

use Modules\Console\Command;
use Modules\Console\Input;
use Modules\Console\Output;
use Modules\Migration\Migrator;

class MigrationUpCommand extends Command
{
    public function __construct(
        private Migrator $migrator
    ){}

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('Migrating database...');
        $this->migrator->up();
        $output->success('Migration finished');
    }
}