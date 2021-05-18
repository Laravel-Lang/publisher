<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class SparkPaddle extends Package
{
    public function vendor(): string
    {
        return 'laravel/spark-paddle';
    }

    public function source(): array
    {
        return ['packages/spark-paddle.json'];
    }

    public function target(): string
    {
        return 'spark';
    }
}
