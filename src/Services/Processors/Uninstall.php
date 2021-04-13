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
        return File::exists($this->target_path);
    }

    protected function delete(): string
    {
        File::delete($this->target_path);

        return Status::DELETED;
    }

    protected function skipped(): string
    {
        return Status::SKIPPED;
    }
}
