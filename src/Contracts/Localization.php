<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Localization
{
    public function publish(string $locale, bool $force = false): array;

    public function delete(string $locale): array;
}
