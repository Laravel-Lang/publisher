<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Localization
{
    /**
     * Publish Localization.
     *
     * @param string $locale
     * @param bool $force
     */
    public function publish(string $locale, bool $force = false): void;

    public function getResult(): array;
}
