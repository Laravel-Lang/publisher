<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\Support\Facades\Helpers\Filesystem\File;

final class Uninstall extends Processor
{
    public function run(): void
    {
        if (File::exists($this->target)) {
            File::delete($this->target);
        }
    }
}
