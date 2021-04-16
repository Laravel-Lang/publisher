<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\Support\Facades\Helpers\Str;

abstract class Action implements Actionable
{
    use Logger;

    protected function text(string $value, bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $as_title ? Str::title($value) : $value;
    }

    protected function loggableMessage(): string
    {
        return 'Convert text to TitleCase for';
    }
}
