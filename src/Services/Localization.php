<?php

namespace Helldar\LaravelLangPublisher\Services;

use function array_merge;
use function compact;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as FilesystemContract;
use Helldar\LaravelLangPublisher\Contracts\Localization as LocalizationContract;

use Helldar\LaravelLangPublisher\Facades\Config;
use Illuminate\Support\Arr;

class Localization implements LocalizationContract
{
    /** @var \Helldar\LaravelLangPublisher\Contracts\Filesystem */
    protected $filesystem;

    /** @var array */
    protected $skipped = [];

    /** @var array */
    protected $copied = [];

    public function __construct(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function publish(string $locale, bool $force = false): void
    {
        $src = $this->getSourcePath($locale);

        $this->filesystem->directoryExists($src, $locale);

        $this->find($src, $locale, $force);
    }

    public function getSkipped(): array
    {
        return $this->skipped;
    }

    public function getCopied(): array
    {
        return $this->copied;
    }

    protected function find(string $source, string $locale, bool $force = false): void
    {
        foreach ($this->filesystem->files($source) as $file) {
            if ($file->isDir() || $file->getExtension() !== 'php') {
                continue;
            }

            $filename = $file->getFilename();
            $src_file = $file->getRealPath();
            $dst_file = $this->filesystem->translationsPath($locale, $filename);

            if ($force || ! $this->filesystem->fileExists($dst_file)) {
                $this->copy($src_file, $dst_file, $filename);
                $this->copied($locale, $filename);

                continue;
            }

            $this->skip($locale, $filename);
        }
    }

    protected function copy(string $source, string $target, string $filename): void
    {
        $key = $this->filesystem->filename($filename);

        if ($key === 'validation') {
            $this->copyValidations($source, $target, $key);
        } else {
            $this->copyOthers($source, $target, $key);
        }
    }

    protected function copyValidations(string $src, string $dst, string $filename): void
    {
        $source = $this->filesystem->load($src);
        $target = $this->filesystem->load($dst, true);

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

        $this->filesystem->save($dst, $result);
    }

    protected function copyOthers(string $src, string $dst, string $filename): void
    {
        $source = $this->filesystem->load($src);
        $target = $this->filesystem->load($dst, true);

        $excluded = $this->excluded($target, $filename);

        $result = array_merge($target, $source, $excluded);

        $this->filesystem->save($dst, $result);
    }

    protected function excluded(array $array, string $key): array
    {
        $keys = Config::getExclude($key, []);

        return Arr::only($array, $keys);
    }

    protected function isDefault(string $locale): bool
    {
        return $locale === static::DEFAULT_LOCALE;
    }

    protected function skip(string $locale, string $filename): void
    {
        $this->skipped[] = $locale . FilesystemContract::DIVIDER . $filename;
    }

    protected function copied(string $locale, string $filename): void
    {
        $this->copied[] = $locale . FilesystemContract::DIVIDER . $filename;
    }

    protected function getDirectory(string $locale): string
    {
        return $this->isDefault($locale) ? '../script/en' : $locale;
    }

    protected function getSourcePath(string $locale): string
    {
        return $this->filesystem->caouecsPath(
            $this->getDirectory($locale)
        );
    }
}
