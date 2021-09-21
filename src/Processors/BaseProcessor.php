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
use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Concerns\Keyable;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Path;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Illuminate\Support\Str;

abstract class BaseProcessor implements Processor
{
    use Has;
    use Keyable;
    use Paths;

    protected $force = false;

    protected $locales = [];

    protected $source_keys = [];

    protected $translated = [];

    public function __construct(array $locales, bool $force = false)
    {
        $this->locales = $locales;
        $this->force   = $force;
    }

    public function provider(Provider $provider): Processor
    {
        foreach ($provider->plugins() as $plugin) {
            if (! $plugin->has()) {
                continue;
            }

            foreach ($plugin->files() as $source => $target) {
                $this->collectSource($provider, $source, $target);
                $this->collectLocales($provider, $source, $target);
            }
        }

        return $this;
    }

    public function source(): array
    {
        return $this->source_keys;
    }

    public function translated(): array
    {
        return $this->translated;
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
        $this->set($this->translated, $filename, $content);
    }

    protected function collectLocales(Provider $provider, string $source, string $target): void
    {
        foreach ($this->locales as $locale) {
            $this->collectLocale($provider, $locale, $source, $target);
        }
    }

    protected function collectLocale(Provider $provider, string $locale, string $source, string $target): void
    {
        $path = $this->hasJson($source)
            ? $this->path($provider->basePath(), Path::LOCALES, $locale, $locale . '.json')
            : $this->path($provider->basePath(), Path::LOCALES, $locale, $source);

        $filename = $this->preparePath($target, $locale);

        $content = Filesystem::load($path);

        $this->set($this->translated, $filename, $content);
    }

    protected function set(array &$array, string $key, array $values): void
    {
        $loaded = $array[$key] ?? [];

        $array[$key] = array_merge_recursive($loaded, $values);
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
}
