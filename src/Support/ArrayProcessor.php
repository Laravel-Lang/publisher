<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Illuminate\Contracts\Support\Arrayable;

final class ArrayProcessor implements Arrayable
{
    use Logger;

    protected $items = [];

    protected $keys_as_string = false;

    public function keysAsString(): self
    {
        $this->keys_as_string = true;

        return $this;
    }

    public function of(array $items): self
    {
        $this->items = $this->stringingKeys($items);

        return $this;
    }

    public function push($value): self
    {
        $this->log('Adding an item to an array...');

        array_push($this->items, $value);

        return $this;
    }

    public function merge(array $array): self
    {
        $this->log('Merging arrays with string conversion...');

        $array = $this->stringingKeys($array);

        foreach ($array as $key => $value) {
            $this->items[$key] = is_array($value) ? array_merge($this->items[$key] ?? [], $value) : $value;
        }

        return $this;
    }

    public function unique(): self
    {
        $this->log('Filtering an array by unique values...');

        $this->items = array_unique($this->items);

        return $this;
    }

    public function values(): self
    {
        $this->log('Retrieving array values without keys...');

        $this->items = array_values($this->items);

        return $this;
    }

    public function sort(): self
    {
        $this->log('Sorting array values...');

        $this->items = ArrHelper::sort($this->items);

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    protected function stringingKeys(array $array): array
    {
        $this->log('Converting array keys to string type...');

        if (! $this->keys_as_string) {
            $this->log('Conversion of array keys to string type is disabled.');

            return $array;
        }

        return ArrHelper::renameKeys($array, static function ($key) {
            return (string) $key;
        });
    }
}
