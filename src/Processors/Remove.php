<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Processors;

use Helldar\Contracts\LangPublisher\Provider;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Arr;

class Remove extends BaseProcessor
{
    protected $paths = [];

    public function handle(Provider $provider): void
    {
        foreach ($this->locales as $locale) {
            $json = $this->resourcesPath($locale . '.json');
            $php  = $this->resourcesPath($locale);

            $this->push($json, $php);
        }
    }

    public function finish(): void
    {
        Filesystem::delete($this->paths);
    }

    protected function prepareLocales(array $locales): array
    {
        $except = Locales::protects();

        return Arr::except($locales, $except);
    }

    protected function push(string ...$paths): void
    {
        foreach ($paths as $path) {
            array_push($this->paths, $path);
        }
    }
}
