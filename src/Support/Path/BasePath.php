<?php

namespace Helldar\LaravelLangPublisher\Support\Path;

use Helldar\LaravelLangPublisher\Contracts\Pathable;

abstract class BasePath implements Pathable
{
    protected $is_json = false;

    protected function real(string $path): string
    {
        return realpath($path);
    }

    protected function clean(string $path = null): ?string
    {
        return $path
            ? static::DIVIDER . ltrim($path, ' \\/')
            : $path;
    }

    protected function getPathForEnglish(string $locale): string
    {
        if ($this->is_json) {
            return $locale === 'en'
                ? '/script/en/'
                : '/json/';
        }

        return $locale === 'en'
            ? '/script/en/'
            : '/src/' . $locale;
    }
}
