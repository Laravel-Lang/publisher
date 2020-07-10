<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Localizationable
{
    public function setPath(Pathable $path);

    public function setProcessor(Processor $processor);

    public function run(string $locale, bool $force): array;
}
