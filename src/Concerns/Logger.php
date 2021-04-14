<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Verbose\Facades\Log;
use Helldar\Verbose\Services\Logger as Service;

/** @mixin \Helldar\LaravelLangPublisher\Console\Add */
trait Logger
{
    protected function setLogger(): void
    {
        Service::io($this->output);
    }

    protected function log(string $message): void
    {
        Log::write($message);
    }
}
