<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use Illuminate\Console\Command;

interface Result
{
    public function push(string $locale, bool $status = false): void;

    /**
     * @param \Illuminate\Console\Command $output
     *
     * @return self
     */
    public function setOutput(Command $output);

    /**
     * @param string $no_data
     * @param string $success
     * @param string $failed
     *
     * @return self
     */
    public function setMessages(string $no_data, string $success = 'success', string $failed = 'failed');

    /**
     * @param array $items
     *
     * @return self
     */
    public function setItems(array $items);

    public function isEmpty(): bool;

    public function show();
}
