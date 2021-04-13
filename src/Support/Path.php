<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

final class Path
{
    public function source(string $locale): string
    {
        if ($this->isEnglish($locale)) {
            return ConfigFacade::basePath();
        }

        return $this->locales($locale);
    }

    public function target(string $locale, bool $is_json = false): string
    {
        $path = ConfigFacade::resourcesPath();

        $suffix = $is_json ? '' : $locale;

        return $this->clean($path) . $suffix;
    }

    public function locales(string $locale = null): string
    {
        $path = ConfigFacade::localesPath();

        return $this->clean($path) . '/' . $locale;
    }

    public function filename(string $path): string
    {
        $path = pathinfo($path, PATHINFO_FILENAME);

        return $this->clean($path);
    }

    public function directory(string $path): string
    {
        $path = pathinfo($path, PATHINFO_DIRNAME);

        return $this->clean($path);
    }

    public function extension(string $path): string
    {
        $path = pathinfo($path, PATHINFO_EXTENSION);

        return $this->clean($path);
    }

    protected function clean(string $path = null): ?string
    {
        return ! empty($path) ? rtrim($path, '\\/') : $path;
    }

    protected function isEnglish(string $locale): bool
    {
        return $locale === LocalesList::ENGLISH;
    }
}
