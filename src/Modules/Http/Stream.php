<?php

namespace Modules\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    protected $resource = null;

    public function __construct(string $stream, string $mode = 'r')
    {
        $this->resource = fopen($stream, $mode);
    }

    public function __toString(): string
    {
        return $this->getContents();
    }

    /**
     * Отсоединяет ресурс от объекта и возвращает его
     *
     * @return false|mixed|resource|null
     */
    public function detach()
    {
        $resource = $this->resource;
        $this->resource = null;

        return $resource;
    }

    /**
     * Проверяет закреплен ли поток
     *
     * @return bool
     */
    public function isAttached(): bool
    {
        return is_resource($this->resource);
    }

    /**
     * Закрывает поток
     *
     * @return void
     */
    public function close(): void
    {
        $this->throwIfNotAttached();

        fclose($this->resource);
    }

    /**
     * Выполняет чтение потока
     *
     * @param int $length
     * @return string
     */
    public function read(int $length): string
    {
        $this->throwIfNotAttached();

        $result = fread($this->resource, $length);

        return $result;
    }

    /**
     * Возвращает содержимое потока
     *
     * @return string
     */
    public function getContents(): string
    {
        return stream_get_contents($this->resource);
    }

    /**
     * Возвращает информацию из функции fstat
     *
     * @param string|null $key
     * @return array|string|int
     */
    public function getStats(?string $key = null): array|string|int
    {
        $stats = fstat($this->resource);

        if (is_null($key)) {
            return $stats;
        }

        return $stats[$key] ?? false;
    }

    /**
     * Возвращает информацию из функции stream_get_meta_data
     *
     * @param string|null $key
     * @return mixed
     */
    public function getMetadata(?string $key = null): mixed
    {
        $meta = stream_get_meta_data($this->resource);

        if (null === $key) {
            return $meta;
        }

        return $meta[$key];
    }

    /**
     * Возвращает размер потока, если он известен
     *
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->getStats('size') ?? null;
    }

    /**
     * Возвращает текущее положение указателя
     *
     * @return int
     */
    public function tell(): int
    {
        $this->throwIfNotAttached();

        return ftell($this->resource);
    }

    /**
     * Проверяет, находится ли указатель в конце файла
     *
     * @return bool
     */
    public function eof(): bool
    {
        $this->throwIfNotAttached();

        return feof($this->resource);
    }

    /**
     * Доступно ли у потока перемещение указания
     *
     * @return bool
     */
    public function isSeekable(): bool
    {
        return $this->getMetadata('seekable');
    }

    /**
     * Перемещает указатель на заданное $offset число байт
     * @param int $offset
     * @param int $whence
     * @return void
     */
    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        $this->throwIfNotAttached();

        fseek($this->resource, $offset, $whence);
    }

    /**
     * Перемещает указатель в начало файла
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->seek(0);
    }

    /**
     * Проверяет доступен ли поток для записи
     *
     * @return bool
     */
    public function isWritable(): bool
    {
        $mode = $this->getMetadata('mode');

        return str_contains($mode, 'x')
            || str_contains($mode, 'w')
            || str_contains($mode, 'c')
            || str_contains($mode, 'a')
            || str_contains($mode, '+');
    }

    /**
     * Пишет в поток (если доступно)
     *
     * @param string $string
     * @return int
     */
    public function write(string $string): int
    {
        $this->throwIfNotAttached();

        if (!$this->isWritable()) {
            throw new \RuntimeException('Stream is not writable');
        }

        fwrite($this->resource, $string);

        return 0;
    }

    /**
     * Чтение данных с потока разрешено
     *
     * @return bool
     */
    public function isReadable(): bool
    {
        return $this->getMetadata('readable');
    }

    private function throwIfNotAttached(): void
    {
        if (!$this->isAttached()) {
            throw new \RuntimeException('Stream is not attached');
        }
    }
}