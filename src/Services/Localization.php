<?php

namespace Helldar\LaravelLangPublisher\Services;

use function array_merge;
use function compact;
use Helldar\LaravelLangPublisher\Contracts\Localization as LocalizationContract;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\File;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Arr;

class Localization implements LocalizationContract
{
    /** @var array */
    protected $result = [];

    public function publish(string $locale, bool $force = false): void
    {
        $src = $this->getSourcePath($locale);

        File::directoryExists($src, $locale);

        $this->find($src, $locale, $force);
    }

    public function getResult(): array
    {
        return $this->result;
    }

    protected function find(string $source, string $locale, bool $force = false): void
    {
        foreach (File::files($source) as $file) {
            if ($file->isDir() || $file->getExtension() !== 'php') {
                continue;
            }

            $filename = $file->getFilename();
            $src_file = $file->getRealPath();
            $dst_file = Path::target($locale, $filename);

            if ($force || ! File::exists($dst_file)) {
                $this->copy($src_file, $dst_file, $filename);
                $this->copied($locale, $filename);

                continue;
            }

            $this->skipped($locale, $filename);
        }
    }

    protected function copy(string $source, string $target, string $filename): void
    {
        $key = File::name($filename);

        if ($key === 'validation') {
            $this->copyValidations($source, $target, $key);
        } else {
            $this->copyOthers($source, $target, $key);
        }
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

    protected function excluded(array $array, string $key): array
    {
        $keys = Config::getExclude($key, []);

        return Arr::only($array, $keys);
    }

    protected function skipped(string $locale, string $filename): void
    {
        $this->push($locale, $filename, __FUNCTION__);
    }

    protected function copied(string $locale, string $filename): void
    {
        $this->push($locale, $filename, __FUNCTION__);
    }

    protected function push(string $locale, string $filename, string $status): void
    {
        $this->result[] = compact('locale', 'filename', 'status');
    }

    protected function getSourcePath(string $locale): string
    {
        return Path::source($locale);
    }
}
