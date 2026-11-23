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

use function config;

class LangPublisherServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            Decorator::class,
            fn (): Decorator => config()->boolean('localization_punctuation.enabled', false)
            ? $this->app->make(SmartPunctuationDecorator::class)
            : $this->app->make(CommonDecorator::class)
        );
    }

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
