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

use Helldar\Contracts\LangPublisher\Processor;
use Helldar\Contracts\LangPublisher\Provider;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Path;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class BaseProcessor implements Processor
{
    use Paths;

    protected $force = false;

    protected $locales = [];

    protected $source_keys = [];

    protected $locales_keys = [];

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
                $this->loadSource($provider, $source, $plugin->target());
            }
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

    protected function loadSource(Provider $provider, string $source, string $target): void
    {
        $path = $this->path($provider->basePath(), Path::SOURCE, $source);

        $filename = $this->preparePath($target, Locales::ENGLISH);

        $content = Filesystem::load($path);

        $this->set($this->source_keys, $filename, $content);
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
}
