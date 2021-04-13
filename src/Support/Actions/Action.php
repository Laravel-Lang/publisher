<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\Support\Facades\Helpers\Str;

abstract class Action implements Actionable
{
    protected function text(string $value, bool $as_title = false): string
    {
        return $as_title ? Str::title($value) : $value;
    }
}
