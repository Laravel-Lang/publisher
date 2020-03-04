<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Arr
{
    public function unique(array $array): array;

    public function first(array $array);

    public function keys(array $array): array;
}
