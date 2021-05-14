<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Package
{
    public function vendor(): string;

    public function source(): string;

    public function sourcePath(string $package, string $locale): string;

    public function target(): string;

    public function targetPath(string $locale): string;

    public function has(): bool;
}
