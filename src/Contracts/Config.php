<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Config
{
    public const KEY = 'lang-publisher';

    public function getVendorPath(): string;

    public function getLocale(): string;

    public function getFallbackLocale(): string;

    public function isAlignment(): bool;

    public function getExclude(string $key, array $default = []): array;

    public function getCase(): int;

    public function isInline(): bool;
}
