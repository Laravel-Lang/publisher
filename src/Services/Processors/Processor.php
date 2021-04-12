<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Contracts\Processor as Contract;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\Services\Filesystem\Manager;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

abstract class Processor implements Contract
{
    use Containable;
    use Makeable;

    protected $source;

    protected $target;

    public function source(string $path): Contract
    {
        $this->source = $path;

        return $this;
    }

    public function target(string $path): Contract
    {
        $this->target = $path;

        return $this;
    }

    protected function sort(array &$array): void
    {
        $array = Arr::ksort($array);
    }

    protected function getFallbackValue(array $source, array $target, string $key): array
    {
        return Arr::get($target, $key) ?: Arr::get($source, $key, []);
    }

    protected function load(string $path): array
    {
        return $this->manager()->load($path);
    }

    protected function store(string $path, array $content): void
    {
        $this->manager()->store($path, $content);
    }

    protected function manager(): Manager
    {
        return $this->container(Manager::class);
    }

    protected function filename(string $filename): string
    {
        return Path::filename($filename);
    }

    protected function directory(string $path): string
    {
        return Path::directory($path);
    }

    protected function extension(string $path): string
    {
        return Path::extension($path);
    }
}
