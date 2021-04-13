<?php

namespace Helldar\LaravelLangPublisher\Services\Comparators;

use Helldar\LaravelLangPublisher\Contracts\Comparator as Contract;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

abstract class Comparator implements Contract
{
    use Makeable;

    protected $source;

    protected $target;

    protected $excludes = [];

    public function handle(): array
    {
        return array_merge($this->source, $this->target);
    }

    public function source(array $array): Contract
    {
        $this->source = $array;

        return $this;
    }

    public function target(array $array): Contract
    {
        $this->target = $array;

        return $this;
    }

    public function toArray(): array
    {
        $this->split();

        $array    = $this->sort($this->handle());
        $excludes = $this->sort($this->excludes);

        return array_merge($array, $excludes);
    }

    protected function split(): void
    {
        if (! empty($this->excludes)) {
            $this->prepareExcludes();
            $this->ranExcludes();
            $this->extractExcludes();
        }
    }

    protected function ranExcludes(): void
    {
        foreach ($this->excludes as $key => &$value) {
            $value = $this->getFallbackValue($this->source, $this->target, $key);
        }
    }

    protected function extractExcludes(): void
    {
        $keys = array_keys($this->excludes);

        $this->source = Arr::except($this->source, $keys);
        $this->target = Arr::except($this->target, $keys);
    }

    protected function getFallbackValue(array $source, array $target, string $key): array
    {
        return Arr::get($target, $key) ?: Arr::get($source, $key, []);
    }

    protected function sort(array $array): array
    {
        return Arr::ksort($array);
    }

    protected function prepareExcludes(): void
    {
        $this->excludes = array_flip($this->excludes);
    }
}
