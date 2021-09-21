<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Nova extends BasePlugin
{
    public function vendor(): string
    {
        return 'laravel/nova';
    }

    public function files(): array
    {
        return [
            'packages/nova.json' => 'vendor/nova/{locale}.json',
        ];
    }
}
