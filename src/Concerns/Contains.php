<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Facades\Helpers\Str;

trait Contains
{
    protected function isValidation(string $filename, bool $is_path = false): bool
    {
        $this->log('Does the file contain validation messages?', $filename);

        $filename = $is_path ? Path::filename($filename) : $filename;

        return Str::startsWith($filename, 'validation');
    }

    protected function isJson(string $filename): bool
    {
        $this->log('Does the file contain json?', $filename);

        return Str::endsWith($filename, 'json');
    }

    protected function isPhp(string $filename): bool
    {
        $this->log('Does the file contain php?', $filename);

        return Str::endsWith($filename, 'php');
    }
}
