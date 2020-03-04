<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Arr;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    protected function showResult(array $values, string $status_if_empty): void
    {
        if (empty($values)) {
            $this->warn($status_if_empty);

            return;
        }

        $this->table($this->headers($values), $values);
    }

    protected function headers(array $values): array
    {
        return Arr::keys(Arr::first($values));
    }
}
