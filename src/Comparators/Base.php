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

namespace Helldar\LaravelLangPublisher\Comparators;

use Helldar\Contracts\LangPublisher\Comparator;
use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Arr;

abstract class Base implements Comparator
{
    use Has;
    use Paths;

    protected $full;

    protected $keys = [];

    protected $translations = [];

    protected $result = [];

    protected $exclude = ['attributes', 'custom'];

    public function __construct(array $keys, array $translations, bool $full = false)
    {
        $this->keys = $keys;

        $this->translations = $translations;

        $this->full = $full;
    }

    abstract protected function merge(array $local, array $translated, array $excluded): array;

    public function get(): array
    {
        foreach ($this->filenames() as $filename) {
            foreach ($this->locales($filename) as $locale) {
                $result = $this->compare($filename, $locale);

                $path = $this->resolvePath($filename, $locale);

                $this->putResult($path, $result);
            }
        }

        return $this->getResult();
    }

    protected function compare(string $filename, string $locale): array
    {
        $local      = $this->resource($filename, $locale);
        $translated = $this->translated($filename, $locale);

        $main = $this->merge(
            $this->extract($filename, $local),
            $this->extract($filename, $translated),
            $this->excludes($filename, $local),
        );

        $extra = $this->sortAndMerge(
            $this->extra($filename, $local),
            $this->extra($filename, $translated),
        );

        return Arr::merge($main, $extra);
    }

    protected function resource(string $filename, string $locale): array
    {
        $filename = $this->resolvePath($filename, $locale);

        $path = $this->resourcesPath($filename);

        return Filesystem::load($path);
    }

    protected function translated(string $filename, string $locale): array
    {
        $values = $this->translations[$filename][$locale];

        $keys = $this->keys[$filename];

        return Arr::only($values, $keys);
    }

    protected function excludes(string $filename, array $user): array
    {
        $excludes = Config::excludes();

        $key = $this->filename($filename);

        $values = Arr::get($excludes, $key, []);

        return Arr::only($user, $values);
    }

    protected function extract(string $filename, array $array): array
    {
        if ($this->hasValidation($filename)) {
            return Arr::except($array, $this->exclude);
        }

        return $array;
    }

    protected function extra(string $filename, array $array): array
    {
        if ($this->hasValidation($filename)) {
            return Arr::only($array, $this->exclude);
        }

        return [];
    }

    protected function putResult(string $filename, array $array): void
    {
        $this->result[$filename] = $array;
    }

    protected function getResult(): array
    {
        return $this->result;
    }

    protected function filenames(): array
    {
        return array_keys($this->keys);
    }

    protected function locales(string $filename): array
    {
        return array_keys($this->translations[$filename]);
    }

    protected function sortAndMerge(array ...$arrays): array
    {
        $array = Arr::merge(...$arrays);

        return $this->sort($array);
    }

    protected function sort(array $array): array
    {
        return Arr::ksort($array);
    }
}
