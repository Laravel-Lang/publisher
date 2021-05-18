<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class Cashier extends Package
{
    public function vendor(): string
    {
        return 'laravel/cashier';
    }

    public function source(): array
    {
        return ['packages/cashier.json'];
    }
}
