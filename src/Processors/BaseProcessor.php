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
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Support\Str;

abstract class BaseProcessor implements Processor
{
    use Has;
    use Keyable;
    use Paths;

    /** @var Provider */
    protected $provider;

    protected $locales = [];

    protected $source_keys = [];

    protected $translated = [];

    /** @var \Helldar\Contracts\LangPublisher\Comparator */
    protected $comparator;

    public function __construct(array $locales)
    {
        $this->locales = $this->prepareLocales($locales);
    }

    protected function compare(): array
    {
        return (new $this->comparator($this->source_keys, $this->translated))->get();
    }

    protected function set(array &$array, string $key, array $values): void
    {
        $loaded = $array[$key] ?? [];

        $array[$key] = Arr::merge($loaded, $values);
    }

    protected function preparePath(string $path, string $locale): string
    {
        return Str::replace('{locale}', $locale, $path);
    }

    protected function prepareLocales(array $locales): array
    {
        return $locales;
    }
}
