<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Verbose\Facades\Log;

trait Logger
{
    protected function log(string $message): void
    {
        Log::write($message);
    }
}
