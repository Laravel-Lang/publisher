<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\Contracts\LangPublisher\Comparator;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Arr;

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

    protected function excludes(string $filename, array $user): array
    {
        foreach (Config::excludes() as $key => $values) {
            if ($this->filename($filename) === $key) {
                return Arr::only($user, $values);
            }
        }

        return [];
    }
}
