<?php

declare(strict_types=1);

namespace LaravelLang\Publisher;

use Illuminate\Support\ServiceProvider;
use LaravelLang\Publisher\Console\AddCommand;
use LaravelLang\Publisher\Console\RemoveCommand;
use LaravelLang\Publisher\Console\UpdateCommand;
use LaravelLang\Publisher\Contracts\Decorator;
use LaravelLang\Publisher\Decorators\CommonDecorator;
use LaravelLang\Publisher\Decorators\SmartPunctuationDecorator;

class LangPublisherServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootCommands();
        $this->bootDecorator();
    }

    protected function bootCommands(): void
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

    protected function bootDecorator(): void
    {
        $this->app['config']->get('localization_punctuation.enabled')
            ? $this->app->bind(Decorator::class, SmartPunctuationDecorator::class)
            : $this->app->bind(Decorator::class, CommonDecorator::class);
    }
}
