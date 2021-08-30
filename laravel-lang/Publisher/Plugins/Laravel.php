<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Laravel extends BasePlugin
{
    public function isJson(): bool
    {
        return false;
    }

    public function vendor(): string
    {
        return 'laravel/framework';
    }

    public function source(): array
    {
        return [
            'auth.php',
            'pagination.php',
            'passwords.php',
            'validation.php',
        ];
    }
}
