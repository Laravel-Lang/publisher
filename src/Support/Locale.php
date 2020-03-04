<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Helldar\LaravelLangPublisher\Facades\Config;
use Illuminate\Support\Facades\File;

use function array_map;
use function array_push;
use function array_unique;
use function array_values;
use function resource_path;

class Locale implements LocaleContract
{
    public function available(): array
    {
        return $this->get($this->getSourceDirectories());
    }

    public function installed(): array
    {
        return $this->get($this->getInstalledDirectories());
    }

    protected function get(array $directories): array
    {
        $locales = $this->normalizeNames($directories);

        $this->addDefaultLocale($locales);

        return $this->filterLocales($locales);
    }

    protected function getSourceDirectories(): array
    {
        return File::directories(
            Config::getVendorPath()
        );
    }

    protected function getInstalledDirectories(): array
    {
        return File::directories(
            resource_path('lang')
        );
    }

    protected function normalizeNames(array $directories): array
    {
        return array_map(function ($dir) {
            return File::name($dir);
        }, $directories);
    }

    protected function addDefaultLocale(array &$locales): void
    {
        array_push($locales, Config::getLocale());
    }

    protected function filterLocales(array $locales): array
    {
        return array_values(array_unique($locales));
    }
}
