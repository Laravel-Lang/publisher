<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;

final class Install extends Processor
{
    public function run(): string
    {
        $this->log('Start the handler for execution:', self::class);

        if (! $this->force && $this->exists()) {
            $this->log('Skip processing:', self::class);

            return Status::SKIPPED;
        }

        $source = $this->load($this->source_path);
        $target = $this->load($this->target_path);

        $result = $this->compare($source, $target);

        $this->store($this->target_path, $result);

        return Status::COPIED;
    }
}
