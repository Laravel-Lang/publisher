<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Filesystem;

use DragonCode\Contracts\Support\Filesystem;
use DragonCode\PrettyArray\Services\File as Pretty;
use DragonCode\PrettyArray\Services\Formatter;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Concerns\Has;

abstract class Base implements Filesystem
{
    use Has;

    public function __construct(
        protected Pretty    $pretty = new Pretty(),
        protected Formatter $formatter = new Formatter()
    ) {
    }

    public function load(string $path): array
    {
        return File::load($path);
    }

    protected function sort(array $items): array
    {
        return Arr::ksort($items);
    }
}
