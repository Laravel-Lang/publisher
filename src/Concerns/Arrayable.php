<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Support\Facades\Helpers\Arr;

trait Arrayable
{
    protected function combine(array ...$arrays): array
    {
        return Arr::combine($arrays);
    }

    protected function merge(array ...$arrays): array
    {
        return Arr::merge(...$arrays);
    }

    protected function sort(array $array): array
    {
        return Arr::ksort($array);
    }

    protected function sortAndMerge(array ...$arrays): array
    {
        $array = $this->merge(...$arrays);

        return $this->sort($array);
    }
}
