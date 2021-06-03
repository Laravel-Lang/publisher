<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Filesystem
{
    public function load(string $path, string $main_path = null): array;

    public function store(string $path, array $content);

    public function ensureKeys(string $path): void;
}
