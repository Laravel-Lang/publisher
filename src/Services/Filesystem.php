<?php

namespace Helldar\LaravelLangPublisher\Services;

use DirectoryIterator;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as FilesystemContract;
use Helldar\LaravelLangPublisher\Exceptions\SourceLanguageNotExists;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\PrettyArray\Services\File;
use Helldar\PrettyArray\Services\Formatter;

use function file_exists;
use function ksort;
use function ltrim;
use function realpath;
use function resource_path;

class Filesystem implements FilesystemContract
{
    public function translationsPath(string $path = '', string $filename = ''): string
    {
        $path     = $this->cleanPath($path);
        $filename = $this->cleanPath($filename);

        return resource_path(static::LANG_DIRECTORY . $path . $filename);
    }

    public function caouecsPath(string $path): string
    {
        return $this->realpath(
            Config::getVendorPath() . $this->cleanPath($path)
        );
    }

    public function files(string $path): DirectoryIterator
    {
        return new DirectoryIterator($path);
    }

    /**
     * @param string $path
     * @param bool $return_empty
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @return array
     */
    public function load(string $path, bool $return_empty = false): array
    {
        if ($return_empty && ! $this->fileExists($path)) {
            return [];
        }

        return File::make()->load($path);
    }

    /**
     * @param string $path
     * @param array $data
     *
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    public function save(string $path, array $data): void
    {
        ksort($data);

        $service = Formatter::make();
        $service->setKeyAsString();
        $service->setCase(Config::getCase());

        if (Config::isAlignment()) {
            $service->setEqualsAlign();
        }

        File::make(
            $service->raw($data)
        )->store($path);
    }

    /**
     * @param string $path
     * @param string $locale
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\SourceLanguageNotExists
     */
    public function directoryExists(string $path, string $locale)
    {
        if (! file_exists($path)) {
            throw new SourceLanguageNotExists($locale);
        }
    }

    public function fileExists(string $path): bool
    {
        return file_exists($path);
    }

    protected function cleanPath(string $path = ''): string
    {
        return $path
            ? static::DIVIDER . ltrim($path, static::DIVIDER)
            : $path;
    }

    protected function realpath(string $path): string
    {
        return realpath($path);
    }
}
