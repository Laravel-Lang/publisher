<?php

namespace Helldar\LaravelLangPublisher\Support\Path;

use Helldar\LaravelLangPublisher\Constants\Locales;
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
        return $locale === Locales::ENGLISH
            ? '/script/en/'
            : ($this->is_json ? '/json/' : '/src/' . $locale);
    }
}
