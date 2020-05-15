<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config;
use Illuminate\Support\Facades\File;

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
        $locales   = $this->get($this->getInstalledDirectories());
        $available = $this->available();

        return array_filter($locales, function ($locale) use ($available) {
            return in_array($locale, $available);
        });
    }

    /**
     * Retrieving a list of protected locales.
     *
     * @return array
     */
    public function protects(): array
    {
        return ArrFacade::unique([
            $this->getDefault(),
            $this->getFallback(),
        ]);
    }

    /**
     * Checks if a language pack is installed.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isAvailable(string $locale): bool
    {
        return in_array($locale, $this->available(), true);
    }

    /**
     * Checks whether it is possible to install the language pack.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isInstalled(string $locale): bool
    {
        return in_array($locale, $this->installed(), true);
    }

    /**
     * The checked locale protecting.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isProtected(string $locale): bool
    {
        return $locale === $this->getDefault() || $locale === $this->getFallback();
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
