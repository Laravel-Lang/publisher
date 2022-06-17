<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Filesystem;

use DragonCode\Support\Facades\Filesystem\File;

class Json extends Base
{
    public function store(string $path, $content): string
    {
        $items = $this->sort($content);

        return File::store($path, $this->encode($items));
    }

    protected function encode(array $values): string
    {
        return json_encode($values, JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES ^ JSON_PRETTY_PRINT);
    }
}
