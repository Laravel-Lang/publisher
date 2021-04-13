<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\Support\Facades\Helpers\Filesystem\File;

final class Uninstall extends Processor
{
    public function run(): string
    {
        return $this->exists() ? $this->delete() : $this->skipped();
    }

    protected function exists(): bool
    {
        $this->log('Checking for the existence of a file: ' . $this->target_path);

        return File::exists($this->target_path);
    }

    protected function delete(): string
    {
        $this->log('Deleting a file: ' . $this->target_path);

        File::delete($this->target_path);

        return Status::DELETED;
    }

    protected function skipped(): string
    {
        $this->log('Skipping file processing: ' . $this->target_path);

        return Status::SKIPPED;
    }
}
