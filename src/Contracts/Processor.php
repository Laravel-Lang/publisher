<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Processor
{
    public function package(string $package): self;

    public function locale(string $locale): self;

    public function sourceFilename(string $filename, bool $is_inline = true): self;

    public function targetFilename(string $filename): self;

    public function force(bool $force = false): self;

    public function full(bool $full = false): self;

    public function whenPackage(?string $package): self;

    public function whenLocale(?string $locale): self;

    public function whenSourceFilename(?string $filename, bool $is_inline = true): self;

    public function whenTargetFilename(?string $filename): self;

    public function run(): string;
}
