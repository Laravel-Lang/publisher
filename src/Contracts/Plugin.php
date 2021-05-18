<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Plugin
{
    public function vendor(): string;

    public function source(): array;

    public function sourcePath(string $package, string $locale): string;

    public function target(): string;

    public function targetPath(string $locale, string $filename): string;

    public function targetFilename(string $locale, string $filename): string;

    public function has(string $package = null, string $locale = null): bool;
}
