<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Localizationable
{
    public function setPath(Pathable $path): self;

    public function setProcessor(Processor $processor): self;

    public function force(bool $is_force = true): self;

    public function full(bool $is_full = true): self;

    public function run(string $locale): array;
}
