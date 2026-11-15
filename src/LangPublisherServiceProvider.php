<?php

declare(strict_types=1);

namespace LaravelLang\Publisher;

use Illuminate\Support\ServiceProvider;
use LaravelLang\Publisher\Console\AddCommand;
use LaravelLang\Publisher\Console\RemoveCommand;
use LaravelLang\Publisher\Console\UpdateCommand;

class LangPublisherServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            AddCommand::class,
            RemoveCommand::class,
            UpdateCommand::class,
        ]);
    }
}
