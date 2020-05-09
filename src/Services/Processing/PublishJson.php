<?php

namespace Helldar\LaravelLangPublisher\Services\Processing;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\File;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Arr;

final class PublishJson extends BaseProcess
{
    public function run(): array
    {
        $this->checkExists($this->sourcePath());
        $this->publish();

        return $this->result();
    }

    protected function publish(): void
    {
        foreach (File::files($this->sourcePath()) as $file) {
            if ($file->isDir() || $file->getExtension() !== 'php') {
                continue;
            }

            $filename = $file->getFilename();
            $src_file = $file->getRealPath();
            $dst_file = $this->targetPath($filename);

            if ($this->force || ! File::exists($dst_file)) {
                $this->copy($src_file, $dst_file, $filename);
                $this->push($filename, Status::COPIED);

                continue;
            }

            $this->push($filename, Status::SKIPPED);
        }
    }

    protected function sourcePath(): string
    {
        return Path::source($this->locale, null, true);
    }

    protected function targetPath(string $filename): string
    {
        return Path::target($this->locale, $filename);
    }

    protected function copy(string $source, string $target, string $filename): void
    {
        $key = File::name($filename);

        $this->isValidation($filename)
            ? $this->copyValidations($source, $target, $key)
            : $this->copyOthers($source, $target, $key);
    }

    protected function copyValidations(string $src, string $dst, string $filename): void
    {
        $source = File::load($src);
        $target = File::load($dst, true);

        $source_custom     = Arr::get($source, 'custom', []);
        $source_attributes = Arr::get($source, 'attributes', []);

        $target_custom     = Arr::get($target, 'custom', []);
        $target_attributes = Arr::get($target, 'attributes', []);

        $excluded_target     = $this->excluded($target, $filename);
        $excluded_custom     = $this->excluded($target_custom, $filename);
        $excluded_attributes = $this->excluded($target_attributes, $filename);

        $custom     = array_merge($source_custom, $target_custom, $excluded_custom);
        $attributes = array_merge($source_attributes, $target_attributes, $excluded_attributes);

        $result = array_merge($target, $source, $excluded_target, compact('custom', 'attributes'));

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
        return $filename === 'validation.php';
    }

    protected function excluded(array $array, string $key): array
    {
        $keys = Config::getExclude($key, []);

        return Arr::only($array, $keys);
    }
}
