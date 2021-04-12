<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;

final class Config
{
    public const KEY_PRIVATE = 'lang-publisher-private';

    public const KEY_PUBLIC = 'lang-publisher';

    public function basePath(): string
    {
        return Illuminate::get(self::KEY_PRIVATE . '.path.base');
    }

    public function localesPath(): string
    {
        return Illuminate::get(self::KEY_PRIVATE . '.path.locales');
    }

    public function resourcesPath(): string
    {
        return Illuminate::get(self::KEY_PRIVATE . '.path.target');
    }

    public function isInline(): bool
    {
        return Illuminate::get(self::KEY_PUBLIC . '.inline');
    }

    public function isAlignment(): bool
    {
        return Illuminate::get(self::KEY_PUBLIC . '.alignment');
    }

    public function excludes(): array
    {
        return Illuminate::get(self::KEY_PUBLIC . '.exclude', []);
    }

    public function ignores(): array
    {
        return Illuminate::get(self::KEY_PUBLIC . '.ignore', []);
    }

    public function getCase(): int
    {
        return Illuminate::get(self::KEY_PUBLIC . '.case', Caseable::NO_CASE);
    }
}
