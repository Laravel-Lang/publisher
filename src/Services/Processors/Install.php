<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\Support\Facades\Helpers\Filesystem\File;

final class Install extends Processor
{
    public function run(): string
    {
        $this->log('Start the handler for execution:', self::class);

        if ($this->sourceDoesntExists()) {
            return Status::NOT_FOUND;
        }

        if ($this->force || $this->doesntExists()) {
            $this->main();

            return Status::COPIED;
        }

        return Status::SKIPPED;
    }

    protected function sourceDoesntExists(): bool
    {
        $this->log('Checking for the existence of a file:', $this->source_path);

        return ! File::exists($this->source_path);
    }
}
