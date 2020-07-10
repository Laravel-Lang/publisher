<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUninstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Helldar\LaravelLangPublisher\Contracts\Pathable;
use Helldar\LaravelLangPublisher\Services\Processing\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processing\DeletePhp;
use Helldar\LaravelLangPublisher\Services\Processing\PublishJson;
use Helldar\LaravelLangPublisher\Services\Processing\PublishPhp;
use Helldar\LaravelLangPublisher\Support\Config;
use Helldar\LaravelLangPublisher\Support\Path\Json as JsonPath;
use Helldar\LaravelLangPublisher\Support\Path\Php as PhpPath;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Lumen\Application;
use Tests\Commands\Json\InstallTest as InstallJsonTest;
use Tests\Commands\Json\UninstallTest as UninstallJsonTest;
use Tests\Commands\Php\InstallTest as InstallPhpTest;
use Tests\Commands\Php\UninstallTest as UninstallPhpTest;

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

    protected function config(): void
    {
        if ($this->isLumen()) {
            $this->app->configure(Config::KEY);
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', Config::KEY);
    }

    protected function binds()
    {
        $this->app->when([PublishPhp::class, DeletePhp::class, InstallPhpTest::class, UninstallPhpTest::class])
            ->needs(Pathable::class)
            ->give(PhpPath::class);

        $this->app->when([PublishJson::class, DeleteJson::class, InstallJsonTest::class, UninstallJsonTest::class])
            ->needs(Pathable::class)
            ->give(JsonPath::class);
    }

    protected function isLumen(): bool
    {
        return class_exists(Application::class) && $this->app instanceof Application;
    }
}
