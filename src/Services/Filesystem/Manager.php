<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as Contract;

final class Manager implements Contract
{
    use Containable;
    use Contains;
    use Logger;

    public function load(string $path, string $main_path = null): array
    {
        $this->log('Loading data from an array:', $path, $main_path);

        return $this->filesystem($path)->load($path, $main_path);
    }

    public function store(string $path, array $content)
    {
        $this->log('Saving an array to a file:', $path);

        return $this->filesystem($path)->store($path, $content);
    }

    public function ensureKeys(string $path): void
    {
        $content = $this->load($path);

        $this->store($path, $content);
    }

    protected function filesystem(string $path): Contract
    {
        $this->log('Getting an object for working with files by the path:', $path);

        return $this->isJson($path)
            ? $this->container(Json::class)
            : $this->container(Php::class);
    }
}
