<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class Fortify extends Package
{
    public function vendor(): string
    {
        return 'laravel/fortify';
    }

    public function source(): string
    {
        return 'packages/fortify.json';
    }
}
