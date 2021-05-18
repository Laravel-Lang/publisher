<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class SparkStripe extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/spark-stripe';
    }

    public function source(): array
    {
        return ['packages/spark-stripe.json'];
    }

    public function target(): ?string
    {
        return 'spark';
    }
}
