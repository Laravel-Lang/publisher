<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Contracts\Pathable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\File;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Support\Str;
use SplFileInfo;

abstract class BaseProcessor implements Processor
{
    /** @var \Helldar\LaravelLangPublisher\Contracts\Pathable */
    protected $path;

    /** @var string */
    protected $locale;

    /** @var bool */
    protected $is_force;

    /** @var bool */
    protected $is_full;

    /** @var string */
    protected $extension = 'php';

    /** @var array */
    protected $result = [];

    public function __construct(Pathable $path)
    {
        $this->path = $path;
    }

    public function locale(string $locale): Processor
    {
        $this->locale = $locale;

        return $this;
    }

    public function force(bool $is_force = true): Processor
    {
        $this->is_force = $is_force;

        return $this;
    }

    public function full(bool $is_full = true): Processor
    {
        $this->is_full = $is_full;

        return $this;
    }

    public function result(): array
    {
        return $this->result;
    }

    protected function push(string $filename, string $status): void
    {
        $locale = $this->locale;

        $this->result[] = compact('locale', 'filename', 'status');
    }

    protected function checkExists(string $path): void
    {
        $this->extension === 'php'
            ? File::directoryExist($path, $this->locale)
            : File::fileExist($path, $this->locale);
    }

    protected function isProtected(): bool
    {
        return Locale::isProtected($this->locale);
    }

    protected function publishFile(SplFileInfo $file): void
    {
        if ($file->isDir() || $file->getExtension() !== $this->extension || $this->isInline($file->getFilename())) {
            return;
        }

        $filename = $this->getTargetFilename($file);
        $src_file = $this->getSourceFilePath($file);
        $dst_file = $this->targetPath($filename);

        if ($this->is_force || ! File::exists($dst_file)) {
            $this->copy($src_file, $dst_file, $filename);
            $this->push($filename, Status::COPIED);

            return;
        }

        $this->push($filename, Status::SKIPPED);
    }

    protected function resetFile(SplFileInfo $file): void
    {
        if ($file->isDir() || $file->getExtension() !== $this->extension || $this->isInline($file->getFilename())) {
            return;
        }

        $filename = $this->getTargetFilename($file);
        $src_file = $this->getSourceFilePath($file);
        $dst_file = $this->targetPath($filename);

        if (File::exists($dst_file)) {
            $this->reset($src_file, $dst_file, $filename);
            $this->push($filename, Status::RESET);

            return;
        }

        $this->push($filename, Status::SKIPPED);
    }

    protected function sourcePath(): string
    {
        return $this->path->source($this->locale);
    }

    protected function targetPath(string $filename = null): string
    {
        return $this->path->target($this->locale, $filename);
    }

    protected function copy(string $source, string $target, string $filename): void
    {
        $this->isValidation($filename)
            ? $this->copyValidations($source, $target, $filename)
            : $this->copyOthers($source, $target, $filename);
    }

    protected function reset(string $src, string $dst, string $filename): void
    {
        $source = File::load($src);
        $target = File::load($dst, true);

        $result = $this->is_full
            ? $source
            : array_merge($source, $this->excluded($target, $filename));

        File::save($dst, $result);
    }

    protected function copyValidations(string $src, string $dst, string $filename): void
    {
        $source = File::load($src);
        $target = File::load($dst, true);

        $source_custom     = Arr::get($source, 'custom', []);
        $source_attributes = Arr::get($source, 'attributes', []);

        $target_custom     = Arr::get($target, 'custom', []);
        $target_attributes = Arr::get($target, 'attributes', []);

        $source = Arr::except($source, ['custom', 'attributes']);
        $target = Arr::except($target, ['custom', 'attributes']);

        $excluded_target     = $this->excluded($target, $filename);
        $excluded_custom     = $this->excluded($target_custom, $filename);
        $excluded_attributes = $this->excluded($target_attributes, $filename);

        $custom     = Arr::ksort(array_merge($source_custom, $target_custom, $excluded_custom));
        $attributes = Arr::ksort(array_merge($source_attributes, $target_attributes, $excluded_attributes));

        $main = Arr::ksort(array_merge($target, $source, $excluded_target));

        $result = array_merge($main, compact('custom', 'attributes'));

        File::save($dst, $result);
    }

    protected function copyOthers(string $src, string $dst, string $filename): void
    {
        $source = File::load($src);
        $target = File::load($dst, true);

        $excluded = $this->excluded($target, $filename);

        $result = array_merge($target, $source, $excluded);

        File::save($dst, $result);
    }

    protected function isValidation(string $filename): bool
    {
        return Str::startsWith($filename, 'validation');
    }

    protected function isInline(string $filename): bool
    {
        return Str::contains($filename, 'inline');
    }

    protected function wantsJson(): bool
    {
        return $this->extension === 'json';
    }

    protected function getSourceFilePath(SplFileInfo $file): string
    {
        if (Config::isInline()) {
            $path      = $file->getPath();
            $extension = $file->getExtension();
            $basename  = $file->getBasename('.' . $extension);

            $inline = $path . '/' . $basename . '-inline.' . $extension;

            return file_exists($inline)
                ? $inline
                : $file->getRealPath();
        }

        return $file->getRealPath();
    }

    protected function getTargetFilename(SplFileInfo $file): string
    {
        if ($this->isInline($file->getFilename())) {
            return Str::replaceLast('-inline', '', $file->getFilename());
        }

        return $file->getFilename();
    }
}
