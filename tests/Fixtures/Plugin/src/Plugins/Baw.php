<?php

declare(strict_types=1);

namespace Tests\Fixtures\Plugin\src\Plugins;

use LaravelLang\Publisher\Plugins\Plugin;

class Baw extends Plugin
{
    public function vendor(): ?string
    {
        return 'orchestra/testbench';
    }

    public function version(): string
    {
        return '^4.0 || >999.*';
    }

    public function files(): array
    {
        return [
            'baw.json' => '{locale}.json',
        ];
    }
}
