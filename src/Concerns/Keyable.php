<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;

trait Keyable
{
    protected function key(string $filename): string
    {
        return $this->isJson($filename) ? 'json' : Path::filename($filename);
    }
}
