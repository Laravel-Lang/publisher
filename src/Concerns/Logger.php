<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Verbose\Facades\Log;

trait Logger
{
    protected function write(string $message): void
    {
        Log::write($message);
    }
}
