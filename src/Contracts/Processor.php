<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Processor
{
    public function source(string $path): self;

    public function target(string $path): self;

    public function run(): void;
}
