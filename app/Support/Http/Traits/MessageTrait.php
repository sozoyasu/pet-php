<?php

namespace App\Support\Http\Traits;

use Psr\Http\Message\MessageInterface;

trait MessageTrait
{
    protected string $version = '1.1';
    protected array $headers = [];

    public function getProtocolVersion(): string
    {
        return $this->version;
    }

    public function withProtocolVersion(string $version): MessageInterface
    {
        $new = clone $this;
        $new->version = $version;

        return $new;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }

    public function getHeader(string $name): array
    {
        if (!$this->hasHeader($name)) {
            throw new \InvalidArgumentException("Header '{$name}' does not exist.");
        }

        return $this->headers[$name];
    }

    public function getHeaderLine(string $name): string
    {
        $header = $this->getHeader($name);

        return implode(',', $header);
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        $new = clone $this;
        $new->headers[$name] = is_array($value) ? $value : [$value];

        return $new;
    }

    public function withAddedHeader(string $name, $value): MessageInterface
    {
        $new = clone $this;
        $new->headers[$name][] = $value;

        return $new;
    }

    public function withoutHeader(string $name): MessageInterface
    {
        $new = clone $this;
        unset($new->headers[$name]);

        return $new;
    }

    /**
     * Пробегает по массиву заголовков и если среди значений не вложенный массив - делает его таким
     * @param array $headers
     * @return void
     */
    protected function normalizeHeaders(): void
    {
        foreach ($this->headers as $name => $value) {
            if (!is_array($value)) {
                $this->headers[$name] = [$value];
            }
        }
    }
}