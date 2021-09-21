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

    public function files(): array
    {
        return [
            'packages/spark-paddle.json' => 'spark/{locale}.json',
        ];
    }
}
