<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Arr as ArrContract;

use function array_filter;
use function array_unique;
use function array_values;

class Arr implements ArrContract
{
    public function unique(array $array): array
    {
        return array_values(array_filter(array_unique($array)));
    }
}
