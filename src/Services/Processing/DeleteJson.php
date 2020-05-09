<?php

namespace Helldar\LaravelLangPublisher\Services\Processing;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\File;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File as IlluminateFile;

final class DeleteJson extends BaseProcess
{
    protected $extension = '.json';

    public function run(): array
    {
        $this->checkExists($this->path());

        $this->delete()
            ? $this->push($this->locale, Status::DELETED)
            : $this->push($this->locale, Status::SKIPPED);

        return $this->result();
    }

    protected function delete(): bool
    {
        return ! $this->isProtected()
            ? IlluminateFile::delete($this->path())
            : false;
    }

    protected function path(): string
    {
        return Path::target($this->locale . $this->extension);
    }

    protected function isProtected(): bool
    {
        return Locale::isProtected($this->locale);
    }

    protected function checkExists(string $path): void
    {
        File::exists($path);
    }
}
