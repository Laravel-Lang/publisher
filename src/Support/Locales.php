<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\LaravelLangPublisher\Facades\Reflection as ReflectionFacade;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;

final class Locales
{
    /**
     * List of available locations.
     *
     * @param  bool  $return_all
     *
     * @return array
     */
    public function available(bool $return_all = false): array
    {
        $locales = $this->all();

        return $return_all ? $locales : $this->filter($locales);
    }

    /**
     * List of installed locations.
     *
     * @return array
     */
    public function installed(): array
    {
        $json = File::names($this->resourcesPath());
        $php  = Directory::names($this->resourcesPath());

        $installed = array_unique(array_merge($json, $php));

        $sorted = Arr::sort(array_values($installed));

        return array_values($sorted);
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

    protected function all(): array
    {
        return array_values(ReflectionFacade::getConstants(LocalesList::class));
    }

    protected function filter(array $locales): array
    {
        $unique = array_unique($locales);
        $ignore = ConfigFacade::ignores();

        return array_values(array_filter($unique, static function ($locale) use ($ignore) {
            return ! in_array($locale, $ignore, true);
        }));
    }

    protected function resourcesPath(): string
    {
        return ConfigFacade::resourcesPath();
    }
}
