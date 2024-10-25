<?php

namespace Modules\Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    private string $scheme = '';
    private string $host = '';
    private ?int $port = null;
    private string $path = '';
    private string $query = '';
    private string $userInfo = '';
    private string $fragment = '';

    public function __construct(string $url = '')
    {
        if (!empty($url)) {
            $parsed = parse_url($url);
            $this->scheme = $parsed['scheme'] ?? '';
            $this->host = $parsed['host'] ?? '';
            $this->port = $parsed['port'] ?? null;
            $this->path = $parsed['path'] ?? '';
            $this->query = $parsed['query'] ?? '';
            $this->userInfo = $parsed['user'] ?? '';

            if (!empty($this->userInfo) && !empty($parsed['pass'])) {
                $this->userInfo .= ':' . $parsed['pass'];
            }

            $this->fragment = $parsed['fragment'] ?? '';
        }
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getAuthority(): string
    {
        return (empty($this->userInfo) ? '' : $this->userInfo . '@') . $this->host . (empty($this->port) ? '' : ':' . $this->port);
    }

    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withScheme(string $scheme): UriInterface
    {
        $new = clone $this;
        $new->scheme = $scheme;

        return $new;
    }

    public function withUserInfo(string $user, ?string $password = null): UriInterface
    {
        $new = clone $this;
        $new->userInfo = $user;

        if ($password !== null) {
            $new->userInfo .= ':' . $password;
        }

        return $this;
    }

    public function withHost(string $host): UriInterface
    {
        $new = clone $this;
        $new->host = $host;

        return $new;
    }

    public function withPort(?int $port): UriInterface
    {
        $new = clone $this;
        $new->port = $port;

        return $new;
    }

    public function withPath(string $path): UriInterface
    {
        $new = clone $this;
        $new->path = $path;

        return $new;
    }

    public function withQuery(string $query): UriInterface
    {
        $new = clone $this;
        $new->query = $query;

        return $new;
    }

    public function withFragment(string $fragment): UriInterface
    {
        $new = clone $this;
        $new->fragment = $fragment;

        return $new;
    }

    public function __toString(): string
    {
        return implode('', [
           $this->scheme . '://',
           $this->getAuthority(),
           $this->getPath() . '?',
           $this->getQuery() . '#',
           $this->getFragment(),
        ]);
    }
}