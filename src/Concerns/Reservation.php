<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\Support\Facades\Helpers\Arr;

trait Reservation
{
    protected function reserved(array $target, string $key): array
    {
        $this->log('Getting the elements of the reserved keys from the general array. Key is', $key);

        $excludes = $this->excludesByKey($key);

        return Arr::only($target, $excludes);
    }

    protected function excludesByKey(string $key): array
    {
        $this->log('Getting a list of reserved keys from a configuration:', $key);

        return Arr::get(Config::excludes(), $key, []);
    }
}
