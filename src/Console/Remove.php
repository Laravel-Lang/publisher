<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Exceptions\UnknownLocaleCodeException;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Processors\Processor;
use LaravelLang\Publisher\Processors\Remove as RemoveProcessor;

class Remove extends Base
{
    protected $signature = 'lang:rm {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Remove localizations.';

    protected Processor|string $processor = RemoveProcessor::class;

    protected function locales(): array
    {
        return Arr::of((array) $this->argument('locales'))
            ->tap(fn (string $locale) => Locales::isInstalled($locale) || throw new UnknownLocaleCodeException($locale))
            ->toArray();
    }
}
