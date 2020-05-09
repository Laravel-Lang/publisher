<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUninstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Helldar\LaravelLangPublisher\Contracts\Arr as ArrContract;
use Helldar\LaravelLangPublisher\Contracts\Config as ConfigContract;
use Helldar\LaravelLangPublisher\Contracts\File as FileContract;
use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Helldar\LaravelLangPublisher\Contracts\Localization as PublisherContract;
use Helldar\LaravelLangPublisher\Contracts\Path as PathContract;
use Helldar\LaravelLangPublisher\Contracts\Result as ResultContract;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Services\Processing\Delete;
use Helldar\LaravelLangPublisher\Services\Processing\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processing\Publish;
use Helldar\LaravelLangPublisher\Services\Processing\PublishJson;
use Helldar\LaravelLangPublisher\Support\Arr;
use Helldar\LaravelLangPublisher\Support\Config;
use Helldar\LaravelLangPublisher\Support\File;
use Helldar\LaravelLangPublisher\Support\Locale;
use Helldar\LaravelLangPublisher\Support\Path;
use Helldar\LaravelLangPublisher\Support\PathJson;
use Helldar\LaravelLangPublisher\Support\Result;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootPublishes();
        $this->bootCommands();
    }

    public function register(): void
    {
        $this->binds();
        $this->config();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            LangInstall::class,
            LangUpdate::class,
            LangUninstall::class,
        ]);
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/lang-publisher.php' => $this->app->configPath('lang-publisher.php'),
        ], 'config');
    }

    protected function binds(): void
    {
        $this->app->singleton(ArrContract::class, Arr::class);
        $this->app->singleton(FileContract::class, File::class);
        $this->app->singleton(LocaleContract::class, Locale::class);
        $this->app->singleton(PublisherContract::class, Localization::class);
        $this->app->singleton(ResultContract::class, Result::class);
        $this->app->singleton(ConfigContract::class, Config::class);

        $this->app->when([Publish::class, Delete::class])
            ->needs(PathContract::class)
            ->give(function () {
                return Path::class;
            });

        $this->app->when([PublishJson::class, DeleteJson::class])
            ->needs(PathContract::class)
            ->give(function () {
                return PathJson::class;
                   });
    }

    protected function config(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', ConfigContract::KEY);
    }
}
