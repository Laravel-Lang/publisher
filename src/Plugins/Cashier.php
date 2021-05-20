<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Cashier extends Plugin
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
