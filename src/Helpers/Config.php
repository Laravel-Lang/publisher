<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Contracts\Support\Stringable;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Concerns\Aliases;
use LaravelLang\Locales\Enums\Config as ConfigEnum;
use LaravelLang\Publisher\Constants\Types;

class Config
{
    use Aliases;

    public function __construct(
        readonly protected Arr $arr = new Arr()
    ) {}

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

    public function getPackages(): array
    {
        return $this->getPrivate('packages', []);
    }

    public function getPackageNameByPath(string $path, Types $type = Types::TypeName): string
    {
        $path = realpath($path);

        return $this->getPackages()[$path][$type->value] ?? $path;
    }

    public function setPackage(string $base_path, string $plugin_class, string $package_name): void
    {
        $items = $this->getPackages();

        $items[$base_path] = [
            'class' => $plugin_class,
            'name'  => $package_name,
        ];

        $this->setPrivate('packages', $items);
    }

    public function langPath(Locale|string|null ...$paths): string
    {
        $path = collect($paths)
            ->filter()
            ->map(fn (Locale|string $value) => $this->toAlias($value))
            ->implode('/');

        return $this->path(lang_path(), $path);
    }

    public function hasInline(): bool
    {
        return $this->getPublic('inline', false);
    }

    public function hasAlign(): bool
    {
        return $this->getPublic('align', true);
    }

    public function hasSmartPunctuation(): bool
    {
        return $this->getPublic('smart_punctuation.enable', false);
    }

    public function smartPunctuationConfig(string $locale): array
    {
        $default = $this->getPublic('smart_punctuation.common', []);

        return $this->getPublic('smart_punctuation.locales.' . $locale, $default);
    }

    public function setPrivate(string $key, mixed $value): void
    {
        $this->set(ConfigEnum::PrivateKey(), $key, $value);
    }

    protected function getPrivate(string $key, mixed $default = null): mixed
    {
        return $this->get(ConfigEnum::PrivateKey(), $key, $default);
    }

    protected function getPublic(string $key, mixed $default = null): mixed
    {
        return $this->get(ConfigEnum::PublicKey(), $key, $default);
    }

    protected function get(string $visibility, string $key, mixed $default = null): mixed
    {
        return config()->get($visibility . '.' . $key, $default);
    }

    protected function set(string $visibility, string $key, mixed $value): void
    {
        config()->set($visibility . '.' . $key, $value);
    }

    protected function path(string $base, string|Stringable|null $suffix = null): string
    {
        return rtrim($base, '\\/') . '/' . ltrim((string) $suffix, '\\/');
    }
}
