<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Localizationable
{
    public function setPath(Pathable $path): self;

    public function setProcessor(Processor $processor): self;

    public function run(string $locale, bool $force = false): array;
}
