<?php

namespace Helldar\LaravelLangPublisher\Support;

use DirectoryIterator;
use function file_exists;
use Helldar\LaravelLangPublisher\Contracts\File as FileContract;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleNotExists;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\PrettyArray\Services\File as PrettyFile;
use Helldar\PrettyArray\Services\Formatter;
use function ksort;
use function pathinfo;

class File implements FileContract
{
    public function files(string $path): DirectoryIterator
    {
        return new DirectoryIterator($path);
    }

    /**
     * @param string $path
     * @param bool $return_empty
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

        return PrettyFile::make()->load($path);
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

        PrettyFile::make(
            $service->raw($data)
        )->store($path);
    }

    /**
     * @param string $path
     * @param string $locale
     *
     * @throws \Helldar\LaravelLangPublisher\Exceptions\SourceLocaleNotExists
     */
    public function directoryExists(string $path, string $locale): void
    {
        if (! $path || ! $this->exists($path)) {
            throw new SourceLocaleNotExists($locale);
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
}
