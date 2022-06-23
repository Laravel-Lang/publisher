<?php

declare(strict_types=1);

namespace Tests\Fixtures\Plugin\src;

use LaravelLang\Publisher\Plugins\Provider;
use Tests\Fixtures\Plugin\src\Plugins\Baq;
use Tests\Fixtures\Plugin\src\Plugins\Bar;
use Tests\Fixtures\Plugin\src\Plugins\Baw;
use Tests\Fixtures\Plugin\src\Plugins\Foo;

class Plugin extends Provider
{
    protected string $base_path = __DIR__ . '/../../';

    protected array $plugins = [
        Foo::class,
        Bar::class,
        Baq::class,
        Baw::class,
    ];
}
