<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as Contract;
use Helldar\Support\Facades\Helpers\Str;

final class Manager implements Contract
{
    use Containable;

    public function load(string $path): array
    {
        return $this->filesystem($path)->load($path);
    }

    public function store(string $path, array $content)
    {
        return $this->filesystem($path)->store($path, $content);
    }

    protected function filesystem(string $path): Contract
    {
        return $this->isJson($path)
            ? $this->container(Json::class)
            : $this->container(Php::class);
    }

    protected function isJson(string $path): bool
    {
        return Str::endsWith($path, '.json');
    }
}
