<?php

namespace Helldar\LaravelLangPublisher\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

use function array_keys;

abstract class BaseCommand extends Command
{
    protected function showResult(array $values, string $status_if_empty): void
    {
        if (empty($values)) {
            $this->warn($status_if_empty);

            return;
        }

        $headers = array_keys(Arr::first($values));

        $this->table($headers, $values);
    }
}
