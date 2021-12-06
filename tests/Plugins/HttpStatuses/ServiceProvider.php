<?php

declare(strict_types=1);

namespace Tests\Plugins\HttpStatuses;

use LaravelLang\Lang\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected function getProvider(): string
    {
        return Provider::class;
    }
}
