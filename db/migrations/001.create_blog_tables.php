<?php

use Modules\Migration\Migration;

return new class implements Migration
{
    public function up(PDO $pdo): void
    {
        $pdo->exec("CREATE TABLE blog_posts (id BIGINT PRIMARY KEY AUTO_INCREMENT, title VARCHAR(255), annotation VARCHAR(255) DEFAULT '', content LONGTEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec("DROP TABLE blog_posts");
    }
};