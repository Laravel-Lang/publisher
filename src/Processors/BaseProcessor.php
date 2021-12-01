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

namespace LaravelLang\Publisher\Processors;

use DragonCode\Contracts\LangPublisher\Processor;
use DragonCode\Contracts\LangPublisher\Provider;
use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Concerns\Keyable;
use LaravelLang\Publisher\Concerns\Paths;
use LaravelLang\Publisher\Resources\Translation;

abstract class BaseProcessor implements Processor
{
    use Has;
    use Keyable;
    use Paths;

    /** @var Provider */
    protected $provider;

    /** @var array */
    protected $locales = [];

    /** @var \LaravelLang\Publisher\Resources\Translation */
    protected $resources;

    /** @var \DragonCode\Contracts\LangPublisher\Comparator */
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
