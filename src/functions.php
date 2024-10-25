<?php

/**
 * Возвращает путь от корня проекта
 *
 * @param string $inner
 * @return string
 */
function root_path(string $inner = ''): string
{
    $path = dirname(__DIR__);

    if (!empty($path)) {
        $path = $path . DIRECTORY_SEPARATOR . $inner;
    }

    return $path;
}

/**
 * Возвращает значение из $_ENV, либо значение по умолчанию $default
 *
 * @param string $key
 * @param null $default
 * @return mixed
 */
function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? $default;
}

/**
 * Распечатывает данные
 *
 * @param mixed $data
 * @param bool $varDump
 * @return void
 */
function dump(mixed $data, bool $varDump = false): void
{
    echo '<pre style="position: relative; z-index: 400;">';

    if ($varDump) {
        var_dump($data);
    } else {
        print_r((is_array($data) || is_object($data)) ? $data : htmlspecialchars($data));
    }

    echo '</pre>';
}