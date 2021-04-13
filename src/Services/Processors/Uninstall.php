<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;

final class Uninstall extends Processor
{
    public function run(): string
    {
        if ($this->exists() && $this->doesntProtect()) {
            $this->delete();
            $this->deleteDirectory();

            return $this->deleted();
        }

        return $this->skipped();
    }

    protected function delete(): void
    {
        $this->log('Deleting a file: ' . $this->target_path);

        if (File::exists($this->target_path)) {
            File::delete($this->target_path);
        }
    }

    protected function deleteDirectory(): void
    {
        $this->log('Removing the "lang/' . $this->locale . '" directory if it empty.');

        $path = Path::target($this->locale);

        if (! File::names($path)) {
            Directory::delete($path);
        }
    }

    protected function deleted(): string
    {
        return Status::DELETED;
    }

    protected function skipped(): string
    {
        $this->log('Skipping file processing: ' . $this->target_path);

        return Status::SKIPPED;
    }

    protected function doesntProtect(): bool
    {
        return ! Locales::isProtected($this->locale);
    }
}
