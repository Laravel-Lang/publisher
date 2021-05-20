<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class SparkPaddle extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/spark-paddle';
    }

    public function source(): array
    {
        return ['packages/spark-paddle.json'];
    }

    public function target(): ?string
    {
        return 'spark';
    }
}
