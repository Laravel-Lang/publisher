<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales;

class Config
{
    public const PUBLIC_KEY = 'lang-publisher';

    public const PRIVATE_KEY = 'lang-publisher-private';

    public function getPlugins(): array
    {
        return $this->getPrivate('plugins', []);
    }

    public function setPlugins(string $path, array $plugins): void
    {
        $items = array_merge($this->getPlugins(), [
            $path => $plugins,
        ]);

        $this->setPrivate('plugins', $items);
    }

    public function langPath(Locales|string|null ...$paths): string
    {
        $path = Arr::of($paths)
            ->filter()
            ->map(static fn (Locales|string $value) => $value?->value ?? $value)
            ->implode('/');

        $dir = $this->getPrivate('path');

        return $this->path($dir, $path);
    }

    public function hasInline(): bool
    {
        return $this->getPublic('inline', false);
    }

    public function hasAlign(): bool
    {
        return $this->getPublic('align', true);
    }

    public function setPrivate(string $key, mixed $value): void
    {
        $this->set(self::PRIVATE_KEY, $key, $value);
    }

    protected function getPrivate(string $key, mixed $default = null): mixed
    {
        return $this->get(self::PRIVATE_KEY, $key, $default);
    }

    protected function getPublic(string $key, mixed $default = null): mixed
    {
        return $this->get(self::PUBLIC_KEY, $key, $default);
    }

    protected function get(string $visibility, string $key, mixed $default = null): mixed
    {
        return config()->get($visibility . '.' . $key, $default);
    }

    protected function set(string $visibility, string $key, mixed $value): void
    {
        config()->set($visibility . '.' . $key, $value);
    }

    protected function path(string $base, ?string $suffix = null): string
    {
        return rtrim($base, '\\/') . '/' . ltrim((string) $suffix, '\\/');
    }
}
