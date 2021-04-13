<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;

final class Reset extends Processor
{
    public function run(): string
    {
        $source = $this->load($this->source_path);

        $result = $this->compare($source);

        $this->store($this->target_path, $result);

        return Status::RESET;
    }
}
