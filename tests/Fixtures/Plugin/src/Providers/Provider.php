<?php

namespace Tests\Fixtures\Plugin\src\Providers;

use LaravelLang\Publisher\Plugins\Provider as BaseProvider;
use Tests\Fixtures\Plugin\src\Plugins\Baq;
use Tests\Fixtures\Plugin\src\Plugins\Bar;
use Tests\Fixtures\Plugin\src\Plugins\Foo;

class Provider extends BaseProvider
{
    public function basePath(): string
    {
        return __DIR__ . '/../../';
    }

    public function plugins(): array
    {
        return $this->resolvePlugins([
            Foo::class,
            Bar::class,
            Baq::class,
        ]);
    }
}
