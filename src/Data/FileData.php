<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Data;

readonly class FileData
{
    public function __construct(
        public string $source,
        public string $target,
    ) {}
}
