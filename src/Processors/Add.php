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

use Helldar\Contracts\LangPublisher\Provider;
use Helldar\LaravelLangPublisher\Comparators\Add as Comparator;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Path;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;

class Add extends BaseProcessor
{
    protected $comparator = Comparator::class;

    public function handle(Provider $provider): void
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
    }

    public function finish(): void
    {
        foreach ($this->compare() as $filename => $values) {
            $path = $this->resourcesPath($filename);

            Filesystem::store($path, $values);
        }
    }

    protected function collectSource(Provider $provider, string $source, string $target): void
    {
        $path = $this->vendorPath($provider->name(), Path::SOURCE, $source);

        $content = Filesystem::load($path);

        if ($this->hasJson($source)) {
            $content = $this->resolveKeys($content);
        }

        $this->setResourceKeys($target, $this->getKeysOnly($content));
        $this->setResource(Locales::ENGLISH, $target, $content);
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
            ? $this->vendorPath($provider->name(), Path::LOCALES, $locale, $locale . '.json')
            : $this->vendorPath($provider->name(), Path::LOCALES, $locale, $source);

        $content = Filesystem::load($path);

        $this->setResource($locale, $target, $content);
    }

    protected function resolveKeys(array $array): array
    {
        return Arrayable::of($array)
            ->renameKeys(static function ($key, $value) {
                return is_numeric($key) && is_string($value) ? $value : $key;
            })->get();
    }
}
