<?php

namespace Helldar\LaravelLangPublisher\Support;

use DirectoryIterator;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDirectoryDoesntExist;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleFileDoesntExist;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\PrettyArray\Services\File as PrettyFile;
use Helldar\PrettyArray\Services\Formatter;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Str;

final class File
{
    public function files(string $path): DirectoryIterator
    {
        return Directory::all($path);
    }

    /**
     * @param  string  $path
     * @param  bool  $return_empty
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     *
     * @return array
     */
    public function load(string $path, bool $return_empty = false): array
    {
        if ($return_empty && ! $this->exists($path)) {
            return [];
        }

        $pretty = PrettyFile::make();

        return $this->isJson($path)
            ? json_decode($pretty->loadRaw($path), true)
            : $pretty->load($path);
    }

    /**
     * @param  string  $path
     * @param  array  $data
     *
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    public function save(string $path, array $data): void
    {
        if ($this->isJson($path)) {
            PrettyFile::make(
                json_encode($data, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_UNICODE)
            )->storeRaw($path);

            return;
        }

        $service = Formatter::make();
        $service->setKeyAsString();
        $service->setCase(Config::getCase());

        if (Config::isAlignment()) {
            $service->setEqualsAlign();
        }

        PrettyFile::make(
            $service->raw($data)
        )->store($path);
    }

    public function directoryExist(string $path, string $locale): void
    {
        if (! $path || ! $this->exists($path)) {
            throw new SourceLocaleDirectoryDoesntExist($locale);
        }
    }

    public function fileExist(string $path, string $locale): void
    {
        if (! $path || ! $this->exists($path)) {
            throw new SourceLocaleFileDoesntExist($locale);
        }
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    public function name(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    public function isJson(string $path): bool
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return Str::lower($extension) === 'json';
    }
}
