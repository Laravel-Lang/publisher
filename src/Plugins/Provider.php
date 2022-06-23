<?php

namespace LaravelLang\Publisher\Plugins;

use DragonCode\Support\Facades\Helpers\Arr;

abstract class Provider
{
    abstract public function basePath(): string;

    abstract public function plugins(): array;

    protected function resolvePlugins(array $plugins): array
    {
        return Arr::of($plugins)
            ->map(static fn (string $plugin) => new $plugin())
            ->toArray();
    }
}
