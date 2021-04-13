<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\Support\Facades\Helpers\Arr;

trait Reservation
{
    protected function reserved(array $target, string $key): array
    {
        $excludes = $this->excludesByKey($key);

        return Arr::only($target, $excludes);
    }

    protected function excludesByKey(string $key): array
    {
        return Arr::get(Config::excludes(), $key, []);
    }
}
