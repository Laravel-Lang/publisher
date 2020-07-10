<?php

namespace Helldar\LaravelLangPublisher\Facades;

use DirectoryIterator;
use Helldar\LaravelLangPublisher\Support\File as FileSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DirectoryIterator files(string $path);
 * @method static array load(string $path, bool $return_empty = false)
 * @method static void save(string $path, array $data)
 * @method static void directoryExist(string $path, string $locale)
 * @method static void fileExist(string $path, string $locale)
 * @method static bool exists(string $path)
 * @method static string name(string $path)
 */
final class File extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FileSupport::class;
    }
}
