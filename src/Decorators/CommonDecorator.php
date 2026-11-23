<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Decorators;

use LaravelLang\Publisher\Contracts\Decorator;

class CommonDecorator implements Decorator
{
    public function convert(string $locale, bool|float|int|string|null $value): string
    {
        return (string) $value;
    }
}
