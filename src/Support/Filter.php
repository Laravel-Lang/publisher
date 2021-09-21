<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\Support\Facades\Helpers\Arr;

class Filter
{
    protected $source = [];

    protected $translated = [];

    public function keys(array $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function translated(array $array): self
    {
        $this->translated = $array;

        return $this;
    }

    public function get(): array
    {
        foreach ($this->translated as $filename => $values) {
            $this->translated[$filename] = $this->only($values);
        }

        return $this->translated;
    }

    protected function only(array $values): array
    {
        return Arr::only($values, $this->source);
    }
}
