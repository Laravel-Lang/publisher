<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Filesystem
{
    public function load(string $path): array;

    public function store(string $path, array $content);
}
