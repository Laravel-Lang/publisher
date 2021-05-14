<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;

final class Install extends Processor
{
    public function run(): string
    {
        $this->log('Start the handler for execution:', self::class);

        if ($this->force || $this->doesntExists()) {
            $this->main();

            return Status::COPIED;
        }

        return Status::SKIPPED;
    }
}
