<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\Support\Facades\Helpers\Arr;

class Add extends Base
{
    protected function merge(array $local, array $translated, array $excluded, array $extra_local, array $extra_translated): array
    {
        return Arr::merge($local, $translated, $excluded, $extra_local, $extra_translated);
    }
}
