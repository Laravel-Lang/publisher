<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Config as ConfigContract;
use Helldar\PrettyArray\Contracts\Caseable;

class Config implements ConfigContract
{
    protected $key = 'lang-publisher';

    public function getVendorPath(): string
    {
        return $this->config('vendor');
    }

    public function isAlignment(): bool
    {
        return (bool) $this->config('alignment', true);
    }

    public function getExclude(string $key, array $default = []): array
    {
        $exclude = $this->config('exclude', []);

        return $exclude[$key] ?? $default;
    }

    public function getCase(): int
    {
        return $this->config('case', Caseable::NO_CASE);
    }

    protected function config(string $key, $default = null)
    {
        $key = $this->key($key);

        return \config($key, $default);
    }

    protected function key(string $key): string
    {
        return $this->key . '.' . $key;
    }
}
