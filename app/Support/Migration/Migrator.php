<?php

namespace App\Support\Migration;

use PDO;
use PDOException;

class Migrator
{
    private string $path;
    private PDO $pdo;

    public function __construct(string $path, PDO $pdo)
    {
        $this->path = $path;
        $this->pdo = $pdo;

        if ($pdo->query("SHOW TABLES LIKE 'migrations'")->fetch() === false) {
            $lines = implode(',', [
                'id BIGINT auto_increment',
                'name VARCHAR(255)',
                'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'CONSTRAINT id PRIMARY KEY (id)',
            ]);
            $pdo->exec("CREATE TABLE migrations({$lines})");
        }
    }

    /**
     * Выполняет невыполненные миграции
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getUncompletedMigrations() as $name) {
            $this->upTo($name);
        }
    }

    /**
     * Откатывает выполненные миграции
     *
     * @return void
     */
    public function down(): void
    {
        foreach (array_reverse($this->getCompletedMigrations()) as $name) {
            $this->downTo($name);
        }
    }

    /**
     * Вызывает метод up у миграции по названию
     * @param string $name
     * @return void
     */
    public function upTo(string $name): void
    {
        $migration = $this->getInstance($name);
        $migration->up($this->pdo);
        $this->pdo->exec('INSERT INTO migrations (name) VALUES ("'.$name.'")');
    }

    /**
     * Вызывает метод down у миграции по названию
     * @param string $name
     * @return void
     */
    public function downTo(string $name): void
    {
        $migration = $this->getInstance($name);
        $migration->down($this->pdo);
        $this->pdo->exec('DELETE FROM migrations WHERE name = "'.$name.'"');
    }

    /**
     * Создает объект миграции по названию
     *
     * @param string $name
     * @return Migration
     */
    public function getInstance(string $name): Migration
    {
        $class = require_once $this->path . DIRECTORY_SEPARATOR . $name . '.php';

        return new $class();
    }

    public function getUncompletedMigrations(): array
    {
        $completed = $this->getCompletedMigrations();
        $uncompleted = $this->scan();

        foreach ($completed as $name) {
            if (in_array($name, $uncompleted)) {
                foreach ($uncompleted as $key => $value) {
                    if ($value == $name) {
                        unset($uncompleted[$key]);
                    }
                }
            }
        }

        return $uncompleted;
    }

    /**
     * Возвращает список выполненных миграций
     * @return array
     */
    private function getCompletedMigrations(): array
    {
        $result = [];

        try {
            $stmt = $this->pdo->query("SELECT name FROM migrations");

            foreach ($stmt->fetchAll() ?? [] as $row) {
                $result[] = $row['name'];
            }
        } catch (PDOException $e) {}

        return $result;
    }

    /**
     * Сканирует каталог с миграциями и возвращает массив с названиями
     *
     * @return array
     */
    private function scan(): array
    {
        $migrations = [];

        foreach (scandir($this->path) as $filename) {
            if (str_ends_with($filename, '.php')) {
                $migrations[] = substr($filename, 0, -4);
            }
        }

        return $migrations;
    }
}