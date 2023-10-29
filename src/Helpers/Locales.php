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

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use LaravelLang\Publisher\Concerns\Aliases;
use LaravelLang\Publisher\Constants\Locales as LocaleCodes;

class Locales
{
    use Aliases;

    public function __construct(
        protected Config $config,
        readonly protected Arr $arr = new Arr()
    ) {}

    public function available(): array
    {
        return $this->arr->of(LocaleCodes::values())
            ->sort()
            ->values()
            ->toArray();
    }

    public function installed(): array
    {
        $this->ensureLangPath();

        return $this->arr->of([])
            ->push($this->getDirectories())
            ->push($this->getFiles())
            ->push($this->protects())
            ->flatten()
            ->map(static fn (string $name) => Path::filename($name))
            ->unique()
            ->filter(fn (string $locale) => $this->isAvailable($locale))
            ->sort()
            ->values()
            ->toArray();
    }

    public function installedWithoutProtects(): array
    {
        return array_values(array_diff($this->installed(), $this->protects()));
    }

    public function notInstalled(): array
    {
        return array_values(array_diff($this->available(), $this->installed()));
    }

    public function protects(): array
    {
        return $this->arr->of([
            $this->getDefault(),
            $this->getFallback(),
        ])->unique()->sort()->values()->toArray();
    }

    public function isAvailable(LocaleCodes|string|null $locale): bool
    {
        $locales = $this->available();

        return $this->inArray($locale, $locales)
            || $this->inArray($this->fromAlias($locale, $this->config), $locales);
    }

    public function isInstalled(LocaleCodes|string|null $locale): bool
    {
        $locales = $this->installed();

        return $this->inArray($locale, $locales)
            || $this->inArray($this->fromAlias($locale, $this->config), $locales)
            || $this->inArray($this->toAlias($locale, $this->config), $locales);
    }

    public function isProtected(LocaleCodes|string|null $locale): bool
    {
        return $this->inArray($locale, $this->protects());
    }

    public function getDefault(): string
    {
        $locale = config('app.locale');

        return $this->isAvailable($locale) ? $locale : LocaleCodes::ENGLISH->value;
    }

    public function getFallback(): string
    {
        if ($locale = config('app.fallback_locale')) {
            return $this->isAvailable($locale) ? $locale : $this->getDefault();
        }

        return $this->getDefault();
    }

    protected function inArray(LocaleCodes|string|null $locale, array $haystack): bool
    {
        $locale = $this->toString($locale);

        return ! empty($locale) && in_array($locale, $haystack);
    }

    protected function toString(LocaleCodes|string|null $locale): ?string
    {
        return $locale?->value ?? $locale;
    }

    protected function getDirectories(): array
    {
        return Directory::names($this->config->langPath());
    }

    protected function getFiles(): array
    {
        return File::names($this->config->langPath(), recursive: true);
    }

    protected function ensureLangPath(): void
    {
        Directory::ensureDirectory($this->config->langPath());
    }
}
