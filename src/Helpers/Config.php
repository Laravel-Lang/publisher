<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Contracts\LangPublisher\Provider;
use DragonCode\Support\Facades\Helpers\Ables\Arrayable;
use DragonCode\Support\Facades\Helpers\Instance;
use Illuminate\Support\Facades\Config as Illuminate;
use LaravelLang\Publisher\Constants\Config as ConfigConst;
use LaravelLang\Publisher\Exceptions\UnknownPluginInstanceException;

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
        $public = $this->getPrivate('plugins', []);

        return Arrayable::of($public)
            ->unique()
            ->values()
            ->map(static function (string $plugin) {
                if (Instance::of($plugin, Provider::class)) {
                    return new $plugin();
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

    public function privateKey(string $suffix): string
    {
        return ConfigConst::PRIVATE_KEY . '.' . $suffix;
    }

    public function publicKey(string $suffix): string
    {
        return ConfigConst::PUBLIC_KEY . '.' . $suffix;
    }

    protected function getPrivate(string $key, $default = null)
    {
        $key = $this->privateKey($key);

        return Illuminate::get($key, $default);
    }

    protected function getPublic(string $key, $default = null)
    {
        $key = $this->publicKey($key);

        return Illuminate::get($key, $default);
    }
}
