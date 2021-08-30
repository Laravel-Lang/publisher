<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

class Nova extends BasePlugin
{
    public function vendor(): string
    {
        return 'laravel/nova';
    }

    public function source(): array
    {
        return ['packages/nova.json'];
    }

    public function target(): string
    {
        return 'vendor/nova/{locale}.json';
    }
}
