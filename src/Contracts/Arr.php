<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use Closure;

interface Arr
{
    public function unique(array $array): array;

    public function first(array $array);

    public function keys(array $array): array;

    public function transform(array $array, Closure $callback): array;
}
