<?php

namespace Helldar\LaravelLangPublisher\Traits\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;
use Illuminate\Support\Facades\File as IlluminateFile;

trait Deletable
{
    public function run(): array
    {
        $this->delete()
            ? $this->push('*', Status::DELETED)
            : $this->push('*', Status::SKIPPED);

        return $this->result();
    }

    protected function delete(): bool
    {
        if ($this->isProtected()) {
            return false;
        }

        return $this->wantsJson()
            ? IlluminateFile::delete($this->targetPath())
            : IlluminateFile::deleteDirectory($this->targetPath());
    }
}
