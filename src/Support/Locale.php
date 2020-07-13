<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config;
use Illuminate\Support\Facades\File;

final class Locale
{
    /**
     * List of available locations.
     *
     * @param  bool  $is_json
     *
     * @return array
     */
    public function available(bool $is_json = false): array
    {
        return $this->get($this->getSourceDirectories($is_json));
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
        $available = $this->available($is_json);

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
     * @param  bool  $is_json
     *
     * @return bool
     */
    public function isAvailable(string $locale, bool $is_json = false): bool
    {
        return in_array($locale, $this->available($is_json), true);
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

    protected function getSourceDirectories(bool $is_json = false): array
    {
        $vendor = Config::getVendorPath();

        return $is_json
            ? File::files($vendor . '/json')
            : File::directories($vendor . '/src');
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
        return ArrFacade::unique($locales);
    }

    protected function getResourcePath(): string
    {
        return resource_path('lang');
    }
}
