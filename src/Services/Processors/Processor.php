<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Logger;
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
    use Logger;
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
        $this->log('Setting the path to the source file: ' . $filename);

        if ($this->isValidation($filename) && $is_inline) {
            $this->log('The "' . $filename . '" file is a collection of inline validator messages. Processing in progress...');

            $name      = Path::filename($filename);
            $extension = Path::extension($filename);

            $filename = $name . '-inline.' . $extension;
        } elseif ($this->isJson($filename)) {
            $filename = $this->locale . '.json';
        }

        $this->source_path = Path::source($this->locale) . '/' . $filename;
    }

    protected function setTargetPath(string $filename): void
    {
        $this->log('Setting the path to the target file: ' . $filename);

        $is_json = $this->isJson($filename);

        $filename = $is_json ? $this->locale . '.json' : $filename;

        $this->target_path = Path::target($this->locale, $is_json) . '/' . $filename;
    }

    protected function compare(array $source, array $target = []): array
    {
        $this->log('Find an object and perform object comparison.');

        return Manage::make()
            ->filename($this->source_path)
            ->source($source)
            ->target($target)
            ->find()
            ->toArray();
    }

    protected function sort(array &$array): void
    {
        $this->log('Sorting an array.');

        $array = Arr::ksort($array);
    }

    protected function load(string $path): array
    {
        $this->log('Loading an array: ' . $path);

        return $this->manager()->load($path);
    }

    protected function store(string $path, array $content): void
    {
        $this->log('Saving an array to a file: ' . $path);

        $this->manager()->store($path, $content);
    }

    protected function manager(): Manager
    {
        $this->log('Getting a comparison object...');

        return $this->container(Manager::class);
    }

    protected function directory(string $path): string
    {
        $this->log('Getting the directory name for a path: ' . $path);

        return Path::directory($path);
    }

    protected function extension(string $path): string
    {
        $this->log('Getting the file extension for a path: ' . $path);

        return Path::extension($path);
    }
}
