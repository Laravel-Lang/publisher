<?php

namespace Helldar\LaravelLangPublisher\Support;

final class Path
{
    public function basename(string $filename): string
    {
        return pathinfo($filename, PATHINFO_BASENAME);
    }

    public function filename(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    public function extension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }
}
