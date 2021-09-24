<?php

declare(strict_types=1);

namespace Tests\Providers;

use LaravelLang\Lang\Publisher\Provider as LaravelLang;

class Provider extends LaravelLang
{
    public function basePath(): string
    {
        return __DIR__ . '/../../vendor/laravel-lang/lang';
    }
}
