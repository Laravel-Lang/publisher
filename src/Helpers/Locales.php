<?php

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
            ->push(...$directories)
            ->push(...$files)
            ->push(...$this->protects())
            ->unique()
            ->filter(static fn (string $locale) => $this->isAvailable($locale))
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

    public function isAvailable(?string $locale): bool
    {
        return ! empty($locale) && in_array($locale, $this->available());
    }

    public function isInstalled(?string $locale): bool
    {
        return ! empty($locale) && in_array($locale, $this->installed());
    }

    public function isProtected(?string $locale): bool
    {
        return ! empty($locale) && in_array($locale, $this->protects());
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
}
