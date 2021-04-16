<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Contracts\Processor as Contract;
use Helldar\LaravelLangPublisher\Services\Comparators\Manage;
use Helldar\LaravelLangPublisher\Services\Filesystem\Manager;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Filesystem\File;

abstract class Processor implements Contract
{
    use Containable;
    use Contains;
    use Logger;
    use Makeable;
    use Pathable;

    protected $package;

    protected $locale;

    protected $source_path;

    protected $target_path;

    protected $force;

    protected $full = false;

    public function package(string $package): Contract
    {
        $this->package = $package;

        return $this;
    }

    public function locale(string $locale): Contract
    {
        $this->locale = $locale;

        return $this;
    }

    public function filename(string $filename, bool $is_inline = true): Contract
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

    public function whenPackage(?string $package): Contract
    {
        if ($package) {
            $this->package($package);
        }

        return $this;
    }

    public function whenLocale(?string $locale): Contract
    {
        if ($locale) {
            $this->locale($locale);
        }

        return $this;
    }

    public function whenFilename(?string $filename, bool $is_inline = true): Contract
    {
        if ($filename) {
            $this->filename($filename, $is_inline);
        }

        return $this;
    }

    protected function setSourcePath(string $filename, bool $is_inline): void
    {
        $this->log('Setting the path to the source file:', $filename);

        if ($this->isValidation($filename) && $is_inline) {
            $this->log('The', $filename, '(is inline: ', $is_inline, ')', 'file is a collection of inline validator messages. Processing in progress...');

            $name      = $this->pathFilename($filename);
            $extension = $this->pathExtension($filename);

            $filename = $name . '-inline.' . $extension;
        } elseif ($this->isJson($filename)) {
            $filename = $this->locale . '.json';
        }

        $this->source_path = $this->pathSource($this->package, $this->locale) . '/' . $filename;
    }

    protected function setTargetPath(string $filename): void
    {
        $this->log('Setting the path to the target file:', $filename);

        $is_json = $this->isJson($filename);

        $this->target_path = $this->pathTargetFull($this->locale, $filename, $is_json);
    }

    protected function compare(array $source, array $target): array
    {
        $this->log('Find an object and perform object comparison.');

        return Manage::make()
            ->filename($this->source_path)
            ->full($this->full)
            ->source($source)
            ->target($target)
            ->find()
            ->toArray();
    }

    protected function load(string $path): array
    {
        $this->log('Loading an array:', $path);

        return $this->manager()->load($path);
    }

    protected function store(string $path, array $content): void
    {
        $this->log('Saving an array to a file:', $path);

        $this->manager()->store($path, $content);
    }

    protected function manager(): Manager
    {
        $this->log('Getting a comparison object...');

        return $this->container(Manager::class);
    }

    protected function doesntExists(): bool
    {
        $this->log('Checking for the existence of a file:', $this->target_path);

        return ! File::exists($this->target_path);
    }
}
