<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Helpers;

use Helldar\Contracts\LangPublisher\Provider;
use Helldar\LaravelLangPublisher\Constants\Config as ConfigConst;
use Helldar\LaravelLangPublisher\Exceptions\UnknownPluginInstanceException;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Instance;
use Illuminate\Support\Facades\Config as Illuminate;

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
            ->addUnique($private)
            ->unique()
            ->sort()
            ->values()
            ->map(static function (string $plugin) {
                if (Instance::of($plugin, Provider::class)) {
                    return new $plugin;
                }

                throw new UnknownPluginInstanceException($plugin);
            })->get();
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

        return Illuminate::get($key);
    }

    protected function getPublic(string $key)
    {
        $key = $this->publicKey($key);

        return Illuminate::get($key);
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
