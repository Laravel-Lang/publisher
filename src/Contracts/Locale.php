<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Locale
{
    public function available(): array;

    public function installed(): array;
}
