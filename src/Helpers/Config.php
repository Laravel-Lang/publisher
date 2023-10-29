<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Contracts\Support\Stringable;
use LaravelLang\Publisher\Concerns\Aliases;
use LaravelLang\Publisher\Constants\Locales;
use LaravelLang\Publisher\Constants\Types;

class Config
{
    use Aliases;

    public const PRIVATE_KEY = 'lang-publisher-private';
    public const PUBLIC_KEY  = 'lang-publisher';

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

    /**
     * @return array<string, string>
     */
    public function getPackages(): array
    {
        return $this->getPrivate('packages', []);
    }

    public function getPackageNameByPath(string $path, Types $type = Types::TYPE_NAME): string
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

    public function langPath(Locales|string|null ...$paths): string
    {
        $path = $this->arr->of($paths)
            ->filter()
            ->map(fn (Locales|string $value) => $this->toAlias($value, $this))
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

    public function getAliases(): array
    {
        return $this->getPublic('aliases', []);
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

    protected function path(string $base, string|Stringable|null $suffix = null): string
    {
        return rtrim($base, '\\/') . '/' . ltrim((string) $suffix, '\\/');
    }
}
