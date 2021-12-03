<?php

declare(strict_types=1);

namespace Tests\Lang;

use LaravelLang\Lang\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected function getProvider(): string
    {
        return Provider::class;
    }
}
