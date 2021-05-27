<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Breeze extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/breeze';
    }

    public function source(): array
    {
        return [
            'packages/fortify.json',
            'packages/jetstream.json',
        ];
    }
}
