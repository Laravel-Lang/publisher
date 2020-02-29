<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool exists($path)
 * @method static string get($path)
 * @method static bool put($path, $contents, $options = [])
 * @method static bool delete($paths)
 * @method static bool copy($from, $to)
 * @method static bool move($from, $to)
 * @method static array files($directory = null, $recursive = false);
 * @method static array allFiles($directory = null);
 * @method static array directories($directory = null, $recursive = false)
 * @method static array allDirectories($directory = null)
 * @method static bool makeDirectory($path)
 * @method static bool deleteDirectory($directory)
 */
class Filesystem extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'files';
    }
}
