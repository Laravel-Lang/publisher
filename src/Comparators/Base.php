<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Comparators;

use DragonCode\Contracts\LangPublisher\Comparator;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Concerns\Arrayable;
use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Concerns\Paths;
use LaravelLang\Publisher\Facades\Helpers\Config;
use LaravelLang\Publisher\Facades\Support\Filesystem;

abstract class Base implements Comparator
{
    use Arrayable;
    use Has;
    use Paths;

    protected $full;

    protected $keys = [];

    protected $translations = [];

    protected $result = [];

    protected $exclude = ['attributes', 'custom'];

    abstract protected function merge(array $local, array $translated, array $excluded): array;

    public function __construct(array $keys, array $translations, bool $full = false)
    {
        $this->keys = $keys;

        $this->translations = $translations;

        $this->full = $full;
    }

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

        return $this->mergeArray($main, $extra);
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
}
