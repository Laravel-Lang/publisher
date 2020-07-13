<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Pathable
{
    public const DIVIDER = DIRECTORY_SEPARATOR;

    public const LANG = 'lang';

    public function source(string $locale = null): string;

    public function target(string $locale = null, string $filename = null): string;
}
