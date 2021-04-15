<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Illuminate\Contracts\Support\Arrayable;

class ArrayProcessor implements Arrayable
{
    protected $items = [];

    public function of(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function push($value): self
    {
        array_push($this->items, $value);

        return $this;
    }

    public function unique(): self
    {
        $this->items = array_unique($this->items);

        return $this;
    }

    public function values(): self
    {
        $this->items = array_values($this->items);

        return $this;
    }

    public function sort(): self
    {
        $this->items = ArrHelper::sort($this->items);

        return $this;
    }

    public function filter(callable $callback): self
    {
        $this->items = array_filter($this->items, $callback);

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
