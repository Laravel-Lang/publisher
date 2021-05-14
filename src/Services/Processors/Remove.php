<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Illuminate\Support\Facades\File;

final class Remove extends Processor
{
    public function run(): string
    {
        return $this->doesntProtect() ? $this->delete() : Status::SKIPPED;
    }

    protected function doesntProtect(): bool
    {
        $this->log('Check if the localization is among the protected:', $this->locale);

        return ! Locales::isProtected($this->locale);
    }

    protected function delete(): string
    {
        $this->log('Removing json and php localization files:', $this->locale);

        $status_dir  = $this->deleteDirectory($this->locale);
        $status_file = $this->deleteFile($this->locale);

        return $status_dir === $status_file ? $status_dir : Status::DELETED;
    }

    protected function deleteDirectory(string $locale): string
    {
        $this->log('Removing the localization directory for the locale:', $locale);

        $path = $this->pathTarget($locale);

        if (File::exists($path)) {
            File::deleteDirectory($path);

            return Status::DELETED;
        }

        return Status::SKIPPED;
    }

    protected function deleteFile(string $locale): string
    {
        $this->log('Removing the json localization file for the locale:', $locale);

        $path = $this->pathTargetFull($locale, null, true);

        if (File::exists($path)) {
            File::delete($path);

            return Status::DELETED;
        }

        return Status::SKIPPED;
    }
}
