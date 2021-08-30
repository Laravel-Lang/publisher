<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

class Fortify extends BasePlugin
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
