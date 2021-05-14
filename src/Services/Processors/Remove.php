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
        $this->log('Removing localization files:', $this->locale);

        $status_dir  = $this->deleteDirectory($this->locale);
        $status_file = $this->deleteFile($this->locale);

        return $this->resolveStatus($status_dir, $status_file);
    }

    protected function deleteDirectory(string $locale): string
    {
        $this->log('Removing the localization directory for the locale:', $locale);

        $path = $this->pathTarget($locale);

        return $this->directory($path);
    }

    protected function deleteFile(string $locale): string
    {
        $this->log('Removing the json localization file for the locale:', $locale);

        $path = $this->pathTargetFull($locale, null, true);

        return $this->file($path);
    }

    protected function resolveStatus(...$statuses): string
    {
        for ($i = 0; $i < count($statuses); $i++) {
            $current = $statuses[$i] ?? null;
            $next    = $statuses[$i + 1] ?? null;

            if ($current !== $next && ! is_null($next)) {
                return Status::SKIPPED;
            }
        }

        return Status::DELETED;
    }

    protected function directory(string $path): string
    {
        if (File::exists($path)) {
            File::deleteDirectory($path);

            return Status::DELETED;
        }

        return Status::SKIPPED;
    }

    protected function file(string $path): string
    {
        if (File::exists($path)) {
            File::delete($path);

            return Status::DELETED;
        }

        return Status::SKIPPED;
    }
}
