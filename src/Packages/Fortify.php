<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class Fortify extends Package
{
    public function vendor(): string
    {
        return 'laravel/fortify';
    }

    public function source(): array
    {
        return ['packages/fortify.json'];
    }
}
