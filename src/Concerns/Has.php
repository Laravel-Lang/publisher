<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;

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
        return $this->config->hasInline();
    }

    protected function hasAlign(): bool
    {
        return $this->config->hasAlign();
    }
}
