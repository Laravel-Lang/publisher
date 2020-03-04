<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Locale
{
    public function available(): array;

    public function installed(): array;

    public function getDefault(): string;

    public function getFallback(): string;
}
