<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Lumen extends BasePlugin
{
    public function vendor(): string
    {
        return 'laravel/lumen-framework';
    }

    public function files(): array
    {
        return [
            'auth.php'       => '{locale}/auth.php',
            'pagination.php' => '{locale}/pagination.php',
            'passwords.php'  => '{locale}/passwords.php',
            'validation.php' => '{locale}/validation.php',
        ];
    }
}
