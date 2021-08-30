<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Config;

use Helldar\LaravelLangPublisher\Constants\Config as ConfigConst;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Instance;

class Config
{
    public function vendor(): string
    {
        return $this->getPrivate('path.base');
    }

    public function resources(): string
    {
        return $this->getPrivate('path.resources');
    }

    public function plugins(): array
    {
        $private = $this->getPrivate('plugins');
        $public  = $this->getPublic('plugins');

        return Arrayable::of($public)
            ->merge($private)
            ->unique()
            ->filter(static function (string $plugin) {
                return Instance::exists($plugin);
            })
            ->sort()
            ->get();
    }

    public function hasInline(): bool
    {
        return $this->getPublic('inline');
    }

    public function hasAlignment(): bool
    {
        return $this->getPublic('alignment');
    }

    public function excludes(): array
    {
        return $this->getPublic('excludes');
    }

    public function case(): int
    {
        return $this->getPublic('case');
    }

    protected function getPrivate(string $key)
    {
        $key = $this->privateKey($key);

        return config($key);
    }

    protected function getPublic(string $key)
    {
        $key = $this->publicKey($key);

        return config($key);
    }

    protected function privateKey(string $suffix): string
    {
        return ConfigConst::PRIVATE_KEY . '.' . $suffix;
    }

    protected function publicKey(string $suffix): string
    {
        return ConfigConst::PUBLIC_KEY . '.' . $suffix;
    }
}
