<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;

abstract class Base extends Command
{
    abstract public function handle();
}
