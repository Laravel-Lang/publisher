<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Facades\Helpers\Str;

trait Contains
{
    protected function isValidation(string $filename, bool $is_path = false): bool
    {
        $filename = $is_path ? Path::filename($filename) : $filename;

        return Str::startsWith($filename, 'validation');
    }

    protected function isJson(string $filename): bool
    {
        return Str::endsWith($filename, 'json');
    }
}
