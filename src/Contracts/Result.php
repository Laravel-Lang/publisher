<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use Illuminate\Console\Command;

interface Result
{
    /**
     * @param \Illuminate\Console\Command $output
     *
     * @return self
     */
    public function setOutput(Command $output);

    /**
     * @param string $no_data
     *
     * @return self
     */
    public function setMessage(string $no_data);

    public function merge(array $items): void;

    public function show();
}
