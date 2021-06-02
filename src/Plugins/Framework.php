<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Framework extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/framework';
    }

    public function source(): array
    {
        return [
            'en.json',
        ];
    }
}
