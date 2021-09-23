<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\Contracts\LangPublisher\Comparator;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;

abstract class Base implements Comparator
{
    use Paths;

    protected $keys = [];

    protected $translations = [];

    public function __construct(array $keys, array $translations)
    {
        $this->keys = $keys;

        $this->translations = $translations;
    }

    protected function load(string $filename): array
    {
        $path = $this->resourcesPath($filename);

        return Filesystem::load($path);
    }
}
