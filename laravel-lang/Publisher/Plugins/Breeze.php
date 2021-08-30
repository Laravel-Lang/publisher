<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Breeze extends BasePlugin
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
