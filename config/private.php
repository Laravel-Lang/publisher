<?php

use Helldar\LaravelLangPublisher\Plugins\Cashier;
use Helldar\LaravelLangPublisher\Plugins\Fortify;
use Helldar\LaravelLangPublisher\Plugins\Jetstream;
use Helldar\LaravelLangPublisher\Plugins\Laravel;
use Helldar\LaravelLangPublisher\Plugins\Lumen;
use Helldar\LaravelLangPublisher\Plugins\Nova;
use Helldar\LaravelLangPublisher\Plugins\SparkPaddle;
use Helldar\LaravelLangPublisher\Plugins\SparkStripe;

return [
    'packages' => [
        'laravel-lang/lang',
    ],

    'plugins' => [
        Cashier::class,
        Fortify::class,
        Laravel::class,
        Jetstream::class,
        Lumen::class,
        Nova::class,
        SparkPaddle::class,
        SparkStripe::class,
    ],

    'path' => [
        'base' => base_path('vendor'),

        'source' => 'source',

        'locales' => 'locales',

        'target' => resource_path('lang'),
    ],
];
