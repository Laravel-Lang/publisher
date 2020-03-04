<?php

namespace Helldar\LaravelLangPublisher\Support;

use function array_filter;
use function array_unique;
use function array_values;
use Helldar\LaravelLangPublisher\Contracts\Arr as ArrContract;

class Arr implements ArrContract
{
    public function unique(array $array): array
    {
        return array_values(array_filter(array_unique($array)));
    }
}
