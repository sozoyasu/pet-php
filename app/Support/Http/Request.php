<?php

namespace App\Support\Http;

use App\Support\Http\Exceptions\UndefinedQueryParamException;
use App\Support\Http\Traits\MessageTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements ServerRequestInterface
{
    use MessageTrait;

    public const string DEFAULT_METHOD = 'GET';
    public const string DEFAULT_REQUEST_TARGET = '/';

    private array $serverParams;
    private array $queryParams;
    private array $bodyParams;
    private ?Stream $body;
    private array $cookies;
    private array $files;
    private array $attributes = [];
    private Uri $uri;
    private string $method;
    private string $requestTarget;

    public function __construct(
        array $serverParams = [],
        array $queryParams = [],
        array $bodyParams = [],
        Stream $body = null,
        array $cookies = [],
        array $files = [],
        Uri $uri = null,
        string $method = self::DEFAULT_METHOD,
        string $requestTarget = self::DEFAULT_REQUEST_TARGET,
    ){
        $this->serverParams = $serverParams;
        $this->queryParams = $queryParams;
        $this->bodyParams = $bodyParams;
        $this->body = $body;
        $this->files = $cookies;
        $this->cookies = $cookies;
        $this->method = $method;
        $this->requestTarget = $requestTarget;

        if (isset($uri)) {
            $this->uri = $uri;
        }
    }

    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    public function getUploadedFiles(): array
    {
        return $this->files;
    }

    public function withUploadedFiles(array $uploadedFiles): static
    {
        $new = clone $this;
        $new->files = $uploadedFiles;

        return $new;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod(string $method): static
    {
        $new = clone $this;
        $new->method = $method;

        return $new;
    }

    public function getRequestTarget(): string
    {
        return $this->requestTarget;
    }

    public function withRequestTarget(string $requestTarget): static
    {
        $new = clone $this;
        $new->requestTarget = $requestTarget;

        return $new;
    }

    // -------
    // QueryParams
    // -------

    public function hasQueryParam(string $name): bool
    {
        return isset($this->queryParams[$name]);
    }

    public function getQueryParam(string $name): string
    {
        if (!$this->hasQueryParam($name)) {
            throw new UndefinedQueryParamException("Query param '$name' not found");
        }

        return $this->queryParams[$name];
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query): static
    {
        $new = clone $this;
        $new->queryParams = $query;

        return $new;
    }

    // -------
    // Body
    // -------

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    public function getParsedBody(): array
    {
        return $this->bodyParams;
    }

    public function withParsedBody($data): static
    {
        $new = clone $this;
        $new->body = $data;

        return $new;
    }

    public function withBody(StreamInterface $body): static
    {
        $new = clone $this;
        $new->body = $body;

        return $new;
    }

    // -------
    // Cookie
    // -------

    public function getCookieParams(): array
    {
        return $this->cookies;
    }

    public function withCookieParams(array $cookies): static
    {
        $new = clone $this;
        $new->cookies = $cookies;

        return $new;
    }

    // -------
    // Uri
    // -------

    public function getUri(): Uri
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false): static
    {
        $new = clone $this;
        $new->uri = $uri;

        return $new;

        // TODO: add $preserveHost functional.
    }

    // -------
    // Attributes
    // -------

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    public function withAttribute(string $name, $value): static
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    public function withoutAttribute(string $name): static
    {
        $new = clone $this;
        unset($new->attributes[$name]);

        return $new;
    }

}