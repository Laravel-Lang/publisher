<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Localization
{
    public function publish(string $locale, bool $force = false): void;

    public function getResult(): array;
}
