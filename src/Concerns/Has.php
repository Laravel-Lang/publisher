<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\Publisher\Constants\Config;

trait Has
{
    protected function hasJson(string $path): bool
    {
        $name = Path::filename($path);

        return Str::of($name)->lower()->contains('json');
    }

    protected function hasValidation(string $path): bool
    {
        $name = Path::filename($path);

        return Str::of($name)->lower()->contains('validation');
    }

    protected function hasInline(): bool
    {
        return (bool) config(Config::PUBLIC_KEY . '.inline', true);
    }

    protected function hasAlign(): bool
    {
        return (bool) config(Config::PUBLIC_KEY . '.align', false);
    }
}
