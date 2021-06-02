<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Lumen extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/lumen-framework';
    }

    public function source(): array
    {
        return [
            'en.json',
        ];
    }
}
