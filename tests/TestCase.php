<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Contracts\Localizationable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Services\Processors\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processors\DeletePhp;
use Helldar\LaravelLangPublisher\Services\Processors\PublishJson;
use Helldar\LaravelLangPublisher\Services\Processors\PublishPhp;
use Helldar\LaravelLangPublisher\Traits\Containable;
use Helldar\LaravelLangPublisher\Traits\Containers\Pathable;
use Helldar\LaravelLangPublisher\Traits\Containers\Processable;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Containable;
    use Processable;
    use Pathable;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Pathable */
    protected $path;

    protected $default_locale = 'en';

    protected $is_json = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->path = $this->getPath();

        $this->resetDefaultLang();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default_locale);
        $config->set('lang-publisher.vendor', realpath(__DIR__ . '/../vendor/caouecs/laravel-lang'));

        $config->set('lang-publisher.exclude', [
            'auth' => ['failed'],
            'All rights reserved.',
            'Baz',
        ]);
    }

    protected function resetDefaultLang(): void
    {
        $locales = Locale::installed($this->wantsJson());

        foreach ($locales as $locale) {
            $this->localization()
                ->processor($this->getDeleteProcessor())
                ->force()
                ->full()
                ->run($locale);
        }

        $this->localization()
            ->processor($this->getInstallProcessor())
            ->force()
            ->full()
            ->run($this->default_locale);
    }

    protected function copyFixtures(): void
    {
        if ($this->wantsJson()) {
            File::copy(
                realpath(__DIR__ . '/fixtures/en.json'),
                $this->path->target($this->default_locale)
            );

            return;
        }

        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            $this->path->target($this->default_locale, 'auth.php')
        );
    }

    protected function deleteLocales(array $locales): void
    {
        foreach ($locales as $locale) {
            $target = $this->path->target($locale);

            $this->wantsJson()
                ? File::delete($target)
                : File::deleteDirectory($target);
        }
    }

    protected function localization(): Localizationable
    {
        return $this->container(Localization::class);
    }

    protected function wantsJson(): bool
    {
        return $this->is_json;
    }

    protected function getDeleteProcessor(): Processor
    {
        return $this->wantsJson()
            ? $this->makeProcessor(DeleteJson::class)
            : $this->makeProcessor(DeletePhp::class);
    }

    protected function getInstallProcessor(): Processor
    {
        return $this->wantsJson()
            ? $this->makeProcessor(PublishJson::class)
            : $this->makeProcessor(PublishPhp::class);
    }
}
