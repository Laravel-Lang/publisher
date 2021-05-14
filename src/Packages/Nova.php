<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class Nova extends Package
{
    public function vendor(): string
    {
        return 'laravel/nova';
    }

    public function source(): string
    {
        return 'packages/nova.json';
    }

    public function target(): string
    {
        return 'vendor/nova';
    }
}
