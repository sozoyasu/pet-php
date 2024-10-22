<?php

namespace App\Support\Migration;

use PDO;

interface Migration
{
    public function up(PDO $pdo): void;
    public function down(PDO $pdo): void;
}