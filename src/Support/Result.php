<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Facades\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class Result
{
    /** @var \Illuminate\Console\Command */
    protected $output;

    protected $items = [];

    protected $message = 'No Data';

    public function setOutput(Command $output): self
    {
        $this->output = $output;

        return $this;
    }

    public function setMessage(string $no_data): self
    {
        $this->message = $no_data;

        return $this;
    }

    public function show()
    {
        empty($this->items) ? $this->warn() : $this->table();
    }

    public function merge(array $items): void
    {
        $this->items = array_merge($this->items, $items);
    }

    protected function warn(): void
    {
        $this->output->warn($this->message);
    }

    protected function table(): void
    {
        $this->output->table($this->headers(), $this->items());
    }

    protected function headers(): array
    {
        $item = Arr::first($this->items);
        $keys = Arr::keys($item);

        return Arr::transform($keys, function ($value) {
            return Str::title($value);
        });
    }

    protected function items(): array
    {
        return $this->items;
    }
}
