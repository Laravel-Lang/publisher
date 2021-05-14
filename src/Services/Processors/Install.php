<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;

final class Install extends Processor
{
    public function run(): string
    {
        $this->log('Start the handler for execution:', self::class);

        if ($this->force || $this->doesntExists()) {
            $this->process();

            return Status::COPIED;
        }

        return Status::SKIPPED;
    }

    protected function process(): void
    {
        $source = $this->load($this->source_path);
        $target = $this->load($this->target_path);

        $result = $this->compare($source, $target);

        $this->store($this->target_path, $result);
    }
}
