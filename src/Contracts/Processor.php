<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Processor
{
    public function package(string $package): self;

    public function locale(string $locale): self;

    public function filename(string $filename, bool $is_inline): self;

    public function force(bool $force = false): self;

    public function full(bool $full = false): self;

    public function run(): string;
}
