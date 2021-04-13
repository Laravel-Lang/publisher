<?php

namespace Helldar\LaravelLangPublisher\Services\Comparators;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Comparator as Contract;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

abstract class Comparator implements Contract
{
    use Logger;
    use Makeable;

    protected $source;

    protected $target;

    protected $excludes = [];

    public function handle(): array
    {
        $this->log('Merging source and target arrays...');

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

        $this->log('Merging the main array with excluded data...');

        return array_merge($array, $excludes);
    }

    protected function split(): void
    {
        $this->log('Splitting main arrays into excludes...');

        if (! empty($this->excludes)) {
            $this->prepareExcludes();
            $this->ranExcludes();
            $this->extractExcludes();
        }
    }

    protected function ranExcludes(): void
    {
        $this->log('Retrieving values from arrays...');

        foreach ($this->excludes as $key => &$value) {
            $value = $this->getFallbackValue($this->source, $this->target, $key);
        }
    }

    protected function extractExcludes(): void
    {
        $this->log('Extracting extended data from source and target arrays ...');

        $keys = array_keys($this->excludes);

        $this->source = Arr::except($this->source, $keys);
        $this->target = Arr::except($this->target, $keys);
    }

    protected function getFallbackValue(array $source, array $target, string $key): array
    {
        $this->log('Retrieving values from arrays by the "' . $key . '" key...');

        return Arr::get($target, $key) ?: Arr::get($source, $key, []);
    }

    protected function sort(array $array): array
    {
        $this->log('Sorting array...');

        return Arr::ksort($array);
    }

    protected function prepareExcludes(): void
    {
        $this->log('Exchanges all keys with their associated values in an array...');

        $this->excludes = array_flip($this->excludes);
    }
}