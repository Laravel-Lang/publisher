<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;

final class Install extends Processor
{
    public function run(): string
    {
        $source = $this->load($this->source_path);
        $target = $this->load($this->target_path);

        $result = $this->compare($source, $target);

        $this->store($this->target_path, $result);

        return Status::COPIED;
    }
}
