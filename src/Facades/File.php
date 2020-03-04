<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Contracts\File as FileContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \DirectoryIterator files(string $path);
 * @method static array load(string $path, bool $return_empty = false)
 * @method static void save(string $path, array $data)
 * @method static void directoryExists(string $path, string $locale)
 * @method static bool exists(string $path)
 * @method static string name(string $path)
 */
class File extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FileContract::class;
    }
}
