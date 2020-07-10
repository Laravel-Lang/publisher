<?php

namespace Helldar\LaravelLangPublisher\Traits\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;

trait Deletable
{
    public function run(): array
    {
        $this->checkExists($this->targetPath());

        $this->delete()
            ? $this->push('*', Status::DELETED)
            : $this->push('*', Status::SKIPPED);

        return $this->result();
    }
}
