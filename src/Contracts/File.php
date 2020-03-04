<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use DirectoryIterator;

interface File
{
    public function files(string $path): DirectoryIterator;

    public function load(string $path, bool $return_empty = false): array;

    public function save(string $path, array $data): void;

    public function directoryExists(string $path, string $locale): void;

    public function exists(string $path): bool;

    public function name(string $path): string;
}
