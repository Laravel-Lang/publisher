<?php

namespace Helldar\LaravelLangPublisher\Services\Comparators;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Reservation;
use Helldar\LaravelLangPublisher\Contracts\Comparator as Contract;
use Helldar\LaravelLangPublisher\Facades\ArrayProcessor;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

abstract class Comparator implements Contract
{
    use Logger;
    use Makeable;
    use Reservation;

    protected $key;

    protected $full = false;

    protected $source;

    protected $target;

    protected $excludes = [];

    protected $not_replace = [];

    public function handle(): array
    {
        $this->log('Merging source and target arrays...');

        if ($this->full) {
            return $this->source;
        }

        return ArrayProcessor::keysAsString()
            ->of($this->target)
            ->merge($this->source)
            ->merge($this->not_replace)
            ->toArray();
    }

    public function key(string $key): Contract
    {
        $this->key = $key;

        return $this;
    }

    public function full(bool $full): Contract
    {
        $this->full = $full;

        return $this;
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
        $this->findNotReplace();
        $this->splitNotSortable();

        $array    = $this->sort($this->handle());
        $excludes = $this->sort($this->excludes);

        $this->log('Merging the main array with excluded data...');

        return ArrayProcessor::of($array)
            ->merge($excludes)
            ->toArray();
    }

    protected function splitNotSortable(): void
    {
        $this->log('Splitting main arrays into excludes...');

        if (! empty($this->excludes)) {
            $this->ranExcludes();
            $this->extractExcludes();
        }
    }

    protected function findNotReplace(): void
    {
        if ($this->full) {
            return;
        }

        $this->not_replace = $this->reserved($this->target, $this->key);
    }

    protected function ranExcludes(): void
    {
        $this->log('Retrieving values from arrays...');

        $this->excludes = $this->getExcludedValues($this->source, $this->target, $this->excludes);
    }

    protected function extractExcludes(): void
    {
        $this->log('Extracting extended data from source and target arrays ...');

        $keys = array_keys($this->excludes);

        $this->source = Arr::except($this->source, $keys);
        $this->target = Arr::except($this->target, $keys);
    }

    protected function getExcludedValues(array $source, array $target, array $keys): array
    {
        $this->log('Retrieving values from arrays by the "' . implode('", "', $keys) . '" key...');

        $excluded_source = Arr::only($source, $keys);
        $excluded_target = Arr::only($target, $keys);

        return ArrayProcessor::of($excluded_target)
            ->merge($excluded_source)
            ->toArray();
    }

    protected function sort(array $array): array
    {
        $this->log('Sorting array...');

        return Arr::ksort($array);
    }
}
