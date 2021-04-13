<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Contracts\Processor as Contract;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\Services\Comparators\Manage;
use Helldar\LaravelLangPublisher\Services\Filesystem\Manager;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

abstract class Processor implements Contract
{
    use Containable;
    use Contains;
    use Makeable;

    protected $locale;

    protected $source_path;

    protected $target_path;

    protected $force;

    protected $full;

    public function locale(string $locale): Contract
    {
        $this->locale = $locale;

        return $this;
    }

    public function filename(string $filename, bool $is_inline): Contract
    {
        $this->setSourcePath($filename, $is_inline);
        $this->setTargetPath($filename);

        return $this;
    }

    public function force(bool $force = false): Contract
    {
        $this->force = $force;

        return $this;
    }

    public function full(bool $full = false): Contract
    {
        $this->full = $full;

        return $this;
    }

    protected function setSourcePath(string $filename, bool $is_inline): void
    {
        if ($this->isValidation($filename) && $is_inline) {
            $name      = Path::filename($filename);
            $extension = Path::extension($filename);

            $filename = $name . '-inline.' . $extension;
        }

        $this->source_path = Path::source($this->locale) . '/' . $filename;
    }

    protected function setTargetPath(string $filename): void
    {
        $is_json = $this->isJson($filename);

        $filename = $is_json ? $this->locale . '.json' : $filename;

        $this->target_path = Path::target($this->locale, $is_json) . '/' . $filename;
    }

    protected function compare(array $source, array $target = []): array
    {
        return Manage::make()
            ->source($source)
            ->target($target)
            ->find()
            ->toArray();
    }

    protected function sort(array &$array): void
    {
        $array = Arr::ksort($array);
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

    protected function directory(string $path): string
    {
        return Path::directory($path);
    }

    protected function extension(string $path): string
    {
        return Path::extension($path);
    }
}
