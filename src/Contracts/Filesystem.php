<?php

namespace Helldar\LaravelLangPublisher\Contracts;

use DirectoryIterator;

interface Filesystem
{
    public const CAOUECS_DIRECTORY = 'caouecs/laravel-lang/src';
    public const DIVIDER = DIRECTORY_SEPARATOR;
    public const LANG_DIRECTORY = 'lang';

    public function vendorPath(string $path = ''): string;

    public function translationsPath(string $path = '', string $filename = ''): string;

    public function caouecsPath(string $path): string;

    public function files(string $path): DirectoryIterator;

    public function load(string $path, bool $return_empty = false): array;

    public function save(string $path, array $data): void;

    public function directoryExists(string $path, string $locale);

    public function fileExists(string $path): bool;
}
