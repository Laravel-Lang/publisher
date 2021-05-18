<?php

namespace Helldar\LaravelLangPublisher\Plugins;

final class Nova extends Plugin
{
    public function vendor(): string
    {
        return 'laravel/nova';
    }

    public function source(): array
    {
        return ['packages/nova.json'];
    }

    public function target(): ?string
    {
        return 'vendor/nova';
    }
}
