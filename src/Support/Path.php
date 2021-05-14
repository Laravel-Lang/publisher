<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

final class Path
{
    use Logger;

    public function source(string $package, string $locale): string
    {
        $this->log('Getting the path to the source files of the localization:', $package, $locale);

        if ($this->isEnglish($locale)) {
            return $this->cleanable($this->getBasePath(), $package, $this->getSourcePath());
        }

        return $this->locales($package, $locale);
    }

    public function target(string $locale, bool $is_json = false): string
    {
        $this->log('Getting the path to the target files of the localization:', $locale, $is_json);

        $path = $this->getTargetPath();

        $suffix = $is_json ? '' : '/' . $locale;

        return $this->clean($path) . $suffix;
    }

    public function targetFull(string $locale, ?string $filename, bool $is_json = false): string
    {
        $this->log('Getting the full path to the target files of the localization:', $locale, $filename, $is_json);

        $suffix = $is_json ? '../' . $locale . '.json' : $filename;

        return $this->target($locale) . '/' . $suffix;
    }

    public function locales(string $package, string $locale = null): string
    {
        $this->log('Getting the path to the source translation files for', $package, $locale);

        return $this->cleanable($this->getBasePath(), $package, $this->getLocalesPath(), $locale);
    }

    public function filename(string $path): string
    {
        $this->log('Getting file name without extension and path:', $path);

        $path = pathinfo($path, PATHINFO_FILENAME);

        return $this->clean($path);
    }

    public function extension(string $path): string
    {
        $this->log('Getting file extension from path:', $path);

        $path = pathinfo($path, PATHINFO_EXTENSION);

        return $this->clean($path);
    }

    protected function cleanable(...$values): string
    {
        $this->log('Cleaning values to compile a path:', $values);

        foreach ($values as &$value) {
            $value = $this->clean($value);
        }

        return implode('/', $values);
    }

    protected function clean(string $path = null): ?string
    {
        $this->log('Clearing the path from the trailing character:', $path);

        return ! empty($path) ? rtrim($path, '\\/') : $path;
    }

    protected function isEnglish(string $locale): bool
    {
        $this->log('Check if localization is English: ' . $locale);

        return $locale === LocalesList::ENGLISH;
    }

    protected function getBasePath(): string
    {
        return ConfigFacade::basePath();
    }

    protected function getSourcePath(): string
    {
        return ConfigFacade::sourcePath();
    }

    protected function getLocalesPath(): string
    {
        return ConfigFacade::localesPath();
    }

    protected function getTargetPath(): string
    {
        return ConfigFacade::resourcesPath();
    }
}
