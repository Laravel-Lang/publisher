<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Helpers;

use LaravelLang\Config\Services\AliasConfig;
use LaravelLang\Config\Services\PrivateConfig;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Publisher\Constants\Types;
use Stringable;

class Config
{
    public function __construct(
        protected readonly Arr $arr,
        protected AliasConfig $alias,
    ) {}

    public function getPlugins(): array
    {
        return app(PrivateConfig::class)->plugins;
    }

    public function setPlugins(string $path, array $plugins): void
    {
        config()->set('localization_private.plugins.' . $path, $plugins);
    }

    public function getPackages(): array
    {
        return app(PrivateConfig::class)->packages;
    }

    public function getPackageNameByPath(string $path, Types $type = Types::TypeName): string
    {
        $path = realpath($path);

        return $this->getPackages()[$path][$type->value] ?? $path;
    }

    public function setPackage(string $base_path, string $plugin_class, string $package_name): void
    {
        config()->set('localization_private.packages.' . $base_path, [
            'class' => $plugin_class,
            'name'  => $package_name,
        ]);
    }

    public function langPath(Locale|string|null ...$paths): string
    {
        $path = collect($paths)
            ->filter()
            ->map(fn (Locale|string $value) => $this->alias->from($value))
            ->implode('/');

        return $this->path(lang_path(), $path);
    }

    protected function path(string $base, string|Stringable|null $suffix = null): string
    {
        return rtrim($base, '\\/') . '/' . ltrim((string) $suffix, '\\/');
    }
}
