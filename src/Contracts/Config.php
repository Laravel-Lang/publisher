<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Config
{
    public function getVendor(): string;

    public function isAlignment(): bool;

    public function getExclude(string $key, array $default = []): array;

    public function getCase(): int;
}
