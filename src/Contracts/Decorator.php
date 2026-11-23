<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Contracts;

interface Decorator
{
    public function convert(string $locale, bool|int|string $value): bool|int|string;
}
