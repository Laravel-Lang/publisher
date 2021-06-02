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
            '{locale}.json',
            'auth.php',
            'pagination.php',
            'passwords.php',
            'validation.php',
        ];
    }
}
