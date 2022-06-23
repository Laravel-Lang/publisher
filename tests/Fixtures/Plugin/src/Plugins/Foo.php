<?php

namespace Tests\Fixtures\Plugin\src\Plugins;

use LaravelLang\Publisher\Plugins\Plugin;

class Foo extends Plugin
{
    public function files(): array
    {
        return [
            'foo.json' => '{locale}.json',

            'validation.php' => '{locale}/validation.php',
        ];
    }
}
