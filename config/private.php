<?php

use Helldar\LaravelLangPublisher\Plugins\{Cashier, Fortify, Framework, Jetstream, Lumen, Nova, SparkPaddle, SparkStripe};

return [
    'packages' => [
        'laravel-lang/lang',
    ],

    'plugins' => [
        Cashier::class,
        Fortify::class,
        Framework::class,
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
