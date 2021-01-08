<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Reflection;
use Illuminate\Support\Facades\File;

final class Locale
{
    /**
     * List of available locations.
     *
     * @return array
     */
    public function available(): array
    {
        return $this->filterLocales($this->availableAll());
    }

    /**
     * Returns a list of all localizations available for installation without filtering.
     *
     * @return array
     */
    public function availableAll(): array
    {
        $available = array_values(
            Reflection::getConstants(Locales::class)
        );

        $this->addDefaultLocale($available);

        return $available;
    }

    /**
     * List of installed locations.
     *
     * @param  bool  $is_json
     *
     * @return array
     */
    public function installed(bool $is_json = false): array
    {
        $locales   = $this->get($this->getInstalledDirectories($is_json));
        $available = $this->available();

        return array_values(array_filter($locales, function ($locale) use ($available) {
            return in_array($locale, $available);
        }));
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
     * @param  bool  $is_json
     *
     * @return bool
     */
    public function isInstalled(string $locale, bool $is_json = false): bool
    {
        return in_array($locale, $this->installed($is_json), true);
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

    protected function getInstalledDirectories(bool $is_json = false): array
    {
        return $is_json
            ? File::files($this->getResourcePath())
            : File::directories($this->getResourcePath());
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
        $unique = ArrFacade::unique($locales);
        $ignore = Config::getIgnore();

        return array_values(array_filter($unique, static function ($locale) use ($ignore) {
            return ! in_array($locale, $ignore);
        }));
    }

    protected function getResourcePath(): string
    {
        return resource_path('lang');
    }
}
