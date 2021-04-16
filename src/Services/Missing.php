<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\ArrayProcessor;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

final class Missing
{
    use Logger;
    use Makeable;
    use Pathable;

    protected $locale = LocalesList::ENGLISH;

    public function missing(string $package): array
    {
        return array_diff($this->packageable($package), $this->available());
    }

    public function unnecessary(string $package): array
    {
        return array_diff($this->available(), $this->packageable($package));
    }

    protected function available(): array
    {
        return Locales::available(true);
    }

    protected function packageable(string $package): array
    {
        $items = $this->locales($package);

        return ArrayProcessor::of($items)
            ->push($this->defaultLocale())
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    protected function defaultLocale(): string
    {
        return LocalesList::ENGLISH;
    }

    protected function locales(string $package): array
    {
        $path = $this->path($package);

        return Directory::names($path);
    }

    protected function path(string $package): string
    {
        return $this->pathLocales($package);
    }
}
