<?php

namespace LaravelLang\Publisher\Helpers;

class Config
{
    public const PUBLIC_KEY = 'lang-publisher';

    public const PRIVATE_KEY = 'lang-publisher-private';

    public function basePath(): string
    {
        return $this->getPrivate('path.vendor');
    }

    public function resourcesPath(): string
    {
        return $this->getPrivate('path.resources');
    }

    public function hasInline(): bool
    {
        return $this->getPublic('inline', false);
    }

    public function hasAlign(): bool
    {
        return $this->getPublic('align', true);
    }

    protected function getPrivate(string $key): mixed
    {
        return $this->get(self::PRIVATE_KEY, $key);
    }

    protected function getPublic(string $key, mixed $default = null): mixed
    {
        return $this->get(self::PUBLIC_KEY, $key, $default);
    }

    protected function get(string $visibility, string $key, mixed $default = null): mixed
    {
        return config($visibility . '.' . $key, $default);
    }
}
