<?php

namespace App\Support\Migration;

use PDO;

class Migrator
{
    public function __construct(
        private string $path
    ) {}

    public function create(string $name): void
    {
        file_put_contents($file, $current);
    }
}