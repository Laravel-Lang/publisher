<?php

namespace Helldar\LaravelLangPublisher\Entities;

use function compact;
use Helldar\LaravelLangPublisher\Contracts\Result as ResultContract;
use Helldar\LaravelLangPublisher\Facades\Arr;
use Illuminate\Console\Command;

class Result implements ResultContract
{
    /** @var \Illuminate\Console\Command */
    protected $output;

    protected $items = [];

    protected $message_no_data = 'No Data';

    protected $status_success = 'success';

    protected $status_failed = 'failed';

    public function push(string $locale, bool $result = false): void
    {
        $status = $this->getStatus($result);

        $this->items[] = compact('locale', 'status');
    }

    public function setMessages(string $no_data, string $success = 'success', string $failed = 'failed'): self
    {
        $this->message_no_data = $no_data;
        $this->status_success  = $success;
        $this->status_failed   = $failed;

        return $this;
    }

    public function show()
    {
        empty($this->items) ? $this->warn() : $this->table();
    }

    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function setOutput(Command $output): self
    {
        $this->output = $output;

        return $this;
    }

    protected function warn(): void
    {
        $this->output->warn($this->message_no_data);
    }

    protected function table(): void
    {
        $this->output->table($this->headers(), $this->items());
    }

    protected function getStatus(bool $result = false): string
    {
        return $result ? $this->status_success : $this->status_failed;
    }

    protected function headers(): array
    {
        return Arr::keys(Arr::first($this->items));
    }

    protected function items(): array
    {
        return $this->items;
    }
}
