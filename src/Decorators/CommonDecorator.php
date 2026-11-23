<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Decorators;

use LaravelLang\Publisher\Contracts\Decorator;

class CommonDecorator implements Decorator
{
    public function convert(string $locale, float|null|bool|int|string $value): string
    {
        return (string) $value;
    }
}
