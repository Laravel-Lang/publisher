<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config;
use Illuminate\Support\Facades\File;

use function array_map;
use function array_push;
use function resource_path;

final class Locale implements LocaleContract
{
    /**
     * List of available locations.
     *
     * @return array
     */
    public function available(): array
    {
        return $this->get($this->getSourceDirectories());
    }

    /**
     * List of installed locations.
     *
     * @return array
     */
    public function installed(): array
    {
        return $this->get($this->getInstalledDirectories());
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function getDefault(): string
    {
        return Config::getLocale();
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function getFallback(): string
    {
        return Config::getFallbackLocale();
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
        return ArrFacade::unique($locales);
    }
}
