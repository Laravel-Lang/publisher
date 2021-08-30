<?php

declare(strict_types=1);

namespace LaravelLang\Lang\Publisher\Plugins;

use Helldar\LaravelLangPublisher\Plugins\BasePlugin;

class SparkPaddle extends BasePlugin
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
        return 'spark/{locale}.json';
    }
}
