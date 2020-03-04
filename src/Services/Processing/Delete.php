<?php

namespace Helldar\LaravelLangPublisher\Services\Processing;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File as IlluminateFile;

final class Delete extends BaseProcess
{
    public function run(): array
    {
        $this->checkExists($this->path());

        $this->delete()
            ? $this->push('*', Status::DELETED)
            : $this->push('*', Status::SKIPPED);

        return $this->result();
    }

    protected function delete(): bool
    {
        return IlluminateFile::deleteDirectory($this->path());
    }

    protected function path(): string
    {
        return Path::target($this->locale);
    }
}
