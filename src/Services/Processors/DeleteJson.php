<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Traits\Processors\Deletable;
use Illuminate\Support\Facades\File as IlluminateFile;

final class DeleteJson extends BaseProcessor
{
    use Deletable;

    protected $extension = 'json';

    protected function delete(): bool
    {
        if (! IlluminateFile::exists($this->targetPath())) {
            return true;
        }

        return ! $this->isProtected()
            ? IlluminateFile::delete($this->targetPath())
            : false;
    }
}
