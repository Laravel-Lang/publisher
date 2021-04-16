<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;

trait Keyable
{
    protected function key(string $filename): string
    {
        $this->log('Retrieving a key name from a file...');

        return $this->isJson($filename) ? 'json' : Path::filename($filename);
    }
}
