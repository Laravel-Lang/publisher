<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Keyable;
use Helldar\Support\Facades\Helpers\Arr;

class Filter
{
    use Keyable;

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
        foreach ($this->source as $filename => $keys) {
            $values = $this->translated[$filename];

            $this->translated[$filename] = $this->only($values, $keys);
        }

        return $this->translated;
    }

    protected function only(array $values, array $source): array
    {
        return Arr::only($values, $source);
    }
}
