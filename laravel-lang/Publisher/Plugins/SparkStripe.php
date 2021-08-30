<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class SparkStripe extends BasePlugin
{
    public function vendor(): string
    {
        return 'laravel/spark-stripe';
    }

    public function source(): array
    {
        return ['packages/spark-stripe.json'];
    }

    public function target(): string
    {
        return 'spark/{locale}.json';
    }
}
