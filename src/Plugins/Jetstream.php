<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Jetstream extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/jetstream';
    }

    public function source(): array
    {
        return ['packages/jetstream.json'];
    }
}
