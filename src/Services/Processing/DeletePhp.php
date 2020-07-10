<?php

namespace Helldar\LaravelLangPublisher\Services\Processing;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File as IlluminateFile;

final class DeletePhp extends BaseProcess
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
        return ! $this->isProtected()
            ? IlluminateFile::deleteDirectory($this->path())
            : false;
    }

    protected function path(): string
    {
        return Path::target($this->locale);
    }

    protected function isProtected(): bool
    {
        return Locale::isProtected($this->locale);
    }
}
