<?php

namespace Helldar\LaravelLangPublisher\Traits\Processors;

trait Publishable
{
    public function run(): array
    {
        $this->checkExists($this->sourcePath());
        $this->publish();

        return $this->result();
    }
}
