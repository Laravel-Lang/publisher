<?php

declare(strict_types=1);

namespace Tests\Lang;

use LaravelLang\Lang\Provider as BaseProvider;

class Provider extends BaseProvider
{
    public function basePath(): string
    {
        return __DIR__ . '/../../vendor/laravel-lang/lang';
    }
}
