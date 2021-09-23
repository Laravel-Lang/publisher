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
use Helldar\LaravelLangPublisher\Resources\Translation;

abstract class BaseProcessor implements Processor
{
    use Has;
    use Keyable;
    use Paths;

    /** @var Provider */
    protected $provider;

    /** @var array */
    protected $locales = [];

    /** @var \Helldar\LaravelLangPublisher\Resources\Translation */
    protected $resources;

    /** @var \Helldar\Contracts\LangPublisher\Comparator */
    protected $comparator;

    /** @var bool */
    protected $full;

    public function __construct(array $locales, bool $full)
    {
        $this->locales = $this->prepareLocales($locales);

        $this->resources = Translation::make();

        $this->full = $full;
    }

    protected function compare(): array
    {
        $keys  = $this->resources->getKeys();
        $trans = $this->resources->getTranslations();

        return (new $this->comparator($keys, $trans, $this->full))->get();
    }

    protected function prepareLocales(array $locales): array
    {
        return $locales;
    }

    protected function setResourceKeys(string $target, array $keys): void
    {
        $this->resources->keys($target, $keys);
    }

    protected function setResource(string $locale, string $target, array $translations): void
    {
        $this->resources->translation($locale, $target, $translations);
    }
}
