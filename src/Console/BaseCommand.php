<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Arr;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    protected function showResult(array $values, string $message): void
    {
        empty($values) ? $this->warn($message) : $this->showTable($values);
    }

    protected function headers(array $values): array
    {
        return Arr::keys(Arr::first($values));
    }

    protected function showTable(array $values): void
    {
        $this->table(
            $this->headers($values),
            $values
        );
    }
}
