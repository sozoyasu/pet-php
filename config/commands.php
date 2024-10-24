<?php

use App\Console\MigrationDownCommand;
use App\Console\MigrationUpCommand;

return [
    'migration:up' => MigrationUpCommand::class,
    'migration:down' => MigrationDownCommand::class,
];