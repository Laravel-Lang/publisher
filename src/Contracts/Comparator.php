<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Comparator extends Arrayable
{
    public function source(array $array): self;

    public function target(array $array): self;
}
