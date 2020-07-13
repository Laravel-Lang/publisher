<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Processor
{
    public function locale(string $locale): self;

    public function force(bool $is_force = true): self;

    public function full(bool $is_full = true): self;

    public function run(): array;

    public function result(): array;
}
