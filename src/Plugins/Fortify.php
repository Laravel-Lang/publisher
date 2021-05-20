<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Fortify extends Plugin
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
