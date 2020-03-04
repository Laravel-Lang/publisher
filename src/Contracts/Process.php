<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Process
{
    /**
     * @param string $locale
     *
     * @return self
     */
    public function locale(string $locale);

    /**
     * @param bool $force
     *
     * @return self
     */
    public function force(bool $force = false);

    public function run(): array;

    public function result(): array;
}
