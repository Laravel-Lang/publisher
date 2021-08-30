<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\Contracts\LangPublisher\Plugin;

abstract class BasePlugin implements Plugin
{
    public function isJson(): bool
    {
        return true;
    }

    public function target(): string
    {
        return '{locale}.json';
    }
}
