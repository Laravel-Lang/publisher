<?php

namespace Tests\Fixtures\Plugin\src\Plugins;

use LaravelLang\Publisher\Plugins\Plugin;

class Bar extends Plugin
{
    public function vendor(): ?string
    {
        return 'illuminate/support';
    }

    public function files(): array
    {
        return [
            'bar.json' => '{locale}.json',
        ];
    }
}
