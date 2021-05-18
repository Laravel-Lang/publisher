<?php

namespace Helldar\LaravelLangPublisher\Packages;

final class Jetstream extends Package
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
