<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class SparkStripe extends Package
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
        return 'spark';
    }
}
