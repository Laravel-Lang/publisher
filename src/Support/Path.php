<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

final class Path
{
    use Logger;

    public function source(string $locale): string
    {
        $this->log('Getting the path to the source files of the localization: ' . $locale);

        if ($this->isEnglish($locale)) {
            return ConfigFacade::basePath();
        }

        return $this->locales($locale);
    }

    public function target(string $locale, bool $is_json = false): string
    {
        $this->log('Getting the path to the target files of the localization: ' . $locale);

        $path = ConfigFacade::resourcesPath();

        $suffix = $is_json ? '' : $locale;

        return $this->clean($path) . $suffix;
    }

    public function locales(string $locale = null): string
    {
        $this->log('Getting the path to excluding English localization: ' . $locale);

        $path = ConfigFacade::localesPath();

        return $this->clean($path) . '/' . $locale;
    }

    public function filename(string $path): string
    {
        $this->log('Getting file name without extension and path: ' . $path);

        $path = pathinfo($path, PATHINFO_FILENAME);

        return $this->clean($path);
    }

    public function directory(string $path): string
    {
        $this->log('Getting the path to a directory: ' . $path);

        $path = pathinfo($path, PATHINFO_DIRNAME);

        return $this->clean($path);
    }

    public function extension(string $path): string
    {
        $this->log('Getting file extension from path: ' . $path);

        $path = pathinfo($path, PATHINFO_EXTENSION);

        return $this->clean($path);
    }

    protected function clean(string $path = null): ?string
    {
        $this->log('Clearing the path from the trailing character: ' . $path);

        return ! empty($path) ? rtrim($path, '\\/') : $path;
    }

    protected function isEnglish(string $locale): bool
    {
        $this->log('Check if localization is English: ' . $locale);

        return $locale === LocalesList::ENGLISH;
    }
}
