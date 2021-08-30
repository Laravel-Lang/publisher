<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class Cashier extends BasePlugin
{
    public function vendor(): string
    {
        return 'laravel/cashier';
    }

    public function source(): array
    {
        return ['packages/cashier.json'];
    }
}
