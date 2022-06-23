<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Exceptions;

use LaravelLang\Publisher\Plugins\Plugin;
use RuntimeException;

class UnknownPluginInstanceException extends RuntimeException
{
    public function __construct(string $plugin)
    {
        parent::__construct($this->message($plugin));
    }

    protected function message(string $plugin): string
    {
        return sprintf('The %s class is not a %s instance.', $plugin, Plugin::class);
    }
}
