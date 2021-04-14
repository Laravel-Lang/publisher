<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Verbose\Facades\Log;
use Helldar\Verbose\Services\Logger as Service;

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
