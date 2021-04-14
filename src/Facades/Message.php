<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Message as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Support same()
 * @method static Support length(int $length)
 * @method static Support locale(string $locale)
 * @method static Support filename(string $filename)
 * @method static Support status(string $status)
 * @method static string get()
 */
final class Message extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
