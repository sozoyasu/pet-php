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