<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Comparator extends Arrayable
{
    public function key(string $key): self;

    public function force(bool $force): self;

    public function source(array $array): self;

    public function target(array $array): self;
}
