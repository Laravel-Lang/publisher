<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Traits\Processors\Deletable;
use Illuminate\Support\Facades\File as IlluminateFile;

final class DeletePhp extends BaseProcessor
{
    use Deletable;

    protected function delete(): bool
    {
        return ! $this->isProtected()
            ? IlluminateFile::deleteDirectory($this->targetPath())
            : false;
    }
}
