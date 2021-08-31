<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Processors;

use Helldar\Contracts\LangPublisher\Plugin;
use Helldar\Contracts\LangPublisher\Processor;
use Helldar\Contracts\LangPublisher\Provider;
use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Path;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class BaseProcessor implements Processor
{
    use Has;
    use Paths;

    protected $force = false;

    protected $locales = [];

    protected $source_keys = [];

    protected $translates = [];

    public function locales(array $locales): Processor
    {
        $this->locales = $locales;

        return $this;
    }

    public function provider(Provider $provider): Processor
    {
        foreach ($provider->plugins() as $plugin) {
            if (! $plugin->has()) {
                continue;
            }

            foreach ($plugin->source() as $source) {
                $this->collectSource($provider, $source, $plugin->target());
            }

            $this->collectLocales($provider, $plugin);
        }

        return $this;
    }

    public function store(): void
    {
        // TODO: Implement store() method.
    }

    public function hasForce(bool $force = false): Processor
    {
        $this->force = $force;

        return $this;
    }

    protected function collectSource(Provider $provider, string $source, string $target): void
    {
        $path = $this->path($provider->basePath(), Path::SOURCE, $source);

        $filename = $this->preparePath($target, Locales::ENGLISH);

        $content = Filesystem::load($path);

        if ($this->hasJson($source)) {
            $content = $this->resolveKeys($content);
        }

        $this->set($this->source_keys, $filename, $this->getKeysOnly($content));
        $this->set($this->translates, Locales::ENGLISH, $content);
    }

    protected function collectLocales(Provider $provider, Plugin $plugin): void
    {
        foreach ($this->locales as $locale) {

        }
    }

    protected function set(array &$array, string $key, array $values): void
    {
        $loaded = Arr::get($array, $key, []);

        Arr::set($array, $key, array_merge_recursive($loaded, $values));
    }

    protected function preparePath(string $path, string $locale): string
    {
        return Str::replace('{locale}', $locale, $path);
    }

    protected function resolveKeys(array $array): array
    {
        return Arrayable::of($array)
            ->renameKeys(static function ($key, $value) {
                return is_numeric($key) && is_string($value) ? $value : $key;
            })->get();
    }

    protected function getKeysOnly(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->getKeysOnly($array);

                continue;
            }

            array_push($result, $key);
        }

        return $result;
    }
}
