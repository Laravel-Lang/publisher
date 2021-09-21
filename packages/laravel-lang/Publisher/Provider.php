<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher;

use Helldar\LaravelLangPublisher\Plugins\BaseProvider;
use LaravelLang\Lang\Publisher\Plugins\Breeze;
use LaravelLang\Lang\Publisher\Plugins\Cashier;
use LaravelLang\Lang\Publisher\Plugins\Fortify;
use LaravelLang\Lang\Publisher\Plugins\Jetstream;
use LaravelLang\Lang\Publisher\Plugins\Laravel;
use LaravelLang\Lang\Publisher\Plugins\Lumen;
use LaravelLang\Lang\Publisher\Plugins\Nova;
use LaravelLang\Lang\Publisher\Plugins\SparkPaddle;
use LaravelLang\Lang\Publisher\Plugins\SparkStripe;

class Provider extends BaseProvider
{
    /**
     * Indicates the base path of the provider.
     *
     * For example, `__DIR__`
     *
     * @return string
     */
    public function basePath(): string
    {
        return realpath(__DIR__ . '/../../../vendor/laravel-lang/lang');
    }

    /**
     * @return \Helldar\Contracts\LangPublisher\Plugin[]
     */
    public function plugins(): array
    {
        return $this->resolvePlugins([
            Breeze::class,
            Cashier::class,
            Fortify::class,
            Jetstream::class,
            Laravel::class,
            Lumen::class,
            Nova::class,
            SparkPaddle::class,
            SparkStripe::class,
        ]);
    }
}
