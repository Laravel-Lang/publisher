<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Plugin
{
    public function vendor(): string;

    public function source(): array;

    public function target(): ?string;

    public function targetPath(string $locale, string $filename): string;

    public function has(): bool;
}
