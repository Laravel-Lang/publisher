<?php

/*
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

namespace LaravelLang\Publisher\Helpers;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCodes;

class Locales
{
    public function __construct(
        protected Config $config = new Config()
    ) {
    }

    public function available(): array
    {
        return Arr::sort(LocaleCodes::values());
    }

    public function installed(): array
    {
        $directories = Directory::names($this->config->resourcesPath());
        $files       = File::names($this->config->resourcesPath());

        return Arr::of([])
            ->push($directories)
            ->push($files)
            ->push($this->protects())
            ->flatten()
            ->unique()
            ->filter(fn (string $locale) => $this->isAvailable($locale))
            ->sort()
            ->values()
            ->toArray();
    }

    public function protects(): array
    {
        return Arr::of([
            $this->getDefault(),
            $this->getFallback(),
        ])->unique()->sort()->toArray();
    }

    public function isAvailable(LocaleCodes|string|null $locale): bool
    {
        return $this->inArray($locale, $this->available());
    }

    public function isInstalled(LocaleCodes|string|null $locale): bool
    {
        return $this->inArray($locale, $this->installed());
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
        return $locale instanceof LocaleCodes ? $locale->value : $locale;
    }
}
